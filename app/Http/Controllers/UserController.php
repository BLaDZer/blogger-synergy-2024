<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    public function login(Request $request): View
    {
        return view('user.login');
    }

    public function loginFormAction(Request $request): View
    {
        $validatedData = $request->validate(
            [
                'email' => 'required|email|exists:users',
                'password' => 'required|password',
            ]
        );

        $request->session()->flash('success', 'Task was successful!');

        return die('COOL');
    }

    public function register(): View
    {
        return view('user.register');
    }

    public function registerFormAction(Request $request): View
    {
        $validatedData = $request->validate(
            [
                'email' => 'required|email|max:255|unique:users',
                'password' => 'required|password|min:5',
                'password_repeat' => 'required|same:password',
            ]
        );

        return die('COOL');
    }
}
