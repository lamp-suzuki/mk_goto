<div class="page-tab">
  <a href="{{ route('manage.product.index', ['account' => $sub_domain]) }}" @if (\Route::currentRouteName()==='manage.product.index' ) class="active" @endif>
    <i data-feather="book"></i>
    <span>ツアー一覧</span>
  </a>
  <a href="{{ route('manage.product.category.index', ['account' => $sub_domain]) }}" @if (\Route::currentRouteName()==='manage.product.category.index' ) class="active" @endif>
    <i data-feather="tag"></i>
    <span>店舗一覧</span>
  </a>
  <a href="{{ route('manage.product.genre.index', ['account' => $sub_domain]) }}" @if (\Route::currentRouteName()==='manage.product.genre.index' ) class="active" @endif>
    <i data-feather="plus-square"></i>
    <span>料理ジャンル</span>
  </a>
</div>