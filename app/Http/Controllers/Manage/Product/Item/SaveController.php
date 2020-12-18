<?php

namespace App\Http\Controllers\Manage\Product\Item;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaveController extends Controller
{
    public function index($account, Request $request)
    {
        $manage = Auth::guard('manage')->user();

        if ($request->has('thumbnail_1')) {
            $thumbnail_1 = str_replace('public', 'storage', $request['thumbnail_1']);
        }
        if ($request->has('thumbnail_2')) {
            $thumbnail_2 = str_replace('public', 'storage', $request['thumbnail_2']);
        }
        if ($request->has('thumbnail_3')) {
            $thumbnail_3 = str_replace('public', 'storage', $request['thumbnail_3']);
        }

        if (($request->has('id') && $request->has('act')) && ($request->input('id') != null && $request->input('act') != null)) {
            try {
                DB::table('products')->where('id', $request->input('id'))->update([
                    'categories_id' => $request['shop'],
                    'genres_id' => $request['genre'],
                    'name' => $request['name'],
                    'price' => $request['price'],
                    'time' => $request['time'],
                    'explanation' => $request['explanation'],
                    'status' => $request->has('draft') ? 'draft' : 'public',
                    'thumbnail_1' => isset($request['thumbnail_1']) ? $thumbnail_1 : null,
                    'thumbnail_2' => isset($request['thumbnail_2']) ? $thumbnail_2 : null,
                    'thumbnail_3' => isset($request['thumbnail_3']) ? $thumbnail_3 : null,
                    'caption_1' => isset($request['caption_1']) ? $request['caption_1'] : null,
                    'caption_2' => isset($request['caption_2']) ? $request['caption_2'] : null,
                    'caption_3' => isset($request['caption_3']) ? $request['caption_3'] : null,
                    'updated_at' => now()
                ]);
                session()->flash('message', 'ツアーが更新されました。');
            } catch (\Exception $e) {
                report($e);
                session()->flash('error', 'エラーが発生しました。');
            }
        } else {
            try {
                DB::table('products')->insert([
                    'manages_id' => $manage->id,
                    'categories_id' => $request['shop'],
                    'genres_id' => $request['genre'],
                    'name' => $request['name'],
                    'price' => $request['price'],
                    'time' => $request['time'],
                    'explanation' => $request['explanation'],
                    'status' => $request->has('draft') ? 'draft' : 'public',
                    'thumbnail_1' => isset($request['thumbnail_1']) ? $thumbnail_1 : null,
                    'thumbnail_2' => isset($request['thumbnail_2']) ? $thumbnail_2 : null,
                    'thumbnail_3' => isset($request['thumbnail_3']) ? $thumbnail_3 : null,
                    'caption_1' => isset($request['caption_1']) ? $request['caption_1'] : null,
                    'caption_2' => isset($request['caption_2']) ? $request['caption_2'] : null,
                    'caption_3' => isset($request['caption_3']) ? $request['caption_3'] : null,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                session()->flash('message', 'ツアーが追加されました。');
            } catch (\Exception $e) {
                report($e);
                session()->flash('error', 'エラーが発生しました。');
            }
        }
        // 二重送信対策
        $request->session()->regenerateToken();

        return redirect()->route('manage.product.index', ['account' => $account]);
    }
}
