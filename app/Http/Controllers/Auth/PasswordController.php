<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class PasswordController extends Controller
{
    /**
     * Show the form to change the user's password.
     */
    public function showChangeForm(Request $request): View
    {
        return view('auth.change-password');
    }

    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $redirectRoute = 'dashboard';
        
        if ($request->user()->isAdmin()) {
            $redirectRoute = 'admin.dashboard';
        } elseif ($request->user()->isHR()) {
            $redirectRoute = 'hr.dashboard';
        }
        
        return redirect()->route($redirectRoute)->with('status', 'password-updated');
    }
}
