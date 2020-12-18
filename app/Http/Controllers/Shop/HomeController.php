<?php

namespace App\Http\Controllers\Shop;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index($account, Request $request)
    {
        $manages = DB::table('manages')->where('domain', $account)->first();
        $slides = DB::table('slides')->where('manages_id', $manages->id)->get();
        $genres = DB::table('genres')->where('manages_id', $manages->id)->get();
        $posts = DB::table('posts')->where('manages_id', $manages->id)
            ->orderBy('created_at', 'desc')
            ->first();

        $shops = DB::table('categories')->where('manages_id', $manages->id);
        $tours = DB::table('products')->where('manages_id', $manages->id);

        // ======= 検索 =======
        // エリア
        if ($request->has('area') && $request->input('area') != null) {
            $shops->where('area', $request->input('area'));
        }
        // ジャンル
        if ($request->has('genre') && $request->input('genre') != null) {
            $tours->where('genres_id', $request->input('genre'));
        }
        // 予算
        if ($request->has('budget') && $request->input('budget') != null) {
            switch ($request->input('budget')) {
                case '7000':
                    $tours->where('price', '<=', 7000);
                    break;
                case '15000':
                    $tours->whereBetween('price', [7001, 15000]);
                    break;
                case '30000':
                    $tours->whereBetween('price', [15001, 30000]);
                    break;
                case '30001':
                    $tours->where('price', '>=', 30001);
                    break;
                default:
                    break;
            }
        }
        // クーポン
        if ($request->has('coupon') && $request->input('coupon') == 1) {
            $shops->where('coupon', 1);
        }
        // ======= 検索 =======

        if ($request->has('area') || $request->has('genre') || $request->has('budget') || $request->has('coupon')) {
            $request->session()->put('tours_search', $request->input());
        }

        $shops = $shops->orderBy('sort_id', 'asc')->get();
        $tours = $tours->get()->groupBy('categories_id');

        // 非表示フラグ
        if ($request->has('stop_flag') && $request->stop_flag === true) {
            $stop_flag = true;
        } else {
            $stop_flag = false;
        }

        return view('shop.home', [
            'genres' => $genres,
            'slides' => $slides,
            'shops' => $shops,
            'tours' => $tours,
            'posts' => $posts,
            'stop_flag' => $stop_flag,
        ]);
    }
}
