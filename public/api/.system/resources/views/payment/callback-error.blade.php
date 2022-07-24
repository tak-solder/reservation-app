<!doctype html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>予約エラー</title>
  <style>
    .error {
      margin: 1rem 0.5rem;
      padding: 1rem;
      border-left: 4px solid #E53E3E;
      background: #FED7D7;
    }
    .note {
      padding-top: 1.5rem;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>
<div class="error">
  {{$message}}

  <div class="note">
    予約が正常に完了していない場合、決済内容は1時間以内に返金が行われます。
  </div>
</div>
<div class="back">
  <a href="{{config('app.url')}}">トップに戻る</a>
</div>
</body>
</html>
