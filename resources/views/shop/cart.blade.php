@extends('layouts.shop.app')

@section('page_title', 'カート')

@section('content')
<div class="history-back d-md-none">
  <div class="container">
    <a href="{{ route('shop.home', ['account' => $sub_domain]) }}">
      <i data-feather="chevron-left"></i>
      <span>メニューに戻る</span>
    </a>
  </div>
</div>

<section class="mv">
  <div class="container">
    <h2>カート内容</h2>
  </div>
</section>
<!-- .mv -->

<form class="pc-two" action="{{ route('shop.order', ['account' => $sub_domain]) }}" method="POST" name="nextform" id="cartform">
  <div>
    @csrf
    <div class="cart__list pb-4 pt-md-4">
      <div class="container">
        <ol>
          <li>
            @if (isset($tour->thumbnail_1))
            <div class="thumbnail">
              <img src="{{ url($tour->thumbnail_1) }}" alt="{{ $tour->name }}" />
            </div>
            @endif
            <div class="info">
              <p class="name">{{ $tour->name }}</p>
              <div class="mt-2">
                <span>{{ $quantity }}</span>
                <small class="d-inline-flex">人</small>
              </div>
            </div>
            <div class="delete">
              <a href="{{ route('shop.home', ['account' => $sub_domain]) }}" class="btn btn-sm btn-primary btn-cartdelete">削除</a>
            </div>
          </li>
        </ol>
      </div>
    </div>
    <!-- .cart__list -->
    <div class="cart__delidate pb-4">
      <h3 class="ttl-horizon">
        <span class="d-block container">ご利用情報</span>
      </h3>
      <div class="container">
        <p class="">ご利用希望日時</p>
        <p class="">{{ date('Y年n月j日', strtotime($date)) }} {{ $time }}</p>
        <small class="d-block text-muted form-text">※受付はご利用4日前の17:00までとなります。
          <br>※お食事開始ご希望時刻を入力してください。
          <br>※GoToトラベルキャンペーンは2021年1月31日までの予定です（GoToトラベルキャンペーンの給付金の予算が上限に達し次第終了となります）。</small>
      </div>
    </div>
  </div>
  <div class="seconds">
    <div class="cart__amount pb-4">
      <h3 class="ttl-horizon">
        <span class="d-block container">合計金額</span>
      </h3>
      <div class="container">
        <table class="w-100 table table-borderless mb-0">
          <tfoot class="">
            <tr>
              <td class="border-0 text-center p-0">¥ <span class="h4 font-weight-bold">{{ number_format($tour->price * $quantity) }}</span></td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
    <div class="py-4 bg-light">
      <div class="container">
        <div class="d-flex justify-content-center form-btns">
          <a class="btn btn-lg bg-white btn-back mr-2" href="{{ route('shop.home', ['account' => $sub_domain]) }}">戻る</a>
          <button class="btn btn-lg btn-primary" type="submit">ご予約へ進む</button>
          <input type="hidden" name="tour_id" value="{{ $tour->id }}">
          <input type="hidden" name="quantity" value="{{ $quantity }}">
          <input type="hidden" name="date" value="{{ $date }}">
          <input type="hidden" name="time" value="{{ $time }}">
        </div>
      </div>
    </div>
  </div>
</form>
@endsection