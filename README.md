# KtaiAnalytics

## KtaiAnalyticsとは？

KtaiAnalyticsは、携帯電話からGoogle Analyticsにトラッキングを行う為のライブラリです。
また、Googleが公開している"ga.php"を拡張し、カスタム変数やeコマース等を利用できるようにしたい。

2009年10月に、Googleから今後は携帯電話も対応する事を発表し、2010年2月に正式対応。正式対応のがアナウンスと同時にGoogleから公開されたライブラリは、誰でも使えるといえば聞こえは良いですが、アクセスしたのURLとリファラを単純にトラッキングする事しかできないものでした。
KtaiAnalyticsでは、"機能の追加"と"使い勝手の改善"を目指します。


## 利用できる機能

  - 通常のトラッキング
  - 仮想URLのトラッキング
  - ページタイトルの設定


## インストール
1. lib/KtaiAnalytics.php をライブラリに配置
2. htdocs/ka.php をドキュメントルートに配置


## チュートリアル

    <?php
    require_once 'KtaiAnalytics.php';
    $ka = new KtaiAnalytics();
    // プロファイルID設定
    $ka->_setAccount("MO-XXXXX-YY");
    // ページタイトル設定
    $ka->_setTitle("チュートリアル | KtaiAnalytics");
    // トラッキング実行
    $ka->_trackPageview();
    ?>

詳しくはサンプルから確認できます。


## クラスドキュメント

### メソッド

#### KtaiAnalytics::\_trackPageview($opt\_pageURL)
**$opt_pageURL** で指定されたページURLでトラッキングを行います。指定が無い場合は、自動的に現在のURLでトラッキング。

#### KtaiAnalytics::\_setAccount($accountId)
**$accountId** で指定されたトラッキング オブジェクトのウェブ プロパティ ID を設定します。

#### KtaiAnalytics::\_setTitle($pageTitle)
**$pageTitle** で指定されたページタイトルを設定します。

### 変数

#### KtaiAnalytics::img\_path
ka.php のパスを指定します。デフォルトはドメインルート(/ka.php)です。

#### KtaiAnalytics::debug
TRUEにする事で、ka.phpのレスポンスヘッダにトラッキングリクエストを出力します。デフォルトはfalseです。


## FAQ

### 募集中です


## ChangeLog

### 0.1.0
  - Google公開ライブラリga.phpと同等機能追加
  - 仮想URLのトラッキング追加
  - ページタイトルの設定追加
