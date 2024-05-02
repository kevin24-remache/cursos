<?php
namespace App\Controllers\Client;

use App\Controllers\BaseController;

class ClientController extends BaseController
{
    public function index()
    {
        return view('client/home');
    }
}
