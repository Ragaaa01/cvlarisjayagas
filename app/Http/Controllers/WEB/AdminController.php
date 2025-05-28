<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function adminDashboard()
    {
        if (auth()->user()->role !== 'administrator') {
            abort(403);
        }

        return view('admin.pages.index', [
            'user' => auth()->user()
        ]);
    }
}
