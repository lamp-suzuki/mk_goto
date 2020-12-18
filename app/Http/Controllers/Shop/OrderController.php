<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($account, Request $request)
    {
        $manages = DB::table('manages')->where('domain', $account)->first();
        session()->put('form_cart', $request->input());
        return view('shop.order');
    }
}
