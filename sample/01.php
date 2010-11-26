<?php echo '<?xml version="1.0" encoding="Shift_JIS"?>'."\n" ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>01.基本ﾄﾗｯｷﾝｸﾞ | KtaiAnalyticsｻﾝﾌﾟﾙ</title>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=Shift_JIS" />
</head>
<body>
<div style="font-size:x-small;">
<h1 style="font-size:medium;">01.基本ﾄﾗｯｷﾝｸﾞ</h1>
<div>ﾍﾟｰｼﾞﾀｲﾄﾙを設定したシンプルなﾄﾗｯｷﾝｸﾞのｻﾝﾌﾟﾙ</div>
<div><a href="./index.php">目次へ戻る</a></div>
</div>

<?php
// KtaiAnalytics.php をpathの通っているディレクトリにいれてね
require_once 'KtaiAnalytics.php';
$ka = new KtaiAnalytics();

// ドキュメントルートがサブディレクトリ以下の場合(レンタルサーバーによくあるね)
// 例> https://www.exmple.com/analytics/
//$ka->img_path = 'analytics/ka.php';

// デバッグON(ka.phpのヘッダーにgoogleに対してリクエストしたURLを出力するのです)
//$ka->debug = true;

// プロファイルID設定(頭がMOな事に気をつけて！UAじゃないよ)
$ka->_setAccount("MO-XXXXX-YY");

// ページタイトル設定(Google公開の標準ライブラリではタイトルは指定できない。なんでだよ)
$ka->_setTitle("01.基本ﾄﾗｯｷﾝｸﾞ | KtaiAnalyticsｻﾝﾌﾟﾙ");

// 設定した内容をトラッキング(これだけです。ね? 簡単でしょう?)
$ka->_trackPageview();
?>
</body>
</html>
