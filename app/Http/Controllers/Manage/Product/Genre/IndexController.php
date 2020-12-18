<?php

namespace App\Http\Controllers\Manage\Product\genre;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class IndexController extends Controller
{
    public function index($account)
    {
        try {
            $manage = Auth::guard('manage')->user();
            $genres = DB::table('genres')->get();
        } catch (\Exception $e) {
            report($e);
        }
        return view('manage.product.genre.index', [
            'genres' => $genres,
        ]);
    }

    // 追加
    public function add($account, Request $request)
    {
        try {
            DB::table('genres')->insert([
                'manages_id' => $request['manage_id'],
                'name' => $request['genre_name'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
            session()->flash('message', 'ジャンルが追加されました。');
        } catch (\Exception $e) {
            dd($e);
            session()->flash('error', 'エラーが発生しました。');
        }
        return redirect()->route('manage.product.genre.index', ['account' => $account]);
    }

    // 編集
    public function edit($account, Request $request)
    {
        try {
            DB::table('genres')
                ->where('id', $request['genre_id'])
                ->update([
                    'name' => $request['genre_name'],
                    'updated_at' => now(),
                ]);
            session()->flash('message', 'ジャンルが編集されました。');
        } catch (\Exception $e) {
            session()->flash('error', 'エラーが発生しました。');
        }

        return redirect()->route('manage.product.genre.index', ['account' => $account]);
    }

    // 削除
    public function delete($account, Request $request)
    {
        try {
            DB::table('genres')->where('id', $request['genre_id'])->delete();
            session()->flash('message', 'ジャンルが削除されました。');
        } catch (\Exception $e) {
            session()->flash('error', 'エラーが発生しました。');
        }

        return redirect()->route('manage.product.genre.index', ['account' => $account]);
    }
}
