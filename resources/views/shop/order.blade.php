@extends('layouts.shop.app')

@section('page_title', 'お客様情報入力')

@section('content')
<section class="mv">
  <div class="container">
    <h2>お客様情報入力</h2>
  </div>
</section>
<div class="mv__step mb-md-5">
  <div class="container">
    <ol class="mv__step-count">
      <li class="current"><em>情報入力</em></li>
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
        <h3 class="form-ttl">お客様情報</h3>
        <div class="form-group">
          <label class="small d-block form-must" for="">氏名</label>
          <div class="row">
            <div class="col">
              <input type="text" class="form-control" id="name1" name="name1" placeholder="姓" value="{{ session('form_order.name1') }}" required />
            </div>
            <div class="col">
              <input type="text" class="form-control" id="name2" name="name2" placeholder="名" value="{{ session('form_order.name2') }}" required />
            </div>
          </div>
        </div>
        <!-- .form-group -->
        <div class="form-group">
          <label class="small d-block form-must" for="">氏名（フリガナ）</label>
          <div class="row">
            <div class="col">
              <input type="text" class="form-control" id="furi1" name="furi1" pattern="(?=.*?[\u30A1-\u30FC])[\u30A1-\u30FC\s]*" placeholder="セイ" value="{{ session('form_order.furi1') }}" required />
            </div>
            <div class="col">
              <input type="text" class="form-control" id="furi2" name="furi2" pattern="(?=.*?[\u30A1-\u30FC])[\u30A1-\u30FC\s]*" placeholder="メイ" value="{{ session('form_order.furi2') }}" required />
            </div>
          </div>
        </div>
        <!-- .form-group -->
        <div class="form-group">
          <label class="small d-block form-must" for="">携帯電話番号</label>
          <input type="tel" class="form-control" name="tel" value="{{ session('form_order.tel') }}" placeholder="000-0000-0000" />
        </div>
        <!-- .form-group -->
        <div class="form-group">
          <label class="small d-block form-must" for="">メールアドレス</label>
          <input type="email" class="form-control" name="email" value="{{ session('form_order.email') }}" placeholder="" />
          <small class="d-block form-text text-muted mt-2">※入力されたアドレスに確認メールをお送りします。
            <br>確認メールはmk_travel_tour@mk-group.co.jpより届きます。受信できるよう設定をお願いいたします。携帯メールは特にご注意ください。</small>
        </div>
        <!-- .form-group -->
        <div class="form-group">
          <label class="small d-block form-must" for="">メールアドレス（確認）</label>
          <input type="email" class="form-control" name="email_confirmation" value="" placeholder="" />
          <small class="d-block form-text text-muted mt-2">※確認のため再度上と同じメールアドレスの入力をお願いいたします。</small>
        </div>
        <!-- .form-group -->
        <div class="form-group">
          <label class="small d-block form-must" for="mailmag">メルマガを希望する</label>
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="mailmag">
            <label class="form-check-label" for="mailmag">はい</label>
          </div>
        </div>
        <!-- .form-group -->
        <div class="form-group">
          <label class="small d-block" for="other_content">特記事項</label>
          <textarea name="other_content" class="form-control" id="other_content" rows="6" placeholder="連絡事項など（アレルギー等）がございましたらご記入ください。">{!! e(session('form_order.other_content')) !!}</textarea>
        </div>
        <!-- .form-group -->
      </div>

      <div class="mt-4 container">
        <h3 class="form-ttl">決済方法</h3>
        <div class="form-group">
          <div class="form-check mb-2">
            <input class="form-check-input" type="radio" name="payment" id="pay01" value="0" checked>
            <label class="form-check-label text-body" style="font-size: 14px" for="pay01">クレジットカード</label>
          </div>
          <div class="form-check">
            <input class="form-check-input" type="radio" name="payment" id="pay02" value="1">
            <label class="form-check-label text-body" style="font-size: 14px" for="pay02">TACPOカード</label>
          </div>
          <div id="tacpo" class="form-group mb-0 mt-2" style="display:none">
            <label class="small d-block form-must" for="">カード番号</label>
            <input type="text" class="form-control" name="tacpo" value="" placeholder="半角英数字" />
          </div>
          <small class="form-text text-muted d-block mt-2">※具体的なお支払い方法についてはMKトラベルよりメールにてご案内いたします。</small>
        </div>
      </div>

      <div class="mt-4 container">
        <h3 class="form-ttl">お住まいの住所</h3>
        <div class="form-group">
          <label class="small d-block form-must" for="">郵便番号</label>
          <div class="input-group w-50">
            <div class="input-group-prepend">
              <span class="input-group-text" id="basic-zipcode">〒</span>
            </div>
            <input type="text" maxlength="8" class="form-control" id="zipcode" name="zipcode" value="{{ session('form_order.zipcode') }}" placeholder="000-0000" aria-describedby="basic-zipcode" />
          </div>
        </div>
        <!-- .form-group -->
        <div class="form-group">
          <label class="small d-block form-must" for="pref">都道府県</label>
          <select name="pref" class="form-control w-auto" id="pref" name="pref" required>
            <option value="">---</option>
            <option value="北海道"@if(session('form_order.pref')=='北海道') selected @endif>北海道</option>
            <option value="青森県"@if(session('form_order.pref')=='青森県') selected @endif>青森県</option>
            <option value="岩手県"@if(session('form_order.pref')=='岩手県') selected @endif>岩手県</option>
            <option value="宮城県"@if(session('form_order.pref')=='宮城県') selected @endif>宮城県</option>
            <option value="秋田県"@if(session('form_order.pref')=='秋田県') selected @endif>秋田県</option>
            <option value="山形県"@if(session('form_order.pref')=='山形県') selected @endif>山形県</option>
            <option value="福島県"@if(session('form_order.pref')=='福島県') selected @endif>福島県</option>
            <option value="茨城県"@if(session('form_order.pref')=='茨城県') selected @endif>茨城県</option>
            <option value="栃木県"@if(session('form_order.pref')=='栃木県') selected @endif>栃木県</option>
            <option value="群馬県"@if(session('form_order.pref')=='群馬県') selected @endif>群馬県</option>
            <option value="埼玉県"@if(session('form_order.pref')=='埼玉県') selected @endif>埼玉県</option>
            <option value="千葉県"@if(session('form_order.pref')=='千葉県') selected @endif>千葉県</option>
            <option value="東京都"@if(session('form_order.pref')=='東京都') selected @endif>東京都</option>
            <option value="神奈川県"@if(session('form_order.pref')=='神奈川県') selected @endif>神奈川県</option>
            <option value="新潟県"@if(session('form_order.pref')=='新潟県') selected @endif>新潟県</option>
            <option value="富山県"@if(session('form_order.pref')=='富山県') selected @endif>富山県</option>
            <option value="石川県"@if(session('form_order.pref')=='石川県') selected @endif>石川県</option>
            <option value="福井県"@if(session('form_order.pref')=='福井県') selected @endif>福井県</option>
            <option value="山梨県"@if(session('form_order.pref')=='山梨県') selected @endif>山梨県</option>
            <option value="長野県"@if(session('form_order.pref')=='長野県') selected @endif>長野県</option>
            <option value="岐阜県"@if(session('form_order.pref')=='岐阜県') selected @endif>岐阜県</option>
            <option value="静岡県"@if(session('form_order.pref')=='静岡県') selected @endif>静岡県</option>
            <option value="愛知県"@if(session('form_order.pref')=='愛知県') selected @endif>愛知県</option>
            <option value="三重県"@if(session('form_order.pref')=='三重県') selected @endif>三重県</option>
            <option value="滋賀県"@if(session('form_order.pref')=='滋賀県') selected @endif>滋賀県</option>
            <option value="京都府"@if(session('form_order.pref')=='京都府') selected @endif>京都府</option>
            <option value="大阪府"@if(session('form_order.pref')=='大阪府') selected @endif>大阪府</option>
            <option value="兵庫県"@if(session('form_order.pref')=='兵庫県') selected @endif>兵庫県</option>
            <option value="奈良県"@if(session('form_order.pref')=='奈良県') selected @endif>奈良県</option>
            <option value="和歌山県"@if(session('form_order.pref')=='和歌山県') selected @endif>和歌山県</option>
            <option value="鳥取県"@if(session('form_order.pref')=='鳥取県') selected @endif>鳥取県</option>
            <option value="島根県"@if(session('form_order.pref')=='島根県') selected @endif>島根県</option>
            <option value="岡山県"@if(session('form_order.pref')=='岡山県') selected @endif>岡山県</option>
            <option value="広島県"@if(session('form_order.pref')=='広島県') selected @endif>広島県</option>
            <option value="山口県"@if(session('form_order.pref')=='山口県') selected @endif>山口県</option>
            <option value="徳島県"@if(session('form_order.pref')=='徳島県') selected @endif>徳島県</option>
            <option value="香川県"@if(session('form_order.pref')=='香川県') selected @endif>香川県</option>
            <option value="愛媛県"@if(session('form_order.pref')=='愛媛県') selected @endif>愛媛県</option>
            <option value="高知県"@if(session('form_order.pref')=='高知県') selected @endif>高知県</option>
            <option value="福岡県"@if(session('form_order.pref')=='福岡県') selected @endif>福岡県</option>
            <option value="佐賀県"@if(session('form_order.pref')=='佐賀県') selected @endif>佐賀県</option>
            <option value="長崎県"@if(session('form_order.pref')=='長崎県') selected @endif>長崎県</option>
            <option value="熊本県"@if(session('form_order.pref')=='熊本県') selected @endif>熊本県</option>
            <option value="大分県"@if(session('form_order.pref')=='大分県') selected @endif>大分県</option>
            <option value="宮崎県"@if(session('form_order.pref')=='宮崎県') selected @endif>宮崎県</option>
            <option value="鹿児島県"@if(session('form_order.pref')=='鹿児島県') selected @endif>鹿児島県</option>
            <option value="沖縄県"@if(session('form_order.pref')=='沖縄県') selected @endif>沖縄県</option>
          </select>
        </div>
        <!-- .form-group -->
        <div class="form-group">
          <label class="small d-block form-must" for="address1">市区町村</label>
          <input type="text" class="form-control" id="address1" name="address1" value="{{ session('form_order.address1') }}" />
        </div>
        <!-- .form-group -->
        <div class="form-group mb-0">
          <label class="small d-block form-must" for="address2">番地 建物名</label>
          <input type="text" class="form-control" id="address2" name="address2" value="{{ session('form_order.address2') }}" />
        </div>
        <!-- .form-group -->
      </div>

      <div class="mt-4 container">
        <h3 class="form-ttl">送迎場所</h3>
        <div class="form-group">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="transfer">
            <label class="form-check-label text-body" for="transfer">お住まいの住所を送迎先に指定する</label>
          </div>
        </div>

        <div id="transfer-flag">
          <div class="form-group">
            <label class="small d-block form-must" for="">郵便番号</label>
            <div class="input-group w-50">
              <div class="input-group-prepend">
                <span class="input-group-text" id="basic-zipcode">〒</span>
              </div>
              <input type="text" maxlength="8" class="form-control" id="zipcode_transfer" name="zipcode_transfer" value="{{ session('form_order.zipcode_transfer') }}" placeholder="000-0000" aria-describedby="basic-zipcode" />
            </div>
          </div>
          <!-- .form-group -->
          <div class="form-group">
            <label class="small d-block form-must" for="pref_transfer">都道府県</label>
            <select name="pref_transfer" class="form-control w-auto" id="pref_transfer">
              <option value="">---</option>
              <option value="北海道"@if(session('form_order.pref_transfer')=='北海道') selected @endif>北海道</option>
              <option value="青森県"@if(session('form_order.pref_transfer')=='青森県') selected @endif>青森県</option>
              <option value="岩手県"@if(session('form_order.pref_transfer')=='岩手県') selected @endif>岩手県</option>
              <option value="宮城県"@if(session('form_order.pref_transfer')=='宮城県') selected @endif>宮城県</option>
              <option value="秋田県"@if(session('form_order.pref_transfer')=='秋田県') selected @endif>秋田県</option>
              <option value="山形県"@if(session('form_order.pref_transfer')=='山形県') selected @endif>山形県</option>
              <option value="福島県"@if(session('form_order.pref_transfer')=='福島県') selected @endif>福島県</option>
              <option value="茨城県"@if(session('form_order.pref_transfer')=='茨城県') selected @endif>茨城県</option>
              <option value="栃木県"@if(session('form_order.pref_transfer')=='栃木県') selected @endif>栃木県</option>
              <option value="群馬県"@if(session('form_order.pref_transfer')=='群馬県') selected @endif>群馬県</option>
              <option value="埼玉県"@if(session('form_order.pref_transfer')=='埼玉県') selected @endif>埼玉県</option>
              <option value="千葉県"@if(session('form_order.pref_transfer')=='千葉県') selected @endif>千葉県</option>
              <option value="東京都"@if(session('form_order.pref_transfer')=='東京都') selected @endif>東京都</option>
              <option value="神奈川県"@if(session('form_order.pref_transfer')=='神奈川県') selected @endif>神奈川県</option>
              <option value="新潟県"@if(session('form_order.pref_transfer')=='新潟県') selected @endif>新潟県</option>
              <option value="富山県"@if(session('form_order.pref_transfer')=='富山県') selected @endif>富山県</option>
              <option value="石川県"@if(session('form_order.pref_transfer')=='石川県') selected @endif>石川県</option>
              <option value="福井県"@if(session('form_order.pref_transfer')=='福井県') selected @endif>福井県</option>
              <option value="山梨県"@if(session('form_order.pref_transfer')=='山梨県') selected @endif>山梨県</option>
              <option value="長野県"@if(session('form_order.pref_transfer')=='長野県') selected @endif>長野県</option>
              <option value="岐阜県"@if(session('form_order.pref_transfer')=='岐阜県') selected @endif>岐阜県</option>
              <option value="静岡県"@if(session('form_order.pref_transfer')=='静岡県') selected @endif>静岡県</option>
              <option value="愛知県"@if(session('form_order.pref_transfer')=='愛知県') selected @endif>愛知県</option>
              <option value="三重県"@if(session('form_order.pref_transfer')=='三重県') selected @endif>三重県</option>
              <option value="滋賀県"@if(session('form_order.pref_transfer')=='滋賀県') selected @endif>滋賀県</option>
              <option value="京都府"@if(session('form_order.pref_transfer')=='京都府') selected @endif>京都府</option>
              <option value="大阪府"@if(session('form_order.pref_transfer')=='大阪府') selected @endif>大阪府</option>
              <option value="兵庫県"@if(session('form_order.pref_transfer')=='兵庫県') selected @endif>兵庫県</option>
              <option value="奈良県"@if(session('form_order.pref_transfer')=='奈良県') selected @endif>奈良県</option>
              <option value="和歌山県"@if(session('form_order.pref_transfer')=='和歌山県') selected @endif>和歌山県</option>
              <option value="鳥取県"@if(session('form_order.pref_transfer')=='鳥取県') selected @endif>鳥取県</option>
              <option value="島根県"@if(session('form_order.pref_transfer')=='島根県') selected @endif>島根県</option>
              <option value="岡山県"@if(session('form_order.pref_transfer')=='岡山県') selected @endif>岡山県</option>
              <option value="広島県"@if(session('form_order.pref_transfer')=='広島県') selected @endif>広島県</option>
              <option value="山口県"@if(session('form_order.pref_transfer')=='山口県') selected @endif>山口県</option>
              <option value="徳島県"@if(session('form_order.pref_transfer')=='徳島県') selected @endif>徳島県</option>
              <option value="香川県"@if(session('form_order.pref_transfer')=='香川県') selected @endif>香川県</option>
              <option value="愛媛県"@if(session('form_order.pref_transfer')=='愛媛県') selected @endif>愛媛県</option>
              <option value="高知県"@if(session('form_order.pref_transfer')=='高知県') selected @endif>高知県</option>
              <option value="福岡県"@if(session('form_order.pref_transfer')=='福岡県') selected @endif>福岡県</option>
              <option value="佐賀県"@if(session('form_order.pref_transfer')=='佐賀県') selected @endif>佐賀県</option>
              <option value="長崎県"@if(session('form_order.pref_transfer')=='長崎県') selected @endif>長崎県</option>
              <option value="熊本県"@if(session('form_order.pref_transfer')=='熊本県') selected @endif>熊本県</option>
              <option value="大分県"@if(session('form_order.pref_transfer')=='大分県') selected @endif>大分県</option>
              <option value="宮崎県"@if(session('form_order.pref_transfer')=='宮崎県') selected @endif>宮崎県</option>
              <option value="鹿児島県"@if(session('form_order.pref_transfer')=='鹿児島県') selected @endif>鹿児島県</option>
              <option value="沖縄県"@if(session('form_order.pref_transfer')=='沖縄県') selected @endif>沖縄県</option>
            </select>
          </div>
          <!-- .form-group -->
          <div class="form-group">
            <label class="small d-block form-must" for="address1_transfer">市区町村</label>
            <input type="text" class="form-control" id="address1_transfer" name="address1_transfer" value="{{ session('form_order.address1_transfer') }}" />
          </div>
          <!-- .form-group -->
          <div class="form-group mb-0">
            <label class="small d-block form-must" for="address2_transfer">番地 建物名</label>
            <input type="text" class="form-control" id="address2_transfer" name="address2_transfer" value="{{ session('form_order.address2_transfer') }}" />
            <small class="form-text text-muted d-block mt-2">【送迎エリア】
              <br>京都市（一部除く）、宇治市（一部除く）、城陽市、長岡京市、向日町、八幡市。
              <br>大津市（一人1,000円追加、高速代別途）。
              <br>亀岡市、草津市、栗東市、守山市（一人2,000円追加、高速代別途）。
              <br>※追加料金分は当日現地でのお支払いとなり、GoToトラベルキャンペーン対象外となります。
              <br>※京都市、宇治市の次のエリアは本件対象外とさせていただきます。
              <br>　北区中川・小野・杉阪・真弓・大森・雲ヶ畑
              <br>　右京区京北・嵯峨清滝・嵯峨水尾・嵯峨越畑・嵯峨樒原
              <br>　左京区花脊・広河原・久多・大原
              <br>　伏見区醍醐陀羅谷
              <br>　宇治市炭山・二尾・池尾・笠取</small>
          </div>
          <!-- .form-group -->
        </div>
      </div>

      <div class="mt-4 container">
        <h3 class="form-ttl">経由地</h3>
        <div class="form-group">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="1" id="waypoint">
            <label class="form-check-label text-body" for="waypoint">経由地を追加する<small class="text-muted">（2名につき1箇所を記載）</small></label>
          </div>
        </div>
        <div id="waypoint-wrap" class="form-group" style="display:none">
          <label class="small d-block">住所</label>
          <textarea name="waypoint_address" id="waypoint_address" rows="6" class="form-control" placeholder="〇〇県〇〇市〇〇区〇〇ビル1F100号室">{!! e(session('form_order.waypoint_address')) !!}</textarea>
        </div>
      </div>

      <div class="mt-5 container">
        <h3 class="form-ttl">ご注意事項</h3>
        <p class="mb-0 form-text text-muted small">※自動返信メール配信後、2日以内に予約確認メールをお送りして予約完了となります。予約確認メールが届かない場合はお手数ですが、お問い合せください（GoToトラベル専用ダイヤル：075-757-6221）。なお、確認メールはmk_travel_tour@mk-group.co.jpより届きます。受信できるよう設定をお願いいたします。特に携帯のメールアドレスをお使いの場合、着信制限をされていると確認メールが届かない場合がございますので、ご注意ください。
          <br>※必ず期日までにお支払をお願いします。期日までに支払を確認できない場合、予約をキャンセルさせていただく場合があります。10日前以降のキャンセルの場合は、キャンセル料が必要となりますので、ご注意願います。
          <br>※ご予約はご利用日4日前の17時までとなります。</p>
      </div>

    </div>
  </div>
  <div>
    <div class="py-4 bg-light">
      <div class="container">
        <div class="d-flex justify-content-center form-btns">
          <a class="btn btn-lg bg-white btn-back mr-2" href="{{ route('shop.cart', ['account' => $sub_domain]) }}">戻る</a>
          <button class="btn btn-lg btn-primary" type="submit">確認する</button>
        </div>
      </div>
    </div>
  </div>
</form>

<script src="//code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="//jpostal-1006.appspot.com/jquery.jpostal.js"></script>
<script>
$('#zipcode').jpostal({
  postcode : [
    '#zipcode' // 郵便番号のid名
  ],
  address : {
    '#pref' : '%3', // %3 = 都道府県
    '#address1' : '%4%5', // %4 = 市区町村, %5 = 町名
  }
});
</script>
@endsection