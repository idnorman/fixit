<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    use ApiResponser;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return $this->success(['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = User::find(auth()->user()->id);

        if($request->password){
            $passwordRules = 'confirmed';
        }else{
            $passwordRules = '';
        }

        $attr = $request->validate([   
            'name'      => 'required|string|max:255',
            'phone'     => 'required|numeric',
            'password'  => $passwordRules
        ]);

        $attr['password'] = $user->password;
        if($request->password){
            $data['password'] = Hash::make($request->password);
        }

        $user->update([
            'name'      => $attr['name'],
            'password'  => $attr['password']
        ]);

        return $this->success([
            'token'     => $user->createToken('auth_token')->plainTextToken
        ]);
    }

    public function getUser($id){
        $user = User::find($id)->first();
        return $this->success(['user' => $user]);
    }

    public function getUsers($id){
        $users = User::all();
        return $this->success(['users' => $users]);
    }

    public function getUserByPartner($id){
        $partner = Partner::with('user')->where('id', $id)->first();

        $partner ? $user = $partner->user : $user = null;

        return $this->success(['user' => $user]);
    }

    public function getUserRole($id){
        $role = User::find($id)->select('role')->first()->role;
        if($role){
            return $this->success(['role' => $role]);
        }else{
            return $this->error('User tidak ditemukan', 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
