<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Partner;
use Illuminate\Http\Request;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    use ApiResponser;

    public function register(Request $request){

        $attr = $request->validate([   
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|unique:users,email',
            'password'  => 'required|string|min:6|confirmed'
        ]);

        $user = User::create([
            'name'      => $attr['name'],
            'email'     => $attr['email'],
            'password'  => Hash::make($attr['password']),
        ]);

        Device::create(
            [
                'token' => $request->device_token,
                'user_id' => auth()->user()->id
            ]
        );

        return $this->success([
            'token'     => $user->createToken('auth_token')->plainTextToken
        ]);

    }

    public function partnerRegister(Request $request){

        $attr = $request->validate([   
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|unique:users,email',
            'password'  => 'required|string|min:6|confirmed'
        ]);

        $user = User::create([
            'name'      => $attr['name'],
            'email'     => $attr['email'],
            'password'  => Hash::make($attr['password']),
            'role'      => 'partner'
        ]);

        $partner = Partner::create([
            'name'    => $request->partner_name,
            'user_id' => $user->id,
            'phone'   => $request->phone,
            'address' => $request->address
        ]);

        Device::create(
            [
                'token' => $request->device_token,
                'user_id' => auth()->user()->id
            ]
        );

        return $this->success([
            'token'     => $user->createToken('auth_token')->plainTextToken,
            'device_token'      => $request->device_token
        ]);

    }

    public function login(Request $request){

        $attr = $request->validate([
            'email'     => 'required|string|email',
            'password'  => 'required|string|min:6'
        ]);
        
        if (!Auth::attempt($attr)) {
            return $this->error('Credentials not match', 401);
        }
        
        $partner = Partner::where('user_id', auth()->user()->id)->first();

        Device::create(
            [
                'token' => $request->device_token,
                'user_id' => auth()->user()->id
            ]
        );

        return $this->success([
            'user'              => auth()->user(),
            'partner'           => $partner,
            'token'             => auth()->user()->createToken('auth_token')->plainTextToken,
            'device_token'      => $request->device_token
        ]);

    }

    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        $device = Device::where('user_id', '=', auth()->user()->id);
        $device->delete();
        return $this->success([], 'Token revoked');
    }

}
