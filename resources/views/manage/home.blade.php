@extends('layouts.manage.app')

@section('content')
<h2 class="page-ttl">トップ</h2>
<div class="d-lg-flex align-items-start">
  <div class="content sales w-100">
    <div class="content-head">
      <h3 class="text-center font-weight-bold">
        <span>本日の売上</span>
      </h3>
    </div>
    <div class="content-body">
      <p class="price">
        <span class="number">{{ number_format($today_earnings) }}</span>
        <span class="compa">
          前日比
          @if ($comparison > 0)
          <span class="text-success">{{ $comparison }}%</span>
          @else
          <span class="text-danger">{{ $comparison }}%</span>
          @endif
        </span>
      </p>
    </div>
  </div>
  <!-- .content -->
  <div class="content">
    <div class="content-head">
      <h3>
        <i data-feather="info"></i>
        <span>ご予約受け付け設定</span>
      </h3>
    </div>
    <div class="content-body">
      <div class="custom-control custom-switch">
        <input type="checkbox" class="custom-control-input" id="shop_close" value="1">
        <label class="custom-control-label" for="shop_close">一時的にご予約を受け付けない</label>
      </div>
    </div>
  </div>
  <!-- .content -->
  <div class="content">
    <div class="content-head">
      <h3>
        <i data-feather="clipboard"></i>
        <span>最新の予約</span>
        <span class="badge badge-pill badge-secondary">{{ count($orders) }}</span>
      </h3>
      <a class="link" href="{{ route('manage.order.index', ['account' => $sub_domain]) }}">一覧へ</a>
    </div>
    <div class="content-body p-0">
      <div class="order-list">
        @foreach ($orders as $order)
        <a class="order-item" href="{{ route('manage.order.detail', ['account' => $sub_domain, 'id' => $order->id]) }}">
          <span class="cats">{{ $order->service }}</span>
          <p class="name">{{ $order->furigana }}</p>
          <p class="date">{{ $order->created_at }}</p>
        </a>
        @endforeach
        @if(count($orders) === 0)
        <p class="m-0 p-2">まだ予約がありません。</p>
        @endif
      </div>
      <!-- .order-list -->
    </div>
    <!-- .content-body -->
  </div>
  <!-- .content -->
</div>
<!-- .d-lg-flex -->
@endsection