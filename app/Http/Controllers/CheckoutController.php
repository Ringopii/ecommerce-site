<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Cassandra\Custom;
use Illuminate\Http\Request;
use Cart;
use Session;

class CheckoutController extends Controller
{
    private $customer, $order, $orderDetail, $product;

    public function index()
    {

        return view('website.checkout.index', ['cart_products' => Cart::content()]);
    }

    public function newOrder(Request $request)
    {

        $this->customer = Customer::where('mobile', $request->mobile)->first();
        if ($this->customer)
        {
            return redirect('/customer-order-password/'.$this->customer->id);
        }

        $this->validate($request, [
            'name'              => 'required',
            'email'             => 'required|unique:customers,email',
            'mobile'            => 'required|unique:customers,mobile',
            'delivery_address'  => 'required',
        ]);

        $this->customer = new Customer();
        $this->customer->name       = $request->name;
        $this->customer->email      = $request->email;
        $this->customer->mobile     = $request->mobile;
        $this->customer->password   = bcrypt($request->mobile);
        $this->customer->save();

        Session::put('customer_id', $this->customer->id);
        Session::put('customer_name', $this->customer->name);

        $this->order = new Order();
        $this->order->customer_id       = $this->customer->id;
        $this->order->order_total       = Session::get('order_total');
        $this->order->tax_total         = Session::get('tax_total');
        $this->order->shipping_total    = Session::get('shipping_total');
        $this->order->order_date        = date('Y-m-d');
        $this->order->order_timestamp   = strtotime(date('Y-m-d'));
        $this->order->delivery_address  = $request->delivery_address;
        $this->order->payment_type      = $request->payment_type;
        $this->order->save();

        foreach (Cart::content() as $item)
        {
            $this->orderDetail = new OrderDetail();
            $this->orderDetail->order_id = $this->order->id;
            $this->orderDetail->product_id = $item->id;
            $this->orderDetail->product_name = $item->name;
            $this->orderDetail->product_image = $item->options->image;
            $this->orderDetail->product_price = $item->price;
            $this->orderDetail->product_quantity = $item->qty;
            $this->orderDetail->save();


            $this->product = Product::find($item->id);
            $this->product->stock_amount = $this->product->stock_amount - $item->qty;
            $this->product->save();

            Cart::remove($item->rowId);
        }
        return redirect('/complete-order')->with('message', 'Congratulation...your order save successfully. Please wait, we will contact with you soon.');
    }

    public function orderPassword($id)
    {
        return view('website.checkout.order-password', ['customer' => Customer::find($id)]);
    }

    public function orderComplete()
    {
        return view('website.checkout.complete-order');
    }

}
