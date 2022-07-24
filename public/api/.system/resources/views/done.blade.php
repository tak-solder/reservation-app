<!doctype html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>予約アプリ テストページ</title>
  <script charset="utf-8" src="https://static.line-scdn.net/liff/edge/2/sdk.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>
<body>
<div class="m-2">
  <div class="alert alert-success" role="alert">
    支払いが完了しました
  </div>
  <div class="mb-4">
    <button id="close" class="btn btn-primary">
      閉じる
    </button>
  </div>
</div>
<script>
  liff.init({
    liffId: '1657121951-djM6PWDE',
    withLoginOnExternalBrowser: true,
  }).then(() => {
    document.getElementById("close").addEventListener('click', () => {
      liff.closeWindow()
    })
  });
</script>
</body>
</html>
