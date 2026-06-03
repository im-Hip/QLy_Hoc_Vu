@extends('layouts.app')

@section('title', 'Đăng ký khuôn mặt')

@section('content')
<div class="container mx-auto p-6">
    <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-xl border border-blue-50 overflow-hidden">
        <div class="p-8 border-b border-gray-100">
            <h1 class="text-3xl font-bold text-gray-800">Đăng ký khuôn mặt</h1>
            <p class="mt-2 text-gray-600">Hệ thống chỉ lưu descriptor JSON, không lưu ảnh gốc từ webcam.</p>
        </div>

        <div class="p-8" data-face-mode="enroll" data-face-submit-url="{{ route('face.store') }}">
            @if ($hasFaceDescriptor)
                <div class="mb-5 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-green-700">
                    Tài khoản này đã có dữ liệu khuôn mặt. Bạn có thể ghi đè bằng descriptor mới.
                </div>
            @endif

            <div class="grid gap-6 lg:grid-cols-[minmax(0,1fr)_280px]">
                <div class="rounded-xl bg-gray-900 p-3">
                    <video data-face-video autoplay muted playsinline class="h-[360px] w-full rounded-lg bg-black object-cover"></video>
                </div>

                <div class="space-y-4">
                    <div data-face-status class="rounded-lg border border-blue-100 bg-blue-50 px-4 py-3 text-sm text-blue-700">
                        Bấm mở webcam, nhìn thẳng camera và chỉ để một khuôn mặt trong khung hình.
                    </div>

                    <button type="button" data-face-start class="w-full rounded-lg bg-blue-600 px-5 py-3 font-semibold text-white hover:bg-blue-700">
                        Mở webcam
                    </button>

                    <button type="button" data-face-capture class="w-full rounded-lg bg-green-600 px-5 py-3 font-semibold text-white hover:bg-green-700" disabled>
                        Lưu descriptor
                    </button>

                    <a href="{{ route('profile') }}" class="block text-center text-sm font-semibold text-gray-600 hover:text-blue-600">
                        Quay lại hồ sơ
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection