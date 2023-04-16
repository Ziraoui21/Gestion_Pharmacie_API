<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if(Auth::attempt($request->all(),true))
        {
            $user = User::whereEmail($request->email)->first();
            $role = $user->role->name;

            $token = $user->createToken('auth_user',[$role])->plainTextToken;

            return response()->json([
                'id' => $user->id,
                'email' => $user->email,
                'name' => $user->name,
                'token' => $token,
                'role' => $role,
                'response' => ['status' => true]
            ]);
        }
        else
        {
            return response()->json([
                'response' => ['status' => false]
            ]);
        }
    }

    public function edittUser(Request $request)
    {
        $user = User::find($request->id);

        if($this->checkEmail($request))
        {
            if(isset($request->newPassword))
            {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->newPassword)
                ]);
            }
            else
            {
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                ]);
            }

            return response()->json(['status' => true]);
        }
        else
        {
            return response()->json(['status' => false]);
        }
    }

    public function checkEmail(Request $request)
    {
        $input = $request->only('email');
        $user = User::find($request->id);
        
        $request_data = [
            'email' => 'unique:users,email,'.$request->id,
        ];

        $validator = Validator::make($input, $request_data);

        if($validator->fails())
            return false;
        else
            return true;
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json(['status' => true]);
    }
}
