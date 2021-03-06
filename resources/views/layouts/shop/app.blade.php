@php
$current_rname = \Route::currentRouteName();
$index_route = ['shop.home', 'shop.news', 'shop.info', 'shop.shopinfo', 'shop.guide'];
@endphp
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">

  {{-- @if (!in_array($current_rname, $index_route, true))
  <meta name="robots" content="noindex">
  @endif --}}
  <meta name="robots" content="noindex">

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="receipt" content="{{ !session()->has('receipt.date') ? 'on' : 'no' }}">

  @hasSection('page_title')
  <title>@yield('page_title') | 【公式】{{ $meta_title }} | テイクアウト（お持ち帰り）注文サイト</title>
  @else
  <title>【公式】{{ $meta_title }} | テイクアウト（お持ち帰り）注文サイト</title>
  @endif

  <meta name="description" content="{{ $meta_description }}">
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="{{ asset('css/shop/app.css') }}" rel="stylesheet">
  <script src="{{ asset('js/shop/app.js') }}" defer></script>
</head>

<body @if ($current_rname==='shop.home' ) class="home" @endif>
  <header id="header">
    <nav class="navi">
      <h1 class="navi-brand">
        @if ($manages->logo == null)
        <a class="text-body font-weight-bold"
          href="{{ route('shop.home', ['account' => $sub_domain]) }}">{{ $manages->name }}</a>
        @else
        <a class="d-block py-2" href="{{ route('shop.home', ['account' => $sub_domain]) }}">
          <img src="{{ url($manages->logo) }}" alt="{{ $manages->name }}" style="height: 45px !important">
        </a>
        @endif
      </h1>
      <ul class="navi-nav ml-auto">
        <li class="navi-item d-md-block d-none">
          <a class="navi-link navi-tel" href="tel:{{ $manages->tel }}">
            <i data-feather="phone-call" class="mr-1"></i>
            <span>{{ $manages->tel }}</span>
          </a>
        </li>
        {{-- <li class="navi-item">
          <a class="navi-link position-relative" href="{{ route('shop.cart', ['account' => $sub_domain]) }}">
            <span class="cart-count">{{ session('cart.total') == null ? 0 : session('cart.total') }}</span>
            <i data-feather="shopping-cart"></i>
            <span class="navi-link-txt">カート</span>
          </a>
        </li> --}}
        <li class="navi-item">
          <button id="spopen" class="navi-link btn btn-link rounded-0">
            <i data-feather="menu"></i>
            <span class="navi-link-txt">メニュー</span>
          </button>
        </li>
      </ul>
    </nav>
  </header>

  <nav id="spmenu" class="spmenu">
    <div class="spmenu-close text-center">
      <i data-feather="x"></i>
      <span class="d-block">閉じる</span>
    </div>
    <div class="spmenu-conainer">
      <div class="spmenu-login">
        @if (Auth::check())
        <div class="spmenu-login-inner">
          <p class="mb-0">ようこそ、
            <br><i class="text-primary mr-2 d-inline-block align-baseline mb-n2"
              data-feather="user"></i><span>{{ Auth::user()->name }}</span> 様
          </p>
        </div>
        @else
        <div class="spmenu-login-inner">
          <a class="btn btn-primary btn-block" href="{{ route('login', ['account' => $sub_domain]) }}">
            <i data-feather="log-in" class="d-inline-block align-middle"></i>
            <span class="d-inline-block align-middle font-weight-bold">ログイン</span>
          </a>
        </div>
        @endif
      </div>
      <ul class="spmenu-links">
        <li>
          <a href="{{ route('member.index', ['account' => $sub_domain]) }}">
            <i data-feather="credit-card" class="d-inline-block align-middle text-primary mr-2"></i>
            <span class="d-inline-block align-middle text-body">会員情報の確認・編集</span>
          </a>
        </li>
        <li>
          <a href="{{ route('member.orders', ['account' => $sub_domain]) }}">
            <i data-feather="list" class="d-inline-block align-middle text-primary mr-2"></i>
            <span class="d-inline-block align-middle text-body">注文履歴</span>
          </a>
        </li>
        <li>
          <a href="{{ route('shop.news', ['account' => $sub_domain]) }}">
            <i data-feather="info" class="d-inline-block align-middle text-primary mr-2"></i>
            <span class="d-inline-block align-middle text-body">店舗からのお知らせ</span>
          </a>
        </li>
        <li>
          <a href="{{ route('shop.guide', ['account' => $sub_domain]) }}">
            <i data-feather="book-open" class="d-inline-block align-middle text-primary mr-2"></i>
            <span class="d-inline-block align-middle text-body">ご利用ガイド</span>
          </a>
        </li>
      </ul>
      {{-- <div class="spmenu-shop">
        <div class="spmenu-btns mt-3">
          @if ($manages_shops->googlemap_url != null)
          <a class="btn btn-block btn-outline-light" href="{{ $manages_shops->googlemap_url }}">
            <i data-feather="map-pin" class="d-inline-block align-middle text-primary mr-1"></i>
            <span class="d-inline-block align-middle text-body small">Googlemapをみる</span>
          </a>
          @endif
          <a class="btn btn-block btn-outline-light mt-2" href="tel:{{ $manages->tel }}">
            <i data-feather="phone" class="d-inline-block align-middle text-primary mr-1"></i>
            <span class="d-inline-block align-middle text-body small">{{ $manages->tel }}</span>
          </a>
        </div>
      </div> --}}
    </div>
  </nav>

  <main id="main">
    @yield('content')
  </main>

  <footer id="footer">
    <div class="footer-logo">
      <div class="container text-lg-center">
        <a class="text-white font-weight-bold" href="{{ route('shop.home', ['account' => $sub_domain]) }}">{{ $manages->name }}</a>
      </div>
    </div>
    <div class="footer-menu py-4">
      <div class="container">
        <div class="d-flex justify-content-lg-center justify-content-start flex-wrap">
          <a class="text-white" href="{{ route('shop.home', ['account' => $sub_domain]) }}">ホーム</a>
          <a class="text-white mx-3" href="{{ route('shop.guide', ['account' => $sub_domain]) }}">ご利用ガイド</a>
          <a class="text-white" href="{{ route('shop.news', ['account' => $sub_domain]) }}">お知らせ一覧</a>
        </div>
        <div class="d-flex justify-content-lg-center justify-content-start flex-wrap mt-3">
          <a class="text-white small mr-3 mb-2" href="https://www.mk-group.co.jp/privacy.html" target="_blank">プライバシーポリシー</a>
          <a class="text-white small mr-3 mb-2" href="https://www.mk-group.co.jp/travel/tour-kiyaku.html" target="_blank">旅行規約</a>
        </div>
      </div>
    </div>
    <span class="footer-socket text-center">©2020 {{ $manages->name }}</span>
  </footer>
  <div class="overray"></div>
</body>

</html>