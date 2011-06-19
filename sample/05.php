<?php echo '<?xml version="1.0" encoding="Shift_JIS"?>'."\n" ?>
<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>05.e ｺﾏｰｽ ﾄﾗｯｷﾝｸﾞ | KtaiAnalyticsｻﾝﾌﾟﾙ</title>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=Shift_JIS" />
</head>
<body>
<div style="font-size:x-small;">
<h1 style="font-size:medium;">04.e ｺﾏｰｽ ﾄﾗｯｷﾝｸﾞ</h1>
<div>e ｺﾏｰｽ ﾄﾗｯｷﾝｸﾞする場合等のｻﾝﾌﾟﾙ</div>
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
$ka->debug = true;

// プロファイルID設定(頭がMOな事に気をつけて！UAじゃないよ)
$ka->_setAccount("MO-XXXXX-YY");

// ページタイトル設定
$ka->_setTitle("e ｺﾏｰｽ ﾄﾗｯｷﾝｸﾞ | KtaiAnalyticsｻﾝﾌﾟﾙ");

// トラッキング
$ka->_trackPageview();

/*
 * e コマーストラッキング
 */
// e コマースでの決済の設定
$ka->_addTrans(
    '1234',           // 受注番号(必須)
    '婦人服',             // 提携パートナー
    '4327',          // 代金合計(必須)
    '129',           // 税金
    '1500',          // 送料
    '鎌倉市',       // 都市
    '神奈川県',     // 県
    '日本'             // 国
);
// e コマースでの各商品の設定
$ka->_addItem(
    '1234',           // 受注番号(必須) _addTrans で指定した値と同一
    'DD44',           // 品番(必須)
    'Tシャツ A',        // 商品名
    '緑 M サイズ',      // カテゴリ(サイズや色等)
    '1199',          // 商品単価(必須)
    '1'               // 購入数(必須)
);
// e コマースでの各商品の設定
$ka->_addItem(
    '1234',           // 受注番号(必須) _addTrans で指定した値と同一
    'DD45',           // 品番(必須)
    'Tシャツ B',        // 商品名
    '赤 M サイズ',      // カテゴリ(サイズや色等)
    '1499',          // 商品単価(必須)
    '1'               // 購入数(必須)
);
$ka->_trackTrans();

?>
</body>
</html>
