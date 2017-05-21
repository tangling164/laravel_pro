<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;


class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest',['only'=>['create']]);
    }
    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        $credentials = [
            'email'    => $request->input('email'),
            'password'=>$request->input('password'), ];

        if (Auth::attempt($credentials,$request->has('remeber'))) {
            session()->flash('success', 'Welcome!');
            return redirect()->intended(route('users.show', [Auth::user()]));
        } else {
            session()->flash('danger', 'Incorrect username or password.');
            return redirect()->back();
        }
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success','You have sign out successfully');
        return redirect('login');
    }
}