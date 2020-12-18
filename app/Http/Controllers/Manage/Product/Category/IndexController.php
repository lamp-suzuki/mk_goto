<?php

namespace App\Http\Controllers\Manage\Product\Category;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    public function index()
    {
        try {
            $manage = Auth::guard('manage')->user();
            $categories = DB::table('categories')->where([
                ['manages_id', $manage->id],
            ])->orderBy('sort_id', 'asc')->get();
            if ($categories == null) {
                $categories = [];
            }
        } catch (\Exception $e) {
            $categories = [];
        }
        return view('manage.product.category.index', [
            'categories' => $categories
        ]);
    }

    // 店舗追加
    public function add($account, Request $request)
    {
        return view('manage.product.category.add');
    }

    // 店舗追加
    public function edit($account, $id)
    {
        return view('manage.product.category.edit', [
            'shop' => DB::table('categories')->find($id)
        ]);
    }

    // 店舗確認
    public function confirm($account, Request $request)
    {
        Validator::make($request->all(), [
            'area' => 'required',
            'name' => 'required',
            'stock' => 'required|integer',
        ])->validate();

        return view('manage.product.category.confirm', [
            'input' => $request->input(),
        ]);
    }

    // 店舗保存
    public function save($account, Request $request)
    {
        $manages = Auth::guard('manage')->user();
        if ($request->input('act') == 'add') {
            // 新規追加
            try {
                DB::table('categories')->insert([
                    'manages_id' => $manages->id,
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'area' => $request->input('area'),
                    'holiday' => $request->input('holiday'),
                    'stock' => $request->input('stock'),
                    'coupon' => $request->input('coupon'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                session()->flash('message', '店舗が追加されました。');
            } catch (\Throwable $th) {
                report($th);
                session()->flash('error', 'エラーが発生しました。');
            }
        } else {
            // 更新
            DB::table('categories')->where('id', $request->input('id'))->update([
                'name' => $request->input('name'),
                'area' => $request->input('area'),
                'email' => $request->input('email'),
                'holiday' => $request->input('holiday'),
                'stock' => $request->input('stock'),
                'coupon' => $request->input('coupon'),
                'updated_at' => now(),
            ]);
            try {
                session()->flash('message', '店舗が更新されました。');
            } catch (\Throwable $th) {
                report($th);
                session()->flash('error', 'エラーが発生しました。');
            }
        }
        return redirect()->route('manage.product.category.index', ['account' => $account]);
    }

    // 店舗削除
    public function delete($account, Request $request)
    {
        try {
            DB::table('categories')->where('id', $request->input('category_id'))->delete();
            session()->flash('message', '店舗が削除されました。');
        } catch (\Throwable $th) {
            report($th);
            session()->flash('error', 'エラーが発生しました。');
        }
        return redirect()->route('manage.product.category.index', ['account' => $account]);
    }

    // 並び替え
    public function sort_cat(Request $request)
    {
        $sorted = $request['sort_ids'];
        try {
            foreach ($sorted as $index => $id) {
                DB::table('categories')
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
