<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('superadmin')) {
            return view('dashboard.superadmin');
        } elseif ($user->hasRole('dosen')) {
            return view('dashboard.dosen');
        } elseif ($user->hasRole('tendik')) {
            return view('dashboard.tendik');
        }

        // Fallback untuk role lain atau jika tidak punya role
        return view('dashboard');
    }
}