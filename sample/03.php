<?php echo '<?xml version="1.0" encoding="Shift_JIS"?>'."\n" ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>03.ｲﾍﾞﾝﾄﾄﾗｯｷﾝｸﾞ | KtaiAnalyticsｻﾝﾌﾟﾙ</title>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=Shift_JIS" />
</head>
<body>
<div style="font-size:x-small;">
<h1 style="font-size:medium;">03.ｲﾍﾞﾝﾄﾄﾗｯｷﾝｸﾞ</h1>
<div>ｲﾍﾞﾝﾄﾄﾗｯｷﾝｸﾞする場合等のｻﾝﾌﾟﾙ</div>
<div><a href="./index.php">目次へ戻る</a></div>
</div>

<?php
// KtaiAnalytics.php をpathの通っているディレクトリにいれてね
require_once 'KtaiAnalytics.php';
$ka = new KtaiAnalytics();

// ドキュメントルートがサブディレクトリ以下の場合(レンタルサーバーによくあるね)
// 例> https://www.exmple.com/analytics/
//$ka->img_path = 'analytics/ka.php';

// デバッグON(ka.phpのヘッダーにgoogleに対してリクエストしたURLを出力するよ)
//$ka->debug = true;

// プロファイルID設定(頭がMOな事に気をつけて！UAじゃないよ)
$ka->_setAccount("MO-XXXXX-YY");

// ページタイトル設定
$ka->_setTitle("03.ｲﾍﾞﾝﾄﾄﾗｯｷﾝｸﾞ | KtaiAnalyticsｻﾝﾌﾟﾙ");

// イベント設定
$ka->_trackEvent('category', 'action', 'opt_label', 10);
$ka->_trackEvent('category2', 'action2', 'opt_label2', 20); // 1ページで複数イベントも設定可

// トラッキング
$ka->_trackPageview();
?>
</body>
</html>
