<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $manages = DB::table('manages')->where('domain', 'mk-goto')->first();
        if (session('receipt.shop_id') != null) {
            $manages_shops = DB::table('shops')->find(session('receipt.shop_id'));
        } else {
            $manages_shops = DB::table('shops')->where('manages_id', $manages->id)->first();
        }
        $title = $manages->name;
        $description = $manages->description;
        View::share([
            'sub_domain' => 'mk-goto',
            'meta_title' => $title,
            'meta_description' => $description,
            'manages' => $manages,
            'manages_shops' => $manages_shops,
        ]);
    }
}
