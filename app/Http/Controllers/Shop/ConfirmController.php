<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ConfirmController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($account, Request $request)
    {
        session()->put('form_order', $request->input());
        $tour = DB::table('products')->find(session('form_cart.tour_id'));
        $shop = DB::table('categories')->find($tour->categories_id);
        $genre = DB::table('genres')->find($tour->genres_id);
        // 決済リダイレクト
        if ($request->input('payment')) {
        }
        return view('shop.confirm', [
            'tour' => $tour,
            'shop' => $shop,
            'genre' => $genre,
            'inputs' => $request->input()
        ]);
    }
}
