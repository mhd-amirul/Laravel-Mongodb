<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthentikasiController extends Controller
{
    public function resgiter(Request $request)
    {
        $data = $request->all();
        $val = Validator::make($data, [
            "first_name" => "required|min:3|max:20",
            "last_name" => "required|min:3|max:20",
            "username" => "required|min:3|max:20|unique:users,username",
            "password" => "required|min:5",
            "address" => "required",
            "phone_number" => "required",
            "photo" => "required"
        ]);

        if ($val->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $val->errors()
            ]);
        }

        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        return response()->json([
            'status' => 'success',
            'message' => 'Sign Up Successfully',
            'data' => $user
        ]);
    }

    public function login(Request $request)
    {
        $val = Validator::make($request->all(), [
            "username" => "required",
            "password" => "required",
        ]);

        if ($val->fails()) {
            return response()->json([
                'status' => 'failed',
                'message' => $val->errors()
            ]);
        }

        $user = User::where('username', $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'failed',
                'message' => 'Login Failed'
            ]);
        }

        $token = $user->createToken('token')->plainTextToken;
        return response()->json([
            'status' => 'success',
            'message' => 'Login Succesfully',
            'data' => ['token' => $token, 'user' => $user]
        ]);
    }

    public function profil()
    {
        $user = User::where('username', auth()->user()->username)->first();
        return response()->json($user);
    }
}
