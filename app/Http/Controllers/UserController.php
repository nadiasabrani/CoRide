<?php

namespace App\Http\Controllers;

use App\Models\Employe;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();

        return view('users.index', compact('users'));
    }
}
