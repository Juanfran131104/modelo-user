<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   
    private function checkCredentials($email, $password)
    {
        $user = User::where('email', $email)->first();
        
        if (!$user || !Hash::check($password, $user->password)) {
            return null;
        }
        
        return $user;
    }

    public function index()
    {
        $users = User::paginate(10);
        return response()->json($users, 200);
    }

    public function create(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->username, 
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json(['message' => 'Usuario creado con éxito', 'user' => $user], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = $this->checkCredentials($request->email, $request->password);

        if (!$user) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        return response()->json(['message' => 'Login exitoso', 'user' => $user], 200);
    }

    public function updateUsername(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'new_username' => 'required|string|max:255'
        ]);

        $user = $this->checkCredentials($request->email, $request->password);

        if (!$user) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        $user->name = $request->new_username;
        $user->save();

        return response()->json(['message' => 'Username actualizado con éxito', 'user' => $user], 200);
    }

    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'new_email' => 'required|email|unique:users,email'
        ]);

        $user = $this->checkCredentials($request->email, $request->password);

        if (!$user) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        $user->email = $request->new_email;
        $user->save();

        return response()->json(['message' => 'Email actualizado con éxito', 'user' => $user], 200);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'new_password' => 'required|string|min:6'
        ]);

        $user = $this->checkCredentials($request->email, $request->password);

        if (!$user) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Contraseña actualizada con éxito'], 200);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = $this->checkCredentials($request->email, $request->password);

        if (!$user) {
            return response()->json(['message' => 'Credenciales incorrectas'], 401);
        }

        $user->delete();

        return response()->json(['message' => 'Usuario eliminado con éxito'], 200);
    }
}