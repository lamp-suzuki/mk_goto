@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">商品の追加・編集</h2>

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

{{-- menu --}}
@include('manage.product.menu')

<form class="form-inline bg-white p-3" action="" method="GET">
  @csrf
  <input type="search" name="search" class="form-control mr-2 bg-light" value="" placeholder="ツアー名で検索"
    style="width: 60%;" />
  <button type="submit" class="btn btn-primary">
    <i data-feather="search"></i>
    <span>絞り込み</span>
  </button>
</form>

<div class="item__list">
  <div class="item__list-wrap">
    <h3 class="item__list-name">
      <span>ツアー一覧</span>
      <a class="btn btn-success text-white float-right"
        href="{{ route('manage.product.item.add', ['account' => $sub_domain]) }}">
        <i class="d-inline-block align-middle" data-feather="plus-circle"></i>
        <span class="d-inline-block align-middle">新規追加</span>
      </a>
    </h3>
    <table class="item__list-table js-search-table">
      <thead>
        <tr>
          <th>画像</th>
          <th>状態</th>
          <th>ツアー名</th>
          <th>価格</th>
          <th class="edit">編集</th>
        </tr>
      </thead>
      <tbody class="js-sort-table-menu">
        @foreach ($tours as $tour)
        <tr>
          <td>
            @if ($tour->thumbnail_1 != null)
            <img class="item__list-thumbnail" src="{{ url($tour->thumbnail_1) }}" alt="{{ $tour->name }}" />
            @endif
          </td>
          <td class="text-nowrap">@if ($tour->status == 'draft'){{ '下書き' }}@else{{ '公開' }}@endif</td>
          <td class="name">
            <span class="d-inline-block w-100">{{ $tour->name }}</span>
          </td>
          <td>
            <span class="price">{{ number_format($tour->price) }}</span>
          </td>
          <td>
            <a href="{{ route('manage.product.item.edit', ['account' => $sub_domain, 'id' => $tour->id]) }}"
              class="edit">
              <i data-feather="edit-2"></i>
            </a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    <div class="text-center mt-4">
      {{ $tours->onEachSide(0)->links() }}
    </div>
  </div>
</div>
@endsection