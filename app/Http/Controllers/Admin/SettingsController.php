<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function index()
    {
        // Check if user is authorized (ID 2)
        if (Auth::id() != 2) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access the admin dashboard.');
        }
        
        return view('admin.settings.index');
    }
}
