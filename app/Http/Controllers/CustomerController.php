<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function registration()
    {
        return view('website.customer.registration-form');
    }
}
