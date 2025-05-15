<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public static function middleware(): array
    {
        return [
            'guest' => ['except' => ['store']]
        ];
    }

    public function showRegistrationForm()
    {
        $roles = Role::whereIn('slug', ['project_leader', 'team_member'])->get();
        return view('auth.register', compact('roles'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role_id' => ['required', 'exists:roles,id'],
            'phone' => ['required', 'string', 'max:20'],
            'position' => ['required', 'string', 'max:100'],
        ], [
            'role_id.exists' => 'El rol seleccionado no es válido.',
            'role_id.required' => 'Debe seleccionar un rol.',
        ]);
    }

    public function store(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $role = Role::find($request->role_id);
        if (!in_array($role->slug, ['project_leader', 'team_member'])) {
            return redirect()->back()
                ->withErrors(['role_id' => 'El rol seleccionado no está permitido para registro.'])
                ->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'phone' => $request->phone,
            'position' => $request->position,
        ]);

        auth()->login($user);

        return redirect()->route('dashboard');
    }
} 