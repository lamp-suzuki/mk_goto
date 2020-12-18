@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">カテゴリーの追加・編集</h2>

{{-- menu --}}
@include('manage.product.menu')

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

<div class="item__list">
  <div class="item__list-wrap border-0">
    <div class="item__list-name">
      <a href="{{ route('manage.product.category.add', ['account' => $sub_domain]) }}"
        class="btn btn-success text-white float-right">
        <i class="d-inline-block align-middle" data-feather="plus-circle"></i>
        <span class="d-inline-block align-middle">新規追加</span>
      </a>
    </div>
    <table class="item__list-table">
      <thead>
        <tr>
          <th>店舗名</th>
          <th class="edit">編集</th>
          <th class="delete">削除</th>
        </tr>
      </thead>
      <tbody class="js-sort-table-cat">
        @foreach ($categories as $cat)
        <tr data-id="{{ $cat->id }}">
          <td>{{ $cat->name }}</td>
          <td>
            <a href="{{ route('manage.product.category.edit', ['account' => $sub_domain, 'id' => $cat->id]) }}" class="edit">
              <i data-feather="edit-2"></i>
            </a>
          </td>
          <td>
            <form class="js-delete-form"
              action="{{ route('manage.product.category.delete', ['account' => $sub_domain]) }}" method="post">
              @csrf
              <input type="hidden" name="category_id" value="{{ $cat->id }}">
              <button type="submit" class="delete">
                <i data-feather="trash-2"></i>
              </button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <!-- .item__list-wrap -->
</div>
<!-- .item__list -->
@endsection