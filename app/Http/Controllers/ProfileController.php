<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Jobs\SendPassword;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::findOrFail(auth()->user()->id);
        return view('pages.profile', ['user'=>$user]);
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        $user = User::findOrFail(auth()->user()->id);
        $password = rand(10000000, 99999999);
        $user->update(['password'=> Hash::make($password)]);
        SendPassword::dispatch($user->email, $password);
        return redirect('/profile')->with('success', 'Emailga parol yuborildi!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
