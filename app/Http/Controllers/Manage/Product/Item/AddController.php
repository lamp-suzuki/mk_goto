<?php

namespace App\Http\Controllers\Manage\Product\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AddController extends Controller
{
    public function index($account)
    {
        $manages = Auth::guard('manage')->user();
        $shops = DB::table('categories')
            ->where('manages_id', $manages->id)
            ->get();
        $genres = DB::table('genres')
            ->where('manages_id', $manages->id)
            ->get();
        return view('manage.product.item.add', [
            'shops' => $shops,
            'genres' => $genres,
        ]);
    }
}
