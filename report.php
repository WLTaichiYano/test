<?php
	
	mb_language('ja');
	mb_internal_encoding('UTF-8');
	mb_regex_encoding('UTF-8');
	header('Content-Type: text/html; charset=UTF-8');
	require_once('assets/php/config.php');
	
	
	if(!empty($_POST)){
		
		
		
		
		//日本語メール送信
		$to = "info@whitelabel.co.jp";//宛先
		$subject = "monostudioお問い合わせ (".$_POST["report_name"]."さん)";//題名
		$body = $_POST["report_content"];//本文
		$from = $_POST["report_emaiil"];//差出人
		mail($to,$subject,$body,$from);
		
		echo "<script type='text/javascript'>
			alert('お問い合わせありがとうございます。正常に送信されました');
			location.href = 'https://monostudio.jp/';
		</script>";
		
		
		
	}

?>
<!DOCTYPE html>
<html>
  <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
    <meta charset="UTF-8">

    <title>お問い合わせ | mono studio[モノスタジオ]</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="description" content="mono studio[モノスタジオ]は「家電」に関する知恵やノウハウが集まる情報サイトです。スマートフォン、パソコン、テレビ、カメラ、生活家電、キッチン家電、美容・健康家電、ガジェットなどに関する疑問や悩みがある方にとって役立つ情報を紹介しています。">
    <meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="@monostudio_jp">
	<meta name="twitter:title" content="お問い合わせ | mono studio[モノスタジオ]">
	<meta name="twitter:description" content="mono studio[モノスタジオ]は「家電」に関する知恵やノウハウが集まる情報サイトです。スマートフォン、パソコン、テレビ、カメラ、生活家電、キッチン家電、美容・健康家電、ガジェットなどに関する疑問や悩みがある方にとって役立つ情報を紹介しています。">
	<meta name="twitter:image" content="">
    <meta property="fb:app_id" content="180196992327206">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:title" content="お問い合わせ | mono studio[モノスタジオ]">
    <meta property="og:type" content="website">
    <meta property="og:image" content="o">
    <meta property="og:url" content="https://monostudio.jp/">
    <meta property="og:site_name" content="mono studio">
    <meta property="og:description" content="mono studio[モノスタジオ]は「家電」に関する知恵やノウハウが集まる情報サイトです。スマートフォン、パソコン、テレビ、カメラ、生活家電、キッチン家電、美容・健康家電、ガジェットなどに関する疑問や悩みがある方にとって役立つ情報を紹介しています。">
    <meta name="p:domain_verify" content="6ae5c3b79f2be421e8e68b1471007762">
	<link rel="canonical" href="https://monostudio.jp/report.php">
	<meta name="robots" content="noindex,follow" />
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="css/validationEngine.jquery.css" type="text/css"/>        
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
      <ul class="m-header-navi">
          <li class="m-header-navi-menu"><a href="#">無料会員登録</a></li>
          <li class="m-header-navi-menu"><a href="#">ログイン</a></li>
      </ul>
  </div>
</header>



<section id="topBar">
  <ul class="topBar_in breadcrumb">
    <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="https://monostudio.jp/" itemprop="url"><span itemprop="title">mono studioトップ</span></a></li>
      <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><strong itemprop="title">お問い合わせ</strong></li>
  </ul>
</section>

<div id="wrapper" class="clearfix static">
  <div id="col1">
    <h1 class="static_title">お問い合わせ</h1>
    <article class="staticArea">
        <p>お問い合わせ内容に関してはすべて目を通した上、対応を行いますが、内容によっては対応できない場合がございます。ご了承ください。</p>
      <p>
        ドメイン指定受信設定や迷惑メール設定をしている場合、カスタマーサポートからのメールが届かない場合がございます。<br>
        「@whitelabel.co.jp」からのメールを受信できるよう設定をお願いいたします。<br>
      </p>

      <form accept-charset="UTF-8" action="" class="new_report" id="hoge" method="post">

      <div id="editArea" class="report_form">
        <div class="field">
          <label>お名前<span>必須</span></label>
          <input class="report_content_field validate[required]" id="report_name" name="report_name" size="30" type="text" />
        </div>

       <div class="field">
          <label>メールアドレス<span>必須</span></label>
         <input class="report_content_field validate[required,custom[email]]" id="report_email" name="report_email" size="30" type="text" />
       </div>

       <label>内容<span>必須</span></label>
       <textarea class="report_content_area validate[required,minSize[10]]" cols="40" id="report_content" name="report_content" rows="20">
</textarea>

       <p>
         内容はできる限り詳細にご入力くださいませ。<br>
         ご記載いただいた「お問い合わせの内容」は記事を作成したユーザーにそのまま通知する場合がございます。あらかじめご了承くださいませ。
       </p>

       <br><br>
       
       <input class="btn btn_default" data-disable-with="送信中..." id="btn_send" name="commit" type="submit" value="送信する" />
</form>     </div>
   </article>
 </div>
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
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="js/jquery.validationEngine-ja.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	$(function(){
	   jQuery("#hoge").validationEngine();
	});
	
</script>
</body></html>