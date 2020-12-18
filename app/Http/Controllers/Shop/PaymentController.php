<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($account, Request $request)
    {
        $manages = DB::table('manages')->where('domain', $account)->first();

        Validator::make($request->all(), [
            'name1' => 'required',
            'name2' => 'required',
            'furi1' => 'required',
            'furi2' => 'required',
            'email' => 'required|email',
            'email' => 'required|email|confirmed',
            'tel' => 'required',
        ])->validate();
        $request->session()->put('form_order', $request->input());

        return view('shop.payment');
    }
}
