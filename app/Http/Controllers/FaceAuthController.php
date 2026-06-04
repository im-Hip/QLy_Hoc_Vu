<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class FaceAuthController extends Controller
{
    private const DESCRIPTOR_SIZE = 128;

    public function create(): View
    {
        return view('face.register', [
            'hasFaceDescriptor' => Auth::user()->face_descriptor !== null,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $descriptor = $this->validateDescriptor($request);

        $request->user()->forceFill([
            'face_descriptor' => $descriptor,
            'face_registered_at' => now(),
        ])->save();

        return response()->json([
            'message' => 'Đã lưu khuôn mặt cho tài khoản hiện tại.',
        ]);
    }

    public function login(Request $request): JsonResponse
    {
        $descriptor = $this->validateDescriptor($request);
        $threshold = (float) config('face_auth.threshold', 0.6);

        $bestUser = null;
        $bestDistance = INF;

        User::query()
            ->whereNotNull('face_descriptor')
            ->select(['id', 'name', 'email', 'role', 'face_descriptor'])
            ->chunkById(100, function ($users) use ($descriptor, &$bestUser, &$bestDistance) {
                foreach ($users as $user) {
                    $stored = $user->face_descriptor;

                    if (! is_array($stored) || count($stored) !== self::DESCRIPTOR_SIZE) {
                        continue;
                    }

                    $distance = $this->euclideanDistance($descriptor, $stored);
                    if ($distance < $bestDistance) {
                        $bestDistance = $distance;
                        $bestUser = $user;
                    }
                }
            });

        if (! $bestUser) {
            return response()->json([
                'message' => 'Chưa có tài khoản nào đăng ký khuôn mặt.',
            ], 404);
        }

        if ($bestDistance > $threshold) {
            return response()->json([
                'message' => 'Khuôn mặt không khớp. Vui lòng thử lại hoặc đăng nhập bằng email/mật khẩu.',
                'distance' => round($bestDistance, 4),
                'threshold' => $threshold,
            ], 422);
        }

        Auth::login($bestUser);
        $request->session()->regenerate();

        return response()->json([
            'message' => 'Đăng nhập bằng khuôn mặt thành công.',
            'redirect' => route('dashboard'),
            'distance' => round($bestDistance, 4),
        ]);
    }

    private function validateDescriptor(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'descriptor' => ['required', 'array', 'size:' . self::DESCRIPTOR_SIZE],
            'descriptor.*' => ['required', 'numeric'],
        ], [
            'descriptor.required' => 'Không nhận được dữ liệu khuôn mặt.',
            'descriptor.array' => 'Dữ liệu khuôn mặt không hợp lệ.',
            'descriptor.size' => 'Descriptor phải có đúng ' . self::DESCRIPTOR_SIZE . ' giá trị.',
            'descriptor.*.numeric' => 'Descriptor chỉ được chứa số.',
        ]);

        $validator->validate();

        return array_map('floatval', $request->input('descriptor'));
    }

    private function euclideanDistance(array $a, array $b): float
    {
        $sum = 0.0;

        for ($i = 0; $i < self::DESCRIPTOR_SIZE; $i++) {
            $diff = (float) $a[$i] - (float) $b[$i];
            $sum += $diff * $diff;
        }

        return sqrt($sum);
    }
}