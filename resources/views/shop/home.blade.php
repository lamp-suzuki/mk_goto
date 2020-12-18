@extends('layouts.shop.app')

@section('content')

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
      <span class="d-block text-right mt-3">
        <a class="text-right" href="{{ route('shop.guide', ['account' => $sub_domain]) }}">ご利用の注意 ></a>
      </span>
    </p>
  </div>
</div>

{{-- 商品一覧 --}}
<section id="catalog" class="catalog">

  <ul class="catalog-cat">
    <li><a class="active smooth" href="#catalog">すべて</a></li>
    @foreach ($shops as $shop)
    @if (isset($tours[$shop->id]))
    <li><a class="smooth" href="#cat{{ $shop->id }}">{{ $shop->name }} ({{ count($tours[$shop->id]) }})</a></li>
    @endif
    @endforeach
  </ul>

  <div class="py-4">
    <div class="container">
      @foreach ($shops as $shop)
      @if (isset($tours[$shop->id]))
      <div id="cat{{ $shop->id }}" class="catalog-wrap">
        <h2>{{ $shop->name }}</h2>
        <div class="catalog-list">
          @foreach ($tours[$shop->id] as $tour)
          <div class="catalog-item">
            @if ($tour->thumbnail_1 != null)
            <div class="catalog-thumbnail" data-toggle="modal" data-target="#modal-item{{ $tour->id }}">
              <img src="{{ url($tour->thumbnail_1 ) }}" alt="{{ $tour->name }}" />
            </div>
            @endif
            <div class="catalog-name">
              <span>{{ mb_strimwidth($tour->name, 0, 50, '…') }}</span>
            </div>
            <div class="catalog-price">
              <span class="catalog-price-num">{{ number_format($tour->price) }}</span>
              <span class="catalog-price-tax">（税込）</span>
            </div>
            <div class="catalog-btn">
              @if (isset($stocks[$tour->id]) && $stocks[$tour->id] <= 0) <button class="btn btn-block btn-dark"
                type="button">満席</button>
                @else
                <button class="btn btn-block btn-primary" type="button" data-toggle="modal"
                  data-target="#modal-item{{ $tour->id }}">ツアーを選ぶ</button>
                @endif
            </div>
            {{-- modal --}}
            <div class="modal catalog-modal fade" id="modal-item{{ $tour->id }}" tabindex="-1"
              aria-labelledby="modal-item{{ $tour->id }}Label" aria-hidden="true">
              <div class="modal-dialog">
                <form action="{{ route('shop.cart', ['account' => $sub_domain]) }}" method="POST">
                  @csrf
                  <div class="modal-content">
                    <span class="modal-close-icon" data-dismiss="modal" aria-label="Close">
                      <i data-feather="x"></i>
                      <i>閉じる</i>
                    </span>
                    <div class="modal-header">
                      @if ($tour->thumbnail_1 != null)
                      <div id="modal-item{{ $tour->id }}-slide" class="carousel slide w-100" data-ride="carousel">
                        <ol class="carousel-indicators">
                          @if ($tour->thumbnail_1 != null)
                          <li data-target="#modal-item{{ $tour->id }}-slide" data-slide-to="0" class="active"></li>
                          @endif
                          @if ($tour->thumbnail_2 != null)
                          <li data-target="#modal-item{{ $tour->id }}-slide" data-slide-to="1"></li>
                          @endif
                          @if ($tour->thumbnail_3 != null)
                          <li data-target="#modal-item{{ $tour->id }}-slide" data-slide-to="2"></li>
                          @endif
                        </ol>
                        <div class="carousel-inner">
                          @if ($tour->thumbnail_1 != null)
                          <div class="carousel-item active">
                            <img src="{{ url($tour->thumbnail_1 ) }}" class="d-block w-100" alt="{{ $tour->name }}" />
                          </div>
                          @endif
                          @if ($tour->thumbnail_2 != null)
                          <div class="carousel-item">
                            <img src="{{ url('/') }}/{{ $tour->thumbnail_2 }}" class="d-block w-100"
                              alt="{{ $tour->name }}" />
                          </div>
                          @endif
                          @if ($tour->thumbnail_3 != null)
                          <div class="carousel-item">
                            <img src="{{ url('/') }}/{{ $tour->thumbnail_3 }}" class="d-block w-100"
                              alt="{{ $tour->name }}" />
                          </div>
                          @endif
                        </div>
                        <a class="carousel-control-prev" href="#modal-item{{ $tour->id }}-slide" role="button"
                          data-slide="prev">
                          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        </a>
                        <a class="carousel-control-next" href="#modal-item{{ $tour->id }}-slide" role="button"
                          data-slide="next">
                          <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        </a>
                      </div>
                      @endif
                    </div>
                    <div class="modal-body">
                      <div class="p-3">
                        <h3 class="title">{{ $tour->name }}</h3>
                        <p>{!! nl2br(e($tour->explanation)) !!}</p>
                        <div class="price">
                          <span class="price-num">{{ number_format($tour->price) }}</span>
                          <span class="price-tax">（税込）</span>
                        </div>
                      </div>
                      @if ($stop_flag === false)
                      <div class="form-group p-3 border-bottom border-top">
                        <label for="">
                          <small>予約時間</small>
                          <span class="badge badge-primary">必須</span>
                        </label>
                        <select name="time" id="" class="form-control">
                          @php
                          $times = explode("\n", $tour->time);
                          @endphp
                          @foreach ($times as $t)
                          <option value="{{ $t }}">{{ $t }}</option>
                          @endforeach
                        </select>
                      </div>
                      <p class="text-center small mt-2 mb-1">ご予約人数</p>
                      <div class="number pt-0">
                        <input class="num-spinner" type="number" name="quantity" value="1" min="2" max="50" step="1" />
                      </div>
                      @endif
                    </div>
                    @if ($stop_flag === false)
                    <div class="modal-footer">
                      <div class="btn-group m-0 w-100" role="group">
                        @if(session('tours_search.date') != null)
                        <input type="hidden" name="date" value="{{ session('tours_search.date') }}">
                        @endif
                        <button type="submit"
                          class="addcart btn btn-primary rounded-0 w-100 font-weight-bold py-3">予約へ進む</button>
                      </div>
                      <p class="modal-close" data-dismiss="modal" aria-label="Close">メニューに戻る</p>
                    </div>
                    @endif
                  </div>
                  <input type="hidden" name="product_id" value="{{ $tour->id }}">
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
{{-- <div class="cartstatus">
  <span class="count">{{ session('cart.total') == null ? 0 : session('cart.total') }}</span>
  <span class="price">{{ session('cart.amount') == null ? 0 : number_format(session('cart.amount')) }}</span>
  <a class="btn btn-primary rounded-pill" href="{{ route('shop.cart', ['account' => $sub_domain]) }}">次へ進む</a>
</div> --}}

{{-- お受け取り設定 --}}
@if ($stop_flag === false && session('tours_search') == null)
<form action="" method="GET" class="modal fsmodal catalog-modal fade" id="FirstSelect" tabindex="-1" aria-labelledby="FirstSelectLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-body">
        <div class="form-group">
          <label class="d-block text-body font-weight-bold">エリア<span class="badge badge-primary ml-2">必須</span></label>
          <select class="form-control" name="area">
            <option value="">エリアを選択する</option>
            <option value="京都" @if(session('tours_search.area') != null && session('tours_search.area') == '京都'){{ 'selected' }}@endif>京都</option>
            <option value="滋賀" @if(session('tours_search.area') != null && session('tours_search.area') == '滋賀'){{ 'selected' }}@endif>滋賀</option>
            <option value="大阪" @if(session('tours_search.area') != null && session('tours_search.area') == '大阪'){{ 'selected' }}@endif>大阪</option>
            <option value="神戸" @if(session('tours_search.area') != null && session('tours_search.area') == '神戸'){{ 'selected' }}@endif>神戸</option>
            <option value="東京" @if(session('tours_search.area') != null && session('tours_search.area') == '東京'){{ 'selected' }}@endif>東京</option>
            <option value="名古屋" @if(session('tours_search.area') != null && session('tours_search.area') == '名古屋'){{ 'selected' }}@endif>名古屋</option>
            <option value="福岡" @if(session('tours_search.area') != null && session('tours_search.area') == '福岡'){{ 'selected' }}@endif>福岡</option>
            <option value="札幌" @if(session('tours_search.area') != null && session('tours_search.area') == '札幌'){{ 'selected' }}@endif>札幌</option>
          </select>
        </div>
        {{-- form-group --}}
        <div class="form-group">
          <label class="d-block text-body font-weight-bold">ジャンル</label>
          <select class="form-control" name="genre">
            <option value="">すべて</option>
            @foreach ($genres as $genre)
            <option value="{{ $genre->id }}" @if(session('tours_search.genre') != null && session('tours_search.genre') == $genre->id){{ 'selected' }}@endif>{{ $genre->name }}</option>
            @endforeach
          </select>
        </div>
        {{-- form-group --}}
        <div class="form-group">
          <label class="d-block text-body font-weight-bold">ご予約日時</label>
          <input type="date" name="date" min="{{ date('Y-m-d', strtotime('+4 days')) }}" class="form-control form-control-sm"
          value="{{ session('tours_search.date') != null ? session('tours_search.date') : date('Y-m-d', strtotime('+4 days')) }}"
          >
        </div>
        {{-- form-group --}}
        <div class="form-group">
          <label class="d-block text-body font-weight-bold">ご予算</label>
          <div class="form-check form-check-inline d-inline-flex">
            <input class="form-check-input" type="radio" name="budget" id="budget_1" value="">
            <label class="form-check-label text-body" style="font-size:14px" for="budget_1">選択なし</label>
          </div>
          <div class="form-check form-check-inline d-inline-flex">
            <input class="form-check-input" type="radio" name="budget" id="budget_2" value="7000">
            <label class="form-check-label text-body" style="font-size:14px" for="budget_2">～7,000円</label>
          </div>
          <div class="form-check form-check-inline d-inline-flex">
            <input class="form-check-input" type="radio" name="budget" id="budget_3" value="15000">
            <label class="form-check-label text-body" style="font-size:14px" for="budget_3">7,001～15,000円</label>
          </div>
          <div class="form-check form-check-inline d-inline-flex">
            <input class="form-check-input" type="radio" name="budget" id="budget_4" value="30000">
            <label class="form-check-label text-body" style="font-size:14px" for="budget_4">15,001～30,000円</label>
          </div>
          <div class="form-check form-check-inline d-inline-flex">
            <input class="form-check-input" type="radio" name="budget" id="budget_5" value="30001">
            <label class="form-check-label text-body" style="font-size:14px" for="budget_5">30,001円～</label>
          </div>
        </div>
        {{-- form-group --}}
        <div class="form-group">
          <label class="d-block text-body font-weight-bold">その他</label>
          <div class="form-check">
            <input class="form-check-input" id="local-coupon" name="coupon" type="checkbox" value="1">
            <label class="form-check-label text-body" style="font-size:14px" for="local-coupon">地域共通クーポン利用可能店舗</label>
          </div>
        </div>
        {{-- form-group --}}
        <div class="text-center mt-4">
          <button class="btn btn-primary rounded-pill" type="submit">検索する</button>
        </div>
      </div>
    </div>
  </div>
</form>
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