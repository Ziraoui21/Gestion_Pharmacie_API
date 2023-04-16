<?php

namespace App\Http\Controllers;

use App\Mail\AuthMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function users()
    {
        return response()->json(
            User::with('role')->whereNot('id','=',auth()->user()->id)->get()
        );
    }

    public function create(Request $request)
    {
        $input = $request->only('email');

        $request_data = [
            'email' => 'unique:users,email',
        ];

        $validator = Validator::make($input, $request_data);

        if(!$validator->fails())
        {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role_id' => $request->role_id
            ]);

            Mail::to($user->email)->send(new AuthMail($user,$request->password));

            return response()->json(['status' => true]);
        }
            
        return response()->json(['status' => false]);
    }

    public function setAdmin(Request $request)
    {
        $user = User::find($request->id);

        $user->update([
            'role_id' => 1
        ]);

        return response()->json(['status' => true]);
    }

    public function delete(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();

        return response()->json(['status' => true]);
    }

}
