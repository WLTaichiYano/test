<?php
	
	mb_language('ja');
	mb_internal_encoding('UTF-8');
	mb_regex_encoding('UTF-8');
	header('Content-Type: text/html; charset=UTF-8');
	require_once('assets/php/config.php');
	
	
	try {
        $dbh = new PDO(DSN, DB_USER, DB_PASSWORD);
        $stmt = $dbh -> query("SET NAMES utf8;");
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
    
    
	//get tags
	$get_tags = $dbh->query("select * from tags ORDER BY count limit 50");
	$get_tags->execute();

?>
<!DOCTYPE html>
<html>
  <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
    <meta charset="UTF-8">

    <title>サイトマップ | mono studio[モノスタジオ]</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="@monostudio_jp">
	<meta name="twitter:title" content="サイトマップ | mono studio[モノスタジオ]">
	<meta name="twitter:description" content="mono studio[モノスタジオ]は「家電」に関する知恵やノウハウが集まる情報サイトです。スマートフォン、パソコン、テレビ、カメラ、生活家電、キッチン家電、美容・健康家電、ガジェットなどに関する疑問や悩みがある方にとって役立つ情報を紹介しています。">
	<meta name="twitter:image" content="">
    <meta property="fb:app_id" content="180196992327206">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:title" content="サイトマップ | mono studio[モノスタジオ]">
    <meta property="og:type" content="website">
    <meta property="og:image" content="o">
    <meta property="og:url" content="https://monostudio.jp/">
    <meta property="og:site_name" content="mono studio">
    <meta property="og:description" content="mono studio[モノスタジオ]は「家電」に関する知恵やノウハウが集まる情報サイトです。スマートフォン、パソコン、テレビ、カメラ、生活家電、キッチン家電、美容・健康家電、ガジェットなどに関する疑問や悩みがある方にとって役立つ情報を紹介しています。">
    <meta name="p:domain_verify" content="6ae5c3b79f2be421e8e68b1471007762">
	<link rel="canonical" href="https://monostudio.jp/sitemap.php">
	<meta name="robots" content="noindex,follow" />
	<link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
        
  </head>

  <body id="" class="lists lists-index">
	  <!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-5FS24Q"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5FS24Q');</script>
<!-- End Google Tag Manager -->
  <header class="m-header">
  <div class="m-header-inner">
        <h1 class="m-header-logo"><a href="https://monostudio.jp"><img src="images/logo.jpg" alt="monostudio" style="height: 25px;"></a></h1>

    <form accept-charset="UTF-8" action="search.php" class="m-header-search" id="searchForm" method="get"><div style="margin:0;padding:0;display:inline"><input type="hidden" /></div>
      <input class="m-header-search-input" id="q" name="query" placeholder="気になるワードを入力" type="text" value=""/>
      <input class="m-header-search-button" type="submit" value="" />
</form>
      <!--<ul class="m-header-navi">
          <li class="m-header-navi-menu"><a href="#">無料会員登録</a></li>
          <li class="m-header-navi-menu"><a href="#">ログイン</a></li>
      </ul>-->
  </div>
</header>



<section id="topBar">
  <ul class="topBar_in breadcrumb">
    <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="https://monostudio.jp/" itemprop="url"><span itemprop="title">mono studioトップ</span></a></li>
      <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><strong itemprop="title">サイトマップ</strong></li>
  </ul>
</section>

<div id="wrapper">
  <h1 class="static_title">サイトマップ</h1>
  <p class="keywordsLead">
    MonoStudioのサイトマップページです。こちらのページからさまざまなページへ移動することができます。
  </p>
  
  <table class="sitemap">
    <thead></thead>
    <tbody>
      <tr>
        <th><a href="https://monostudio.jp">MonoStudio　[モノスタジオ]　トップ</a></th>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <th>大カテゴリ</th>
        <td>
          <ul>
            <li><a href="pc_tablet">パソコン</a></li>
            <li><a href="smartphone_mobile">スマートフォン・タブレット</a></li>
            <li><a href="image_audio">映像・オーディオ</a></li>
            <li><a href="camera">カメラ</a></li>
            <li><a href="kitchen">キッチン</a></li>
            <li><a href="home_app">生活家電</a></li>
            <li><a href="beauty_health">美容・健康</a></li>
          </ul>
        </td>
      </tr>
            <tr>
        <th>中カテゴリ</th>
        <td>
          <ul>
            <li><a href="desktoppc">デスクトップパソコン</a></li>
            <li><a href="notepc">ノートパソコン</a></li>
            <li><a href="mac">mac</a></li>
            <li><a href="computerperipherals">パソコン周辺機器</a></li>
            <li><a href="smartphone">スマートフォン</a></li>
            <li><a href="smarphoneperipheralequipment">スマートフォン周辺機器</a></li>
            <li><a href="tablet">タブレット</a></li>
            <li><a href="tv">テレビ</a></li>
            <li><a href="headphone_earphone">ヘッドホン・イヤホン</a></li>
            <li><a href="speaker">スピーカー</a></li>
            <li><a href="degitalcamera">デジタルカメラ</a></li>
            <li><a href="singlelensreflexcamera">デジタル一眼レフカメラ</a></li>
            <li><a href="videocamera">ビデオカメラ</a></li>
            <li><a href="ricecooker">炊飯器</a></li>
            <li><a href="microwave">電子レンジ・オーブンレンジ</a></li>
            <li><a href="refrigerator">冷蔵庫・冷凍庫</a></li>
            <li><a href="dishwashers">食洗機・食器乾燥機</a></li>
            <li><a href="washingmachine">洗濯機</a></li>
            <li><a href="vacuumcleaner">掃除機</a></li>
            <li><a href="power_assisted_bicycle">電動アシスト自転車</a></li>
            <li><a href="airpurifier">空気清浄機</a></li>
            <li><a href="dehumidifier_humidifier">除湿機・加湿器</a></li>
            <li><a href="dryer_hairiron">ドライヤー・ヘアアイロン</a></li>
            <li><a href="weighingscale_bodyfatscale">体重計・体脂肪計</a></li>
            <li><a href="sphygmomanometer_thermometer">血圧計・体温計</a></li>
            <li><a href="shaver">シェーバー</a></li>
            <li><a href="beautyequipment">美容家電</a></li>
          </ul>
        </td>
      </tr>
      <tr>
        <th><a href="http://mery.jp/tag">キーワード</a></th>
        <td>
          <ul>
	          <!--50個-->
	          <?php while($tag = $get_tags->fetch(PDO::FETCH_ASSOC)){ ?>
              <li>
                <a href="tags-<?= $tag["id"]; ?>"><?= $tag["tag_title"]; ?></a>
              </li>
              <?php } ?>
          </ul>
        </td>
      </tr>
    </tbody>
  </table>
</div>  

<footer class="m-footer">
  <div class="m-footer-inner">
    <div class="m-footer-logo">
    	mono studio
    </div>

    
    <div class="m-footer-column">
      <ul class="m-footer-column-list clearfix">
        <li><a href="https://monostudio.jp/">トップページ</a></li>
        <li><a href="http://white-label.wix.com/whitelabel">運営会社</a></li>
        <li><a href="sitemap.php">サイトマップ</a></li>
        <li><a href="report.php">お問い合わせ</a></li>
        <li><a href="rule.php">利用規約</a></li>
        <li><a href="policy.php">プライバシーポリシー</a></li>
      </ul>

    </div>
    
    
  </div>
  <div class="m-footerBottom">

  <p class="m-footerBottom-copyright">Copyright © 2015 mono stugio All Rights Reserved.</p>
</div>
</footer>
</body></html>