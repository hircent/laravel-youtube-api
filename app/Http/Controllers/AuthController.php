<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Traits\HttpResponses;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    use HttpResponses;
    use HasApiTokens;

    public function login(LoginUserRequest $request){
        // no need $request->validated($request->all());
        $request->validated();

        if(!Auth::attempt($request->only(['email','password']))){
            return $this->error($request->all(),'Credentials do not match',401);
        }

        $user = User::where('email',$request->email)->first();

        return $this->success([
            'user'=>$user,
            'token'=>$user->createToken('API token of '.$user->name)->plainTextToken

        ]);
    }

    public function register(StoreUserRequest $request)
    {
        // check if form filled-in is validated
        $request->validated($request->all());

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password)
        ]);

        // $this->success() is coming from traits
        return $this->success([
            'user'=>$user,
            // createToken from User object which return laravel sanctum access token instance
            'token'=>$user->createToken('API token of'.$user->name)->plainTextToken
        ]);
    }

    public function logout(){
        Auth::user()->currentAccessToken()->delete();

        return $this->success([
            'message' => 'You have successfully been logout and token has been deleted.'
        ]);
    }
}
