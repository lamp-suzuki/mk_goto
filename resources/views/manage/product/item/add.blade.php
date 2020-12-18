@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">ツアーの新規追加</h2>

<form action="{{ route('manage.product.item.confirm', ['account' => $sub_domain]) }}" method="post"
  enctype="multipart/form-data">
  @csrf

  <div class="form-group">
    <label for="shop">店舗</label>
    <select name="shop" id="shop" class="form-control @error('shop') is-invalid @enderror" required>
      <option value="">選択してください</option>
      @if($shops)
      @foreach ($shops as $shop)
      <option value="{{ $shop->id }}">{{ $shop->name }}</option>
      @endforeach
      @endif
    </select>
  </div>

  <div class="form-group">
    <label for="genre">ジャンル</label>
    <select name="genre" id="genre" class="form-control @error('genre') is-invalid @enderror" required>
      <option value="">選択してください</option>
      @if($genres)
      @foreach ($genres as $genre)
      <option value="{{ $genre->id }}">{{ $genre->name }}</option>
      @endforeach
      @endif
    </select>
  </div>

  <div class="form-group">
    <label for="name">ツアー名</label>
    <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" required>
  </div>

  <div class="form-group">
    <label for="price">価格</label>
    <div class="input-group">
      <input type="number" id="price" name="price" class="form-control @error('price') is-invalid @enderror" aria-describedby="yen">
      <div class="input-group-append">
        <span class="input-group-text" id="yen">円</span>
      </div>
    </div>
  </div>

  <div class="form-group">
    <label for="time">予約可能時間帯</label>
    <textarea name="time" id="time" class="form-control @error('time') is-invalid @enderror" cols="30" rows="10" placeholder="{{ "午前中\n14:00-16:00\n16:00-18:00\n18:00-20:00\n19:00-21:00" }}" required></textarea>
  </div>

  <div class="form-group">
    <label for="explanation">ツアー概要</label>
    <textarea name="explanation" id="explanation" class="form-control @error('explanation') is-invalid @enderror" cols="30" rows="10" required></textarea>
  </div>

  <div class="form-group">
    <label for="thumbnail_1">1. 画像</label>
    <input type="file" class="form-control-file" name="thumbnail_1" id="thumbnail_1" accept=".jpg, .jpeg, .png, .gif">
    <label for="caption_1" class="mt-3">1. キャプション</label>
    <input type="text" class="form-control" name="caption_1" id="caption_1" placeholder="21文字以内推奨">
    <small class="form-text text-muted d-block mt-2">※3枚まで追加できます。<br>※幅1204pxの画像を推奨しています。<br>※対応ファイル：jpg.png.gif</small>
  </div>
  <div class="form-group">
    <label for="thumbnail_1">2. 画像</label>
    <input type="file" class="form-control-file" name="thumbnail_2" id="thumbnail_2" accept=".jpg, .jpeg, .png, .gif">
    <label for="caption_1" class="mt-3">2. キャプション</label>
    <input type="text" class="form-control" name="caption_2" id="caption_2" placeholder="21文字以内推奨">
  </div>
  <div class="form-group">
    <label for="thumbnail_1">3. 画像</label>
    <input type="file" class="form-control-file" name="thumbnail_3" id="thumbnail_3" accept=".jpg, .jpeg, .png, .gif">
    <label for="caption_1" class="mt-3">3. キャプション</label>
    <input type="text" class="form-control" name="caption_3" id="caption_3" placeholder="21文字以内推奨">
  </div>

  <div class="d-flex mt-3">
    <button type="submit" class="btn btn-success text-white">確認する</button>
  </div>
</form>
@endsection