<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // login form
    public function loginForm()
    {  
        return view('auth.login');
    }

    // login submit
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($request->only('email','password'))) {
            $user = Auth::user();

            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            }
            $permissions = $user->getPermissionsViaRoles();
            $userPermissions = [];
            foreach ($permissions as $permission) {
                $userPermissions[] = $permission->name;
            }
            if ($user->hasRole('employee')) {
                return redirect()->route('employee.dashboard', ['permissions' => $userPermissions]);
            }

            Auth::logout();
            return back()->with('error','No role assigned');
        }

        return back()->with('error','Invalid credentials');
    }

    // logout
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
