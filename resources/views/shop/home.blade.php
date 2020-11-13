@extends('layouts.shop.app')

@section('content')

{{-- 受け取り方法 --}}
@if (session()->has('receipt.date') && $stop_flag === false)
@php
if (session('receipt.service') == 'takeout') {
$service = 'お持ち帰り';
} elseif (session('receipt.service') == 'delivery') {
$service = 'デリバリー';
} else {
$service = 'お取り寄せ';
}
@endphp
<div id="changeDateBtn">
  <div class="container">
    {{-- @if (session('receipt.service') !== null)
    <span class="deli">{{ $service }}</span>
    @endif --}}
    @if (session('receipt.date') !== null)
    <span class="date">{{ date('n月j日', strtotime(session('receipt.date'))).' '.session('receipt.time') }}</span>
    @endif
    <div class="link" style="cursor: pointer">変更</div>
  </div>
</div>
@else
<div id="changeDateBtn">
  <div class="container">
    <span class="shop">受け取り方法未設定</span>
    <div class="link" style="cursor: pointer">変更</div>
  </div>
</div>
@endif

{{-- スライダー --}}
@if ($slides != null)
<div class="container home-slide-container">
  <div class="home-slide bg-white">
    @foreach ($slides as $key => $slide)
    @php
    if ($key == 'id' || $key == 'manages_id' || $key == 'created_at' || $key == 'updated_at') {
    continue;
    }
    @endphp
    @if ($slide != null)
    <div>
      <img src="{{ url('/') }}/{{ $slide }}" alt="バナー" />
    </div>
    @endif
    @endforeach
  </div>
</div>
@endif

{{-- お知らせ --}}
@if (isset($posts->title))
<div class="news bg-light py-3">
  <div class="container px-md-0">
    <a class="text-body d-block bg-white small p-3"
      href="{{ route('shop.info', ['account' => $sub_domain, 'id' => $posts->id]) }}">
      <span class="d-block text-secondary">{{ date('Y/m/d', strtotime($posts->updated_at)) }}</span>
      <span class="d-block">{{ $posts->title }}</span>
    </a>
  </div>
</div>
@endif

<div class="news bg-light py-3">
  <div class="container">
    <p class="p-3 bg-white rounded-sm small">
      <span>ホテル・料亭・レストランなどの「お食事」とMKタクシーでの「送迎」がセットになったパッケージツアーを販売いたします。当ツアーはGoToトラベル事業の支援対象となり、旅行代金に対して「GoToトラベルキャンペーン」の支援が適用されるため、送迎付きなのにお食事のみよりお得になるプランもございます。</span>
    </p>
  </div>
</div>

{{-- 商品一覧 --}}
<section id="catalog" class="catalog">
  <ul class="catalog-cat">
    <li><a class="active smooth" href="#catalog">すべて</a></li>
    @foreach ($categories as $cat)
    @if (isset($products[$cat->id]))
    <li><a class="smooth" href="#cat{{ $cat->id }}">{{ $cat->name }} ({{ count($products[$cat->id]) }})</a></li>
    @endif
    @endforeach
  </ul>
  <div class="py-4">
    <div class="container">
      @foreach ($categories as $cat)
      @if (isset($products[$cat->id]))
      <div id="cat{{ $cat->id }}" class="catalog-wrap">
        <h2>{{ $cat->name }}</h2>
        <div class="catalog-list">
          @foreach ($products[$cat->id] as $product)
          <div class="catalog-item">
            @if ($product->thumbnail_1 != null)
            <div class="catalog-thumbnail" data-toggle="modal" data-target="#modal-item{{ $product->id }}">
              <img src="{{ url($product->thumbnail_1 ) }}" alt="{{ $product->name }}" />
            </div>
            @endif
            <div class="catalog-name">
              <span>{{ mb_strimwidth($product->name, 0, 50, '…') }}</span>
            </div>
            <div class="catalog-price">
              <span class="catalog-price-num">{{ number_format($product->price) }}</span>
              <span class="catalog-price-tax">（税込）</span>
            </div>
            <div class="catalog-btn">
              @if (isset($stocks[$product->id]) && $stocks[$product->id] <= 0) <button class="btn btn-block btn-dark"
                type="button">満席</button>
                @else
                <button class="btn btn-block btn-primary" type="button" data-toggle="modal"
                  data-target="#modal-item{{ $product->id }}">予約へ進む</button>
                @endif
            </div>
            {{-- modal --}}
            <div class="modal catalog-modal fade" id="modal-item{{ $product->id }}" tabindex="-1"
              aria-labelledby="modal-item{{ $product->id }}Label" aria-hidden="true">
              <div class="modal-dialog">
                <form action="{{ route('shop.addcart', ['account' => $sub_domain]) }}" method="POST">
                  @csrf
                  <div class="modal-content">
                    <span class="modal-close-icon" data-dismiss="modal" aria-label="Close">
                      <i data-feather="x"></i>
                      <i>閉じる</i>
                    </span>
                    <div class="modal-header">
                      @if ($product->thumbnail_1 != null)
                      <div id="modal-item{{ $product->id }}-slide" class="carousel slide w-100" data-ride="carousel">
                        <ol class="carousel-indicators">
                          @if ($product->thumbnail_1 != null)
                          <li data-target="#modal-item{{ $product->id }}-slide" data-slide-to="0" class="active"></li>
                          @endif
                          @if ($product->thumbnail_2 != null)
                          <li data-target="#modal-item{{ $product->id }}-slide" data-slide-to="1"></li>
                          @endif
                          @if ($product->thumbnail_3 != null)
                          <li data-target="#modal-item{{ $product->id }}-slide" data-slide-to="2"></li>
                          @endif
                        </ol>
                        <div class="carousel-inner">
                          @if ($product->thumbnail_1 != null)
                          <div class="carousel-item active">
                            <img src="{{ url($product->thumbnail_1 ) }}" class="d-block w-100"
                              alt="{{ $product->name }}" />
                          </div>
                          @endif
                          @if ($product->thumbnail_2 != null)
                          <div class="carousel-item">
                            <img src="{{ url('/') }}/{{ $product->thumbnail_2 }}" class="d-block w-100"
                              alt="{{ $product->name }}" />
                          </div>
                          @endif
                          @if ($product->thumbnail_3 != null)
                          <div class="carousel-item">
                            <img src="{{ url('/') }}/{{ $product->thumbnail_3 }}" class="d-block w-100"
                              alt="{{ $product->name }}" />
                          </div>
                          @endif
                        </div>
                        <a class="carousel-control-prev" href="#modal-item{{ $product->id }}-slide" role="button"
                          data-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </a>
                        <a class="carousel-control-next" href="#modal-item{{ $product->id }}-slide" role="button"
                          data-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </a>
                      </div>
                      @endif
                    </div>
                    <div class="modal-body">
                      <div class="p-3">
                        <h3 class="title">{{ $product->name }}</h3>
                        <p>{!! nl2br(e($product->explanation)) !!}</p>
                        <div class="price">
                          <span class="price-num">{{ number_format($product->price) }}</span>
                          <span class="price-tax">（税込）</span>
                        </div>
                      </div>
                      @if (isset($options[$cat->id]))
                      @php
                      if ($product->options_id != '' && $product->options_id != null) {
                          $product_options = explode(',', $product->options_id);
                          array_pop($product_options);
                      } else {
                          $product_options = [];
                      }
                      @endphp
                      <div class="option">
                        @foreach ($options[$cat->id] as $opt)
                        @if(in_array((String)$opt->id, $product_options))
                        <div class="form-check">
                          <input class="form-check-input" type="checkbox" name="options[]" value="{{ $opt->id }}"
                            id="product{{ $product->id }}_opt{{ $opt->id }}" />
                          <label class="form-check-label" for="product{{ $product->id }}_opt{{ $opt->id }}">
                            <span>{{ $opt->name }}</span>
                            <span class="yen">@if($opt->price>=0)+@endif{{ number_format($opt->price) }}</span>
                          </label>
                        </div>
                        @endif
                        @endforeach
                      </div>
                      @endif
                      @if ($stop_flag === false)
                      <p class="text-center small mt-2 mb-1">ご予約人数</p>
                      <div class="number pt-0">
                        <input class="num-spinner" type="number" name="quantity" value="1" min="2" max="50" step="1" />
                      </div>
                      @endif
                    </div>
                    @if ($stop_flag === false)
                    <div class="modal-footer">
                      <div class="btn-group m-0 w-100" role="group">
                        <button type="button"
                          class="addcart btn btn-primary rounded-0 w-100 font-weight-bold py-3">カートに追加</button>
                      </div>
                      <p class="modal-close" data-dismiss="modal" aria-label="Close">メニューに戻る</p>
                    </div>
                    @endif
                  </div>
                  <input type="hidden" name="product_id" value="{{ $product->id }}">
                </form>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      @endif
      @endforeach
    </div>
  </div>
</section>

{{-- カート --}}
<div class="cartstatus">
  <span class="count">{{ session('cart.total') == null ? 0 : session('cart.total') }}</span>
  <span class="price">{{ session('cart.amount') == null ? 0 : number_format(session('cart.amount')) }}</span>
  <a class="btn btn-primary rounded-pill" href="{{ route('shop.cart', ['account' => $sub_domain]) }}">次へ進む</a>
</div>

{{-- お受け取り設定 --}}
@if ($stop_flag === false)
<div class="modal fsmodal catalog-modal fade" id="FirstSelect" tabindex="-1" aria-labelledby="FirstSelectLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <div class="form-group">
          <label class="d-block text-body font-weight-bold">エリア<span class="badge badge-primary ml-2">必須</span></label>
          <select class="form-control">
            <option value="">エリアを選択する</option>
          </select>
        </div>
        {{-- form-group --}}
        <div class="form-group">
          <label class="d-block text-body font-weight-bold">ジャンル</label>
          <select class="form-control">
            <option value="">すべて</option>
          </select>
        </div>
        {{-- form-group --}}
        <div class="form-group">
          <label class="d-block text-body font-weight-bold">ご予約日時</label>
          <input type="date" name="" min="{{ date('Y-m-d', strtotime('+4 days')) }}" class="form-control form-control-sm" value="{{ date('Y-m-d', strtotime('+4 days')) }}">
          <div class="form-inline mt-2">
            <select class="form-control form-control-sm w-auto">
              <option value="">00</option>
            </select>
            <span class="mx-1">：</span>
            <select class="form-control form-control-sm w-auto">
              <option value="">00</option>
            </select>
          </div>
        </div>
        {{-- form-group --}}
        <div class="form-group">
          <label class="d-block text-body font-weight-bold">ご予算</label>
          <div class="form-check form-check-inline d-inline-flex">
            <input class="form-check-input" type="radio" name="" id="budget_1" value="">
            <label class="form-check-label text-body" style="font-size:14px" for="budget_1">選択なし</label>
          </div>
          <div class="form-check form-check-inline d-inline-flex">
            <input class="form-check-input" type="radio" name="" id="budget_2" value="">
            <label class="form-check-label text-body" style="font-size:14px" for="budget_2">¥5,000以下</label>
          </div>
          <div class="form-check form-check-inline d-inline-flex">
            <input class="form-check-input" type="radio" name="" id="budget_3" value="">
            <label class="form-check-label text-body" style="font-size:14px" for="budget_3">¥5,000-¥10,000</label>
          </div>
          <div class="form-check form-check-inline d-inline-flex">
            <input class="form-check-input" type="radio" name="" id="budget_4" value="">
            <label class="form-check-label text-body" style="font-size:14px" for="budget_4">¥10,000-¥20,000</label>
          </div>
          <div class="form-check form-check-inline d-inline-flex">
            <input class="form-check-input" type="radio" name="" id="budget_5" value="">
            <label class="form-check-label text-body" style="font-size:14px" for="budget_5">¥20,000以上</label>
          </div>
        </div>
        {{-- form-group --}}
        <div class="form-group">
          <label class="d-block text-body font-weight-bold">その他</label>
          <div class="form-check">
            <input class="form-check-input" id="local-coupon" type="checkbox" value="">
            <label class="form-check-label text-body" style="font-size:14px" for="local-coupon">地域共通クーポン利用可能店舗</label>
          </div>
        </div>
        {{-- form-group --}}
        <div class="text-center mt-4">
          <button class="btn btn-primary rounded-pill" type="button" data-dismiss="modal">検索する</button>
        </div>
      </div>
    </div>
  </div>
</div>
@endif

{{-- hidden_flag --}}
@if ($stop_flag === true)
<div class="modal fade" id="salestop" tabindex="-1" role="dialog" aria-labelledby="salestopTitle" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content border-0">
      <div class="modal-body">
        <div class="pt-4">
          <p class="text-center">
            <i class="text-primary" data-feather="alert-triangle" width="32px" hegiht="32px"></i>
          </p>
          <p class="text-center font-weight-bold mb-3 h5">ただいま一時的に<br>ご注文の受付を<br>ストップしております</p>
          <p class="text-center small mb-0">ご迷惑をお掛けいたしますが<br>何卒ご理解いただけますよう<br>お願い申し上げます。</p>
        </div>
      </div>
      <div class="modal-footer text-center justify-content-center border-0 pb-4">
        <button type="button" class="btn btn-primary rounded-pill" data-dismiss="modal">メニューを見る</button>
      </div>
    </div>
  </div>
</div>
@endif

@endsection