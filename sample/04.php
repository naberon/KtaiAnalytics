<?php echo '<?xml version="1.0" encoding="Shift_JIS"?>'."\n" ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>04.ｶｽﾀﾑ変数 | KtaiAnalyticsｻﾝﾌﾟﾙ</title>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=Shift_JIS" />
</head>
<body>
<div style="font-size:x-small;">
<h1 style="font-size:medium;">04.ｶｽﾀﾑ変数</h1>
<div>ｶｽﾀﾑ変数を設定する場合等のｻﾝﾌﾟﾙ</div>
<div><a href="./index.php">目次へ戻る</a></div>
</div>

<?php
// KtaiAnalytics.php をpathの通っているディレクトリにいれてね
require_once 'KtaiAnalytics.php';
$ka = new KtaiAnalytics();

//$ka->img_path = 'analytics/ka.php';
//$ka->debug = true;

// プロファイルID設定
$ka->_setAccount("MO-XXXXX-YY");
// ページタイトル設定
$ka->_setTitle("04.ｶｽﾀﾑ変数 | KtaiAnalyticsｻﾝﾌﾟﾙ");

// カスタム変数の設定(5個まで)
// 例>ログイン完了後にユーザーの個人情報を設定
$ka->_setCustomVar(1, "userID", "10025", 2); // 1.ユーザーID 10025
$ka->_setCustomVar(2, "sex", "male", 2); // 2.性別 男
$ka->_setCustomVar(3, "generation", "30-39", 2); // 3.世代 30代
$ka->_setCustomVar(4, "pref", "tokyo", 2); // 4.地域 東京
$ka->_setCustomVar(5, "mail", "OFF", 2); // 5.メルマガ会員 ではない

// トラッキング実行
$ka->_trackPageview();
?>
</body>
</html>
