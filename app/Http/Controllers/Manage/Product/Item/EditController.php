<?php

namespace App\Http\Controllers\Manage\Product\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EditController extends Controller
{
    public function index($account, $id)
    {
        $manages = Auth::guard('manage')->user();
        $shops = DB::table('categories')
            ->where('manages_id', $manages->id)
            ->get();
        $genres = DB::table('genres')
            ->where('manages_id', $manages->id)
            ->get();
        $tour = DB::table('products')->find($id);
        return view('manage.product.item.edit', [
            'shops' => $shops,
            'genres' => $genres,
            'tour' => $tour,
        ]);
    }
}
