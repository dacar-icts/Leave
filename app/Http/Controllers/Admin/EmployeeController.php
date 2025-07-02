<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{


    public function create()
    {
        // Check if user is authorized (ID 2)
        if (Auth::id() != 2) {
            return redirect()->route('dashboard')->with('error', 'You do not have permission to access the admin dashboard.');
        }
        
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        // Check if user is authorized (ID 2)
        if (Auth::id() != 2) {
            return response()->json(['error' => 'Unauthorized access'], 403);
        }
        
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'middle_initial' => 'nullable|string|max:2',
            'email' => 'nullable|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'position' => 'required|string|max:255',
            'offices' => 'required|string|max:255',
        ]);

        // Format name as: LAST NAME, FIRST NAME MIDDLE INITIAL (all caps)
        $firstName = strtoupper(trim($request->first_name));
        $lastName = strtoupper(trim($request->last_name));
        $middleInitial = strtoupper(trim($request->middle_initial ?? ''));
        
        $formattedName = $lastName . ', ' . $firstName;
        if (!empty($middleInitial)) {
            $formattedName .= ' ' . $middleInitial;
        }

        $user = new User();
        $user->name = $formattedName;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->position = $request->position;
        $user->offices = $request->offices;
        $user->save();

        return response()->json(['success' => true, 'message' => 'Employee added successfully']);
    }
}
