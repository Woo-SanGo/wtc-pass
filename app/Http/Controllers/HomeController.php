<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Require user to be logged in to access this controller
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Show page after login/register
public function index()
{
    $user = auth()->user();

    if ($user->email === 'admin168@gmail.com') {
        return redirect('/admin');
    }

    return view('index'); // normal user homepage
}

}