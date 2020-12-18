<?php

namespace App\Http\Controllers\Manage\Product\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ConfirmController extends Controller
{
    public function index($account, Request $request)
    {
        Validator::make($request->all(), [
            'shop' => 'required',
            'genre' => 'required',
            'name' => 'required',
            'price' => 'required|integer',
            'explanation' => 'required',
        ])->validate();

        // 画像ファイル処理
        $thumbnails = [];
        $captions = [];
        for ($i=1; $i <= 3; $i++) {
            if ($request['thumbnail_'.$i] != null) {
                $thumbnails[] = $request->file('thumbnail_'.$i)->store('public/uploads/products');
            }
        }

        $shop = DB::table('categories')->find($request->input('shop'));
        $genre = DB::table('genres')->find($request->input('genre'));

        return view('manage.product.item.confirm', [
            'inputs' => $request->input(),
            'thumbnails' => $thumbnails,
            'shop' => $shop,
            'genre' => $genre,
        ]);
    }
}
