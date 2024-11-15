<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostStoreRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'asc')->paginate(5);
        return view('pages.user', ['models' => $users]);
    }

    public function user_create()
    {
        return view('tables.createPages.user-create');
    }

    public function store(UserStoreRequest $request)
    {
        // dd($request->all());

        User::create($request->all());
        return redirect('/')->with('success', 'Ma\'lumot qo\'shildi!');
    }

    public function delete(User $user)
    {
        // dd($user);
        $user->delete();
        return redirect('/')->with('danger', 'Ma\'lumot o\'chirildi!');
    }

    public function show(User $user)
    {
        return view('tables.showPages.user-show', ['user' => $user]);
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('pages.update.user-update', ['user' => $user, 'roles' => $roles]);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'role_id' => 'required|array',
        ]);

        $user->roles()->sync($request->role_id);

        return redirect('/users')->with('warning', 'Ma\'lumot yangilandi!');
    }

    public function search(Request $request)
    {
        $users = User::where('name', 'like', '%' . $request->search . '%')->orderBy('id', 'asc')->paginate(2);
        return view('tables/users', ['users' => $users]);

    }
}
