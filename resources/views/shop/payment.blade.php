@extends('layouts.shop.app')

@section('page_title', 'お支払い情報入力')

@section('content')
<section class="mv">
  <div class="container">
    <h2>お支払い情報入力</h2>
  </div>
</section>
<div class="mv__step mb-md-5">
  <div class="container">
    <ol class="mv__step-count">
      <li class="visited"><em>情報入力</em></li>
      <li class="current"><em>お支払い</em></li>
      <li class=""><em>確認</em></li>
      <li class=""><em>完了</em></li>
    </ol>
  </div>
</div>

<form class="pc-two" action="{{ route('shop.confirm', ['account' => $sub_domain]) }}" method="POST">
  <div>
    @csrf
    <div class="py-4">
      <div class="container">
        @if ($errors->any())
        <div class="alert alert-danger"><small>入力に誤りまたは未入力があります。</small></div>
        @endif
        <h3 class="form-ttl">お支払い情報</h3>
        <div class="form-group mb-0">
          <label class="small d-block form-must" for="">お支払い方法(選択)</label>
          <select class="form-control" id="pay" name="pay">
            <option value="">選択してください</option>
            <option value="0"@if(session('form_payment.pay')==='0') selected @endif>クレジットカード決済</option>
            @if (session('receipt.service') == 'takeout')
            @if (isset($shops->payment) && count(explode(',', $shops->payment)) >= 3)
            <option value="1"@if(session('form_payment.pay')==='1') selected @endif>店舗でお支払い</option>
            @endif
            @endif
          </select>
          <script type="text/javascript" src="https://checkout.pay.jp/" class="payjp-button"
            data-key="{{ config('app.payjpkey_public') }}" data-submit-text="適用して閉じる" data-partial="true"></script>
        </div>
        <!-- .form-group -->
        @if ($point_flag)
        <div class="form-group mb-0 mt-3">
          <label class="small d-block" for="">ポイントを使用する</label>
          <div class="input-group">
            <input type="number" min="0" max="{{ $points }}" value="0" name="use_points" class="form-control" aria-describedby="basic-pt" />
            <div class="input-group-append">
              <span class="input-group-text" id="basic-pt">pt</span>
            </div>
          </div>
          <small id="" class="form-text d-block mt-1 text-right">
            保有ポイント
            <span id="have-pt" class="ml-2">{{ $points }}</span>
            pt
          </small>
        </div>
        @endif
        {{-- <div class="form-group mb-0">
          <label class="small d-block" for="">クーポンのご利用</label>
          <input type="text" name="coupon" class="form-control" id="coupon" />
          <small id="couponSuccess" class="form-text mt-1 text-primary" style="display: none">現在ご利用いただけないクーポンです。</small>
        </div> --}}
      </div>
    </div>
    @if (session('receipt.service') == 'delivery')
    <div class="py-4">
      <h3 class="ttl-horizon">
        <span class="d-block container">領収書について</span>
      </h3>
      <div class="container">
        <div class="form-group form-check mb-0">
          <input type="checkbox" class="form-check-input" id="receipt" name="set-receipt" value="1" />
          <label class="form-check-label" for="receipt">領収書をつける</label>
        </div>
      </div>
    </div>
    @endif
  </div>
  <div>
    <div class="py-4 pt-md-0 pb-4 cart__amount">
      <h3 class="ttl-horizon">
        <span class="d-block container">合計金額</span>
      </h3>
      <div class="container">
        <table class="w-100 table table-borderless mb-0">
          <tbody>
            <tr>
              <th>商品小計</th>
              <td>¥ {{ number_format(session('cart.amount')) }}</td>
            </tr>
            @if (session('cart.shipping') !== 0)
            <tr>
              <th>送料</th>
              <td>¥ {{ number_format(session('cart.shipping')) }}</td>
            </tr>
            @endif
            <tr>
              <th>応援金</th>
              <td>¥ {{ number_format(session('cart.okimochi')) }}</td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <th>合計</th>
              <td>¥ {{ number_format(session('cart.amount') + session('cart.shipping') + session('cart.okimochi')) }}</td>
            </tr>
            @if ($point_flag)
            <tr class="small">
              <th>獲得ポイント</th>
              <td>{{ number_format(floor(session('cart.amount')*0.01)) }}pt</td>
            </tr>
            @endif
          </tfoot>
        </table>
      </div>
    </div>
    <div class="py-4 bg-light">
      <div class="container">
        <div class="d-flex justify-content-center form-btns">
          <a class="btn btn-lg bg-white btn-back mr-2" href="{{ route('shop.order', ['account' => $sub_domain]) }}">戻る</a>
          <button class="btn btn-lg btn-primary" type="submit">確認画面へ</button>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection