<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


use App\Jobs\SendEmailCode;
use App\Models\User;
use App\Models\VerifyCode;
use Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginPage()
    {
        return view('login-register.loginPage');
    }

    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|min:5'
            ]
        );
        // dd($request->all());
        if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password])){
            $user = Auth::user();
            return redirect('/');
        }else{
            return redirect('/login');
        }
    }


    public function registerPage()
    {
        return view('login-register.registerPage');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => 'required|max:255'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email'=> $request->email,
            'password' =>Hash::make($request->password),
        ]);
        event(new Registered($user));

        Auth::login($user);
        $code = rand(1000, 9999);

        $data = VerifyCode::create([
            'user_id' => $user->id,
            'code' => $code,
        ]);
        SendEmailCode::dispatch($user->email, $data);
        return redirect('/registerVerify');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function registerVerify()
    {
        return view('login-register.registerVerify');
    }

    public function verify(Request $request)
    {
        $user = User::findOrFail(auth()->user()->id);
        $verify = VerifyCode::where('user_id', $user->id)->first();

        $code = $request->code;
        
        if ($code == $verify->code) {
            $date = date('Y-m-d H:m:s');
            $verify_email = ['email_verified_at' => $date];
            $user->update(['email_verified_at' => $date]);
            return redirect('/');
        } else {
            return back();
        }
    }
}
