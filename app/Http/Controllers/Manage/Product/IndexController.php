<?php

namespace App\Http\Controllers\Manage\Product;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index($account, Request $request)
    {
        $manages = Auth::guard('manage')->user();
        $shops = DB::table('categories')
            ->where('manages_id', $manages->id)
            ->get()
            ->groupBy('id')
            ->toArray();

        $tours = DB::table('products')->where('manages_id', $manages->id);
        if ($request->input('search')) {
            $tours->where('name', 'LIKE', "%{$request->input('search')}%");
        }
        $tours = $tours->orderByDesc('created_at')->paginate(50);

        return view('manage.product.index', [
            'shops' => $shops,
            'tours' => $tours
        ]);
    }

    // 並び替え
    public function sort_products($account, Request $request)
    {
        $sorted = $request['sort_ids'];
        try {
            foreach ($sorted as $index => $id) {
                DB::table('products')
                ->where('id', $id)
                ->update([
                    'sort_id' => $index
                ]);
            }
            return "OK";
        } catch (\Throwable $th) {
            return "NO";
        }
    }
}
