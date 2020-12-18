@extends('layouts.manage.app')

@section('content')
<h2 class="h5 text-center font-weight-bold mb-4">こちらの内容で店舗を保存します</h2>
<form action="{{ route('manage.product.category.save', ['account' => $sub_domain]) }}" method="post">
  @csrf
  <div class="p-4 rounded-lg bg-white">
    <div class="form-group">
      <label>エリア</label>
      <span>{{ $input['area'] }}</span>
      <input type="hidden" name="area" value="{{ $input['area'] }}">
    </div>
    <div class="form-group">
      <label>店舗名</label>
      <span>{{ $input['name'] }}</span>
      <input type="hidden" name="name" value="{{ $input['name'] }}">
    </div>
    <div class="form-group">
      <label>通知用メールアドレス</label>
      <span>{{ $input['email'] }}</span>
      <input type="hidden" name="email" value="{{ $input['email'] }}">
    </div>
    <div class="form-group">
      <label>定休日</label>
      @if (isset($input['holiday']))
      @php
      $weeks = ['日曜日','月曜日','火曜日','水曜日','木曜日','金曜日','土曜日']
      @endphp
      @foreach ($input['holiday'] as $w)
      <span>{{ $weeks[$w] }}</span>
      @endforeach
      <input type="hidden" name="holiday" value="{{ implode(",", $input['holiday']) }}">
      @else
      <span>なし</span>
      <input type="hidden" name="holiday" value="">
      @endif
    </div>
    <div class="form-group">
      <label>1日の最大予約人数</label>
      <span>{{ $input['stock'] }}人</span>
      <input type="hidden" name="stock" value="{{ $input['stock'] }}">
    </div>
    <div class="form-group">
      <label>地域共通クーポン</label>
      <span>{{ $input['coupon'] == 0 ? 'なし' : 'あり' }}</span>
      <input type="hidden" name="coupon" value="{{ $input['coupon'] }}">
    </div>
  </div>
  <div class="text-center mt-4">
    @if (isset($input['id']))
    <input type="hidden" name="id" value="{{ $input['id'] }}">
    @endif
    <input type="hidden" name="act" value="{{ $input['act'] }}">
    <button type="submit" class="btn bnt-lg btn-success text-white px-5">保存する</button>
  </div>
</form>
@endsection