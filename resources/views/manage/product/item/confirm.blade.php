@extends('layouts.manage.app')

@section('content')
<h2 class="h5 text-center font-weight-bold mb-4">こちらの内容でツアーを保存します</h2>
<form action="{{ route('manage.product.item.save', ['account' => $sub_domain]) }}" method="post">
  @csrf

  <div class="p-4 rounded-lg bg-white">
    <div class="form-group">
      <label for="shop">店舗</label>
      <span>{{ $shop->name }}</span>
      <input id="shop" type="hidden" name="shop" value="{{ $shop->id }}">
    </div>

    <div class="form-group">
      <label for="genre">ジャンル</label>
      <span>{{ $genre->name }}</span>
      <input id="genre" type="hidden" name="genre" value="{{ $genre->id }}">
    </div>

    <div class="form-group">
      <label for="name">ツアー名</label>
      <span>{{ $inputs['name'] }}</span>
      <input id="name" type="hidden" name="name" value="{{ $inputs['name'] }}">
    </div>

    <div class="form-group">
      <label for="price">価格</label>
      <span>{{ $inputs['price'] }}</span>
      <input id="price" type="hidden" name="price" value="{{ $inputs['price'] }}">
    </div>

    <div class="form-group">
      <label for="time">予約可能時間帯</label>
      <span>{!! nl2br(e($inputs['time'])) !!}</span>
      <input id="time" type="hidden" name="time" value="{{ $inputs['time'] }}">
    </div>

    <div class="form-group">
      <label for="explanation">ツアー概要</label>
      <span>{!! nl2br(e($inputs['explanation'])) !!}</span>
      <input id="explanation" type="hidden" name="explanation" value="{{ $inputs['explanation'] }}">
    </div>

    <div class="form-group">
      <label>画像</label>
      @if (count($thumbnails) > 0)
      <div class="row mx-0 px-0">
        @foreach ($thumbnails as $key => $thumbnail)
        <div class="col-4 mx-0 px-1">
          <img src="/storage/{{ str_replace('public/', '', $thumbnail) }}" alt="">
          <p class="mb-0 mt-2">{{ $inputs['caption_'.($key+1)] }}</p>
          <input type="hidden" name="{{ 'caption_'.($key+1) }}" value="{{ $inputs['caption_'.($key+1)] }}">
        </div>
        @endforeach
      </div>
      @endif
      @foreach ($thumbnails as $key => $thumbnail)
      <input type="hidden" name="thumbnail_{{ $key+1 }}" value="{{ $thumbnail }}" />
      @endforeach
    </div>

  </div>

  <div class="text-center mt-4">
    <button type="submit" class="btn bnt-lg btn-success text-white px-5">保存する</button>
  </div>
</form>
@endsection