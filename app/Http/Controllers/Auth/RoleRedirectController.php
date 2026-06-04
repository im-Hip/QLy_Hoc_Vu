<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleRedirectController extends Controller
{
    public function redirect()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        } elseif ($user->role === 'teacher') {
            return redirect('/teacher/dashboard');
        }
        return redirect('/student/dashboard');
    }
}
