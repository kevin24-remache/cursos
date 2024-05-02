<?php
namespace App\Controllers\Auth;

use App\Controllers\BaseController;

class LoginController extends BaseController
{
    public function index()
    {
        return view('auth/login');
    }
    public function forgotPassword()
    {
        return view('auth/forgot');
    }
    public function register()
    {
        return view('auth/register');
    }
}
