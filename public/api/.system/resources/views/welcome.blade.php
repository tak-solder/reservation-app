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
  <div class="mb-4">
    <button id="send-message" class="btn btn-primary">
      メッセージテスト
    </button>
  </div>
  <div class="mb-4">
    <a class="btn btn-primary" href="{{url('stripe/checkout')}}">
      決済テスト
    </a>
  </div>
  <div class="mb-4">
    <button id="close" class="btn btn-primary">
      閉じる
    </button>
  </div>
  <div>
    <table class="table table-condensed">
      <tbody>
      <tr>
        <th>ユーザー名</th>
        <td id="liff-user"></td>
      </tr>
      <tr>
        <th>ユーザーID</th>
        <td id="liff-id"></td>
      </tr>
      <tr>
        <th>IDトークン</th>
        <td id="liff-token"></td>
      </tr>
      <tr>
        <th>getDecodedIDToken</th>
        <td id="liff-getDecodedIDToken"></td>
      </tr>
      <tr>
        <th>getFriendship</th>
        <td id="liff-getFriendship"></td>
      </tr>
      </tbody>
    </table>
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

    liff.getProfile().then(profile => {
      document.getElementById("liff-user").innerText = profile.displayName
      document.getElementById("liff-id").innerText = profile.userId
    })
    document.getElementById("liff-token").innerText = liff.getIDToken()
    document.getElementById("liff-getDecodedIDToken").innerText = JSON.stringify(liff.getDecodedIDToken())
    liff.getFriendship().then((data) => {
      console.log(data);
      document.getElementById("liff-getFriendship").innerText = data.friendFlag ? '登録済み' : '未登録'
    })


    document.getElementById("send-message").addEventListener('click', () => {
      window.location.href = './line/me?token=' + liff.getIDToken();
    })
  });
</script>
</body>
</html>
