@extends('layouts.shop.app')

@section('page_title', '注文内容の確認')

@section('content')
<section class="mv">
  <div class="container">
    <h2>注文内容の確認</h2>
  </div>
</section>
<div class="mv__step mb-md-5">
  <div class="container">
    <ol class="mv__step-count">
      <li class="visited"><em>情報入力</em></li>
      <li class="current"><em>確認</em></li>
      <li class=""><em>完了</em></li>
    </ol>
  </div>
</div>

@if ($inputs['payment'] == 0)
<form class="pc-two" action="https://linkpt.cardservice.co.jp/cgi-bin/credit/order.cgi" method="post">
@else
<form class="pc-two" action="{{ route('shop.thanks', ['account' => $sub_domain]) }}" method="post">
@endif
  <div>
    @csrf
    <div class="py-4">
      <div class="container">
        {{-- エラーメッセージ --}}
        @if(session()->has('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3">
          {{ session('error') }}
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif
        <p>ご登録内容をご確認の上「予約を確定する」ボタンを押して下さい。</p>

        <div class="mb-4">
          <h3 class="form-ttl">お客様情報</h3>

          <div class="form-group">
            <label class="small d-block">ツアー</label>
            <p class="mb-0">【{{ $shop->name }}】{{ $tour->name }}</p>
            <input type="hidden" name="shop_name" value="{{ $shop->name }}">
            <input type="hidden" name="plan_name" value="{{ $tour->name }}">
            <input type="hidden" name="genre_name" value="{{ $genre->name }}">
          </div>

          <div class="form-group">
            <label class="small d-block">人数</label>
            <p class="mb-0">{{ session('form_cart.quantity') }}人</p>
            <input type="hidden" name="customers" value="{{ session('form_cart.quantity') }}">
          </div>

          <div class="form-group">
            <label class="small d-block">予約希望日時</label>
            <p class="mb-0">{{ date('Y年n月j日', strtotime(session('form_cart.date'))) }} {{ session('form_cart.time') }}</p>
            <input type="hidden" name="date" value="{{ session('form_cart.date') }}">
            <input type="hidden" name="time" value="{{ session('form_cart.time') }}">
          </div>

          <div class="form-group">
            <label class="small d-block">氏名</label>
            <p class="mb-0">{{ $inputs['name1'] }} {{ $inputs['name2'] }}</p>
            <input type="hidden" name="name" value="{{ $inputs['name1'] }} {{ $inputs['name2'] }}">
          </div>

          <div class="form-group">
            <label class="small d-block">フリガナ</label>
            <p class="mb-0">{{ $inputs['furi1'] }} {{ $inputs['furi2'] }}</p>
            <input type="hidden" name="furigana" value="{{ $inputs['furi1'] }} {{ $inputs['furi2'] }}">
          </div>

          <div class="form-group">
            <label class="small d-block">携帯電話番号</label>
            <p class="mb-0">{{ $inputs['tel'] }}</p>
            <input type="hidden" name="tel" value="{{ $inputs['tel'] }}">
          </div>

          <div class="form-group">
            <label class="small d-block">メールアドレス</label>
            <p class="mb-0">{{ $inputs['email'] }}</p>
            <input type="hidden" name="email" value="{{ $inputs['email'] }}">
          </div>

          <div class="form-group">
            <label class="small d-block">特記事項</label>
            <p class="mb-0">{!! e($inputs['other_content']) !!}</p>
            <input type="hidden" name="other_content" value="{{ $inputs['other_content'] }}">
          </div>

          <div class="form-group">
            <label class="small d-block">決済方法</label>
            <p class="mb-0">{{ $inputs['payment'] == 0 ? 'クレジットカード決済' : 'TACPOカード' }}</p>
            <input type="hidden" name="payment" value="{{ $inputs['payment'] }}">
          </div>

          <div class="form-group">
            <label class="small d-block">お住まいの住所</label>
            <p class="mb-0">
              〒{{ $inputs['zipcode'] }}
              <br>{{ $inputs['pref'] }} {{ $inputs['address1'] }} {{ $inputs['address2'] }}
            </p>
            <input type="hidden" name="zipcode_1" value="{{ $inputs['zipcode'] }}">
            <input type="hidden" name="pref_1" value="{{ $inputs['pref'] }}">
            <input type="hidden" name="address_1_1" value="{{ $inputs['address1'] }}">
            <input type="hidden" name="address_2_1" value="{{ $inputs['address2'] }}">
          </div>

          <div class="form-group">
            <label class="small d-block">送迎場所</label>
            <p class="mb-0">
              @if ($inputs['zipcode_transfer'] != null && $inputs['pref_transfer'] != null && $inputs['address1_transfer'] != null && $inputs['address2_transfer'])
              〒{{ $inputs['zipcode_transfer'] }}
              <br>{{ $inputs['pref_transfer'] }} {{ $inputs['address1_transfer'] }} {{ $inputs['address2_transfer'] }}
              @else
              住所と同じ
              @endif
            </p>
            <input type="hidden" name="zipcode_2" value="{{ $inputs['zipcode_transfer'] }}">
            <input type="hidden" name="pref_2" value="{{ $inputs['pref_transfer'] }}">
            <input type="hidden" name="address_1_2" value="{{ $inputs['address1_transfer'] }}">
            <input type="hidden" name="address_2_2" value="{{ $inputs['address2_transfer'] }}">
          </div>

          <div class="form-group">
            <label class="small d-block">経由地</label>
            <p class="mb-0">
              @if(isset($inputs['waypoint_address']) && $inputs['waypoint_address'] != '')
              {!! e($inputs['waypoint_address']) !!}
              @else
              なし
              @endif
            </p>
            <input type="hidden" name="address_2_2" value="{{ isset($inputs['waypoint_address']) && $inputs['waypoint_address'] != '' ? $inputs['waypoint_address'] : '' }}">
          </div>

        </div>

      </div>
    </div>
  </div>

  <div>
    <div class="cart__amount pb-md-4">
      <h3 class="ttl-horizon">
        <span class="d-block container">合計金額</span>
      </h3>
      <div class="container">
        <table class="w-100 table table-borderless mb-0">
          <tfoot>
            <tr>
              <td class="border-0 p-0 text-center">
                ￥ <span class="h4 font-weight-bold">{{ number_format($tour->price * (int)session('form_cart.quantity')) }}</span>
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
    <div class="py-4 bg-light">
      <div class="container">
        @if ($inputs['payment'] == 0)
        <input type="hidden" name="clientip" value="2019000531">
        <input type="hidden" name="money" value="{{ $tour->price * (int)session('form_cart.quantity') }}">
        <input type="hidden" name="telno" value="{{ $inputs['tel'] }}">
        <input type="hidden" name="email" value="{{ $inputs['email'] }}">
        <input type="hidden" name="success_url" value="{{ route('shop.home', ['account' => $sub_domain]) }}">
        <input type="hidden" name="success_str" value="トップページに戻る">
        @endif
        <div class="mb-3">
          <p class="m-0">
            <b>【ご利用上の注意】</b>
            <br>
            <small>
            本ツアーのご予約は、決済完了後でも予約確定ではございません。店舗の予約状況によりましてはご変更や全額返金の上お取り消しをお願いさせていただく場合がございます。
            <br>正式なご予約確定はMKトラベルよりメールにてご連絡いたします。</small></p>
        </div>
        <div class="mb-4">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="" id="agree">
            <label class="form-check-label" for="agree">上記内容に同意します</label>
          </div>
        </div>
        <div class="d-flex justify-content-center form-btns">
          <a class="btn btn-lg bg-white btn-back mr-2" href="{{ route('shop.order', ['account' => $sub_domain]) }}">戻る</a>
          <button id="reserve-submit" class="btn btn-lg btn-primary" type="submit" disabled>@if($inputs['payment'] == 0){{ '決済に進む' }}@else{{ '予約を確定' }}@endif</button>
        </div>
      </div>
    </div>
  </div>
</form>
@endsection