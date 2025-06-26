<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (Auth::id() != 2) {
                return redirect()->route('dashboard')->with('error', 'You do not have permission to access the admin dashboard.');
            }
            return $next($request);
        });
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        // Check if user is authorized (ID 2)
        if (Auth::id() != 2) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'position' => 'required|string|max:255',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email ?? $request->name . '@example.com';
        $user->password = Hash::make($request->password);
        $user->position = $request->position;
        $user->save();

        return response()->json(['success' => true, 'message' => 'Employee added successfully']);
    }
}
