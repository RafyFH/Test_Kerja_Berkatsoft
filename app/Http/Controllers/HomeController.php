<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Produk;
use App\Customer;
use App\SalesOrder;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = "Dashboard";
        $menubar = "dashboard";

        $produk = Produk::count();
        $customer = Customer::count();
        $sales_order = SalesOrder::count();

        return view('dashboard',['title'=>$title,'menubar'=>$menubar,'produk'=>$produk,'customer'=>$customer,'sales_order'=>$sales_order]);
    }
}
