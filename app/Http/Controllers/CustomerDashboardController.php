<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Session;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        return view('customer.home', [
            'orders' => Order::where('customer_id', Session::get('customer_id'))->orderBy('id', 'desc')->take(3)->get(),
            //'orders' => Order::where('customer_id', Session::get('customer_id'))->where('order_timestamp', strtotime(data('Y-m-d'))) ->orderBy('id', 'desc')->get(),
        ]);
    }

    public function profile()
    {
        return view('customer.profile');
    }

    public function order()
    {
        return view('customer.order');
    }

    public function orderDetail()
    {
        return view('customer.order-detail');
    }

    public function changePassword()
    {
        return view('customer.change-password');
    }

    public function logout()
    {
        Session::forget('customer_id');
        Session::forget('customer_name');

        return redirect('/');
    }

    public function login()
    {
        return view('customer.login');
    }
}
