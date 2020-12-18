<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index($account, Request $request)
    {
        $manages = DB::table('manages')->where('domain', $account)->first();
        $tour = DB::table('products')->find($request->input('product_id'));

        return view('shop.cart', [
            'manages' => $manages,
            'tour' => $tour,
            'date' => $request->input('date'),
            'time' => $request->input('time'),
            'quantity' => $request->input('quantity'),
        ]);
    }

    // カート商品削除
    public function delete($account, Request $request)
    {
        $target = session('cart.products')[(int)$request['product_id']];
        $product = DB::table('products')->find($target['id']);
        $price = $product->price;
        if (is_array($target['options'])) {
            foreach ($target['options'] as $key => $option) {
                $opt_temp = DB::table('options')->find($option);
                $price += $opt_temp->price;
            }
        }
        $request->session()->put('cart.amount', session('cart.amount') - $price);
        $request->session()->put('cart.total', session('cart.total') - 1);

        $request->session()->forget('cart.products.'.$request['product_id']);

        return redirect()->route('shop.cart', ['account' => $account]);
    }

    // カート商品数量変更
    public function change_quantity(Request $request)
    {
        $old_price = (int)$request['price'] * (int)$request['old_quantity'];
        $old_amount = (int)session('cart.amount');
        session()->put('cart.products.'.$request['index'].'.quantity', (int)$request['quantity']);
        session()->put('cart.amount', (int)$request['quantity'] * (int)$request['price'] + ($old_amount - $old_price));
    }

    // カート商品購入可能精査
    public function cart_vali()
    {
        $service = session('receipt.service');
        $cart_products = session('cart.products');
        foreach ($cart_products as $key => $product) {
            $flag = DB::table('products')->find($product['id']);
            if ($flag->{$service.'_flag'} == 0) {
                session()->put('cart.vali', 'bad');
                break;
            } else {
                if (session()->has('cart.vali')) {
                    session()->forget('cart.vali');
                }
            }
        }

        if (session()->has('cart.vali')) {
            return 'bad';
        } else {
            return 'ok';
        }
    }
}
