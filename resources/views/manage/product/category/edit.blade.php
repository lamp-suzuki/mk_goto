@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">店舗の編集</h2>

{{-- 成功メッセージ --}}
@if(session()->has('message'))
<div class="alert alert-info alert-dismissible fade show mt-3">
  {{ session('message') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

{{-- エラーメッセージ --}}
@if(session()->has('error'))
<div class="alert alert-danger alert-dismissible fade show mt-3">
  {{ session('error') }}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif

<form action="{{ route('manage.product.category.confirm', ['account' => $sub_domain]) }}" method="post">
  @csrf

  <div class="form-group">
    <label for="area">エリア</label>
    <select name="area" id="area" class="form-control w-auto @error('area') is-invalid @enderror" required>
      <option value="">選択してください</option>
      <option value="京都" @if($shop->area == '京都'){{ 'selected' }}@endif>京都</option>
      <option value="滋賀" @if($shop->area == '滋賀'){{ 'selected' }}@endif>滋賀</option>
      <option value="大阪" @if($shop->area == '大阪'){{ 'selected' }}@endif>大阪</option>
      <option value="神戸" @if($shop->area == '神戸'){{ 'selected' }}@endif>神戸</option>
      <option value="東京" @if($shop->area == '東京'){{ 'selected' }}@endif>東京</option>
      <option value="名古屋" @if($shop->area == '名古屋'){{ 'selected' }}@endif>名古屋</option>
      <option value="福岡" @if($shop->area == '福岡'){{ 'selected' }}@endif>福岡</option>
      <option value="札幌" @if($shop->area == '札幌'){{ 'selected' }}@endif>札幌</option>
    </select>
  </div>

  <div class="form-group">
    <label for="name">店舗名</label>
    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $shop->name }}" required>
  </div>

  <div class="form-group">
    <label for="holiday">定休日（指定した曜日すべてが予約不可になります）</label>
    @php
    $num = 0;
    $weeks = ['sun'=>'日曜日','mon'=>'月曜日','tue'=>'火曜日','wed'=>'水曜日','thu'=>'木曜日','fri'=>'金曜日','sut'=>'土曜日'];
    if ($shop->holiday != null && $shop->holiday != '') {
        $holiday = explode(",", $shop->holiday);
    } else {
        $holiday = [];
    }
    @endphp
    @foreach ($weeks as $keys => $w)
    <div class="form-check form-check-inline">
      <input class="form-check-input" type="checkbox" name="holiday[]" id="{{ $keys }}" value="{{ $num }}" @if(in_array($num, $holiday)){{ 'checked' }}@endif>
      <label class="form-check-label text-body" for="{{ $keys }}">{{ $w }}</label>
    </div>
    @php ++$num; @endphp
    @endforeach
  </div>

  <div class="form-group">
    <label for="stock">1日の最大予約人数</label>
    <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" min="2" value="{{ $shop->stock }}" required>
  </div>

  <div class="form-group">
    <label for="coupon">地域共通クーポン</label>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="coupon" id="exampleRadios1" value="0" @if($shop->coupon == 0){{ 'checked' }}@endif>
      <label class="form-check-label text-body" for="exampleRadios1">なし</label>
    </div>
    <div class="form-check">
      <input class="form-check-input" type="radio" name="coupon" id="exampleRadios2" value="1" @if($shop->coupon == 1){{ 'checked' }}@endif>
      <label class="form-check-label text-body" for="exampleRadios2">あり</label>
    </div>
  </div>

  <div class="mt-4 text-center">
    <input type="hidden" name="id" value="{{ $shop->id }}">
    <input type="hidden" name="act" value="edit">
    <button type="submit" class="btn btn-success text-white">確認する</button>
  </div>

</form>
@endsection