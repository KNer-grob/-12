<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserAuthRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController
{
    /**
     * Display a listing of the resource.
     */
    public function register(UserRegisterRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();
        return response()->json(["token" => $user->createToken('api')->plainTextToken]);
    }

    public function login(UserAuthRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                Auth::login($user);
                if ($user->role == 'admin') {
                    return response()->json(["token" => $user->createToken('api')->plainTextToken]);
                }
                return response()->json(["token" => $user->createToken('api')->plainTextToken]);
            }
        }
        return response()->json(['errors' => ['login' => 'не верный логин или пароль']], 401);
    }
     public function user(){
         return response()->json(['user' => Auth::user()]);
    }
     public function usersSpisok()
    {
        return User::where('role', 'user')->get();
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
