<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        if(Auth::user()->is_admin){
            $users = User::latest('id')->get();
            return view('dashboard', compact('users'));
        }

        return view('profile');
    }

    public function home(){
        return view('welcome');
    }
}
