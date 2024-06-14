<?php
namespace App\Controllers\Payments;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
    public function index()
    {
        return view('payments/index');
    }
}
