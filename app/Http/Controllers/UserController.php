<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
//        $this->middleware('log')->only('index');
//        $this->middleware('subscribed')->except('store');
    }

    public function show(string $id): View
    {
        return view('user.profile', [
            'user' => User::findOrFail($id)
        ]);
    }





}
