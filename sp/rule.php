<?php
	
	mb_language('ja');
	mb_internal_encoding('UTF-8');
	mb_regex_encoding('UTF-8');
	header('Content-Type: text/html; charset=UTF-8');
	require_once('../assets/php/config.php');

   function h($s) {
    	return htmlspecialchars($s, ENT_QUOTES, "UTF-8");
	}

	try {
        $dbh = new PDO(DSN, DB_USER, DB_PASSWORD);
        $stmt = $dbh -> query("SET NAMES utf8;");
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
		//top pickup movie
		$top_contents = $dbh->query("select * from contents where id=1 AND public=1");
		$top_contents->execute();
		$top = $top_contents->fetch();
		
		//get popular contents
		$top_popular_contents = $dbh->query("select * from contents where date_format(last_count_date , '%Y-%m-%d') = date_sub(date(date_format( now() , '%Y-%m-%d')),interval 1 day) limit 5");
		$top_popular_contents->execute();
		
		//top latest movies list
		$sql = "select * from contents where public=1 ORDER BY created DESC";
		
		if(empty($_GET['p'])) { 
			$_GET['p'] = 1;
		}
		
		
		
		if(!empty($_GET['p'])) { 
			
			$num = $_GET["p"];
			
			
			$sql .= " LIMIT " . (($num - 1) * 20) . ",20";
	
		}
		
		$top_movies_list = $dbh->prepare($sql);
		$top_movies_list->execute();		
		
		//pagination
		$page = $_GET['p'];
		$contents_count = $dbh->prepare("SELECT count(id) FROM `contents` where public=1");
		$contents_count->execute();
		$contents_counts = $contents_count->fetch();
		$pagemax = ceil($contents_count / 10);
		$minp = max(1, $page - 2);
		$maxp = min($pagemax, $page + 2);
		if ($minp === 1) { $maxp = min($pagemax, 5); }
		if ($maxp === $pagemax) { $minp = max(1, $maxp - 4); }
		
		//maxpage以上のリクエストはpage1へ遷移させる
		if($_GET['p'] > $pagemax){
			
			header('Location: http://monostudio.jp/');
		}
		
		//get tags
	    $get_tags = $dbh->query("select * from tags where count > 10 ORDER BY count limit 15");
		$get_tags->execute();		
		
		//get keywords
		$get_keys = $dbh->query("select * from tags where count > 10 ORDER BY count limit 10");
		$get_keys->execute();
		
		//get popular contents
		$top_popular_contents = $dbh->query("select * from contents where date_format(last_count_date , '%Y-%m-%d') = date_sub(date(date_format( now() , '%Y-%m-%d')),interval 1 day) limit 5");
		$top_popular_contents->execute();
		
	
?>

<!DOCTYPE html>
<html >
<head>

	<meta charset="UTF-8">
	<title>利用規約 | mono studio[モノスタジオ]</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="description" content="mono studio[モノスタジオ]は「家電」に関する知恵やノウハウが集まる情報サイトです。スマートフォン、パソコン、テレビ、カメラ、生活家電、キッチン家電、美容・健康家電、ガジェットなどに関する疑問や悩みがある方にとって役立つ情報を紹介しています。">
    <meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="@monostudio_jp">
	<meta name="twitter:title" content="利用規約 | mono studio[モノスタジオ]">
	<meta name="twitter:description" content="mono studio[モノスタジオ]は「家電」に関する知恵やノウハウが集まる情報サイトです。スマートフォン、パソコン、テレビ、カメラ、生活家電、キッチン家電、美容・健康家電、ガジェットなどに関する疑問や悩みがある方にとって役立つ情報を紹介しています。">
	<meta name="twitter:image" content="">
    <meta property="fb:app_id" content="180196992327206">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:title" content="利用規約 | mono studio[モノスタジオ]">
    <meta property="og:type" content="website">
    <meta property="og:image" content="o">
    <meta property="og:url" content="https://monostudio.jp/rule">
    <meta property="og:site_name" content="mono studio">
    <meta property="og:description" content="mono studio[モノスタジオ]は「家電」に関する知恵やノウハウが集まる情報サイトです。スマートフォン、パソコン、テレビ、カメラ、生活家電、キッチン家電、美容・健康家電、ガジェットなどに関する疑問や悩みがある方にとって役立つ情報を紹介しています。">
    <meta name="p:domain_verify" content="6ae5c3b79f2be421e8e68b1471007762">
	<link rel="canonical" href="https://monostudio.jp/rule.php">
	<meta name="robots" content="noindex,follow" />

    <link rel="stylesheet" href="smart.css">

<style id="style-1-cropbar-clipper">
/* Copyright 2014 Evernote Corporation. All rights reserved. */
.en-markup-crop-options {
    top: 18px !important;
    left: 50% !important;
    margin-left: -100px !important;
    width: 200px !important;
    border: 2px rgba(255,255,255,.38) solid !important;
    border-radius: 4px !important;
}

.en-markup-crop-options div div:first-of-type {
    margin-left: 0px !important;
}
</style>

<style type="text/css">
.fb_hidden{position:absolute;top:-10000px;z-index:10001}.fb_reposition{overflow-x:hidden;position:relative}.fb_invisible{display:none}.fb_reset{background:none;border:0;border-spacing:0;color:#000;cursor:auto;direction:ltr;font-family:"lucida grande", tahoma, verdana, arial, "hiragino kaku gothic pro",meiryo,"ms pgothic",sans-serif;font-size:11px;font-style:normal;font-variant:normal;font-weight:normal;letter-spacing:normal;line-height:1;margin:0;overflow:visible;padding:0;text-align:left;text-decoration:none;text-indent:0;text-shadow:none;text-transform:none;visibility:visible;white-space:normal;word-spacing:normal}.fb_reset>div{overflow:hidden}.fb_link img{border:none}
.fb_dialog{background:rgba(82, 82, 82, .7);position:absolute;top:-10000px;z-index:10001}.fb_reset .fb_dialog_legacy{overflow:visible}.fb_dialog_advanced{padding:10px;-moz-border-radius:8px;-webkit-border-radius:8px;border-radius:8px}.fb_dialog_content{background:#fff;color:#333}.fb_dialog_close_icon{background:url(https://static.xx.fbcdn.net/rsrc.php/v2/yq/r/IE9JII6Z1Ys.png) no-repeat scroll 0 0 transparent;_background-image:url(https://static.xx.fbcdn.net/rsrc.php/v2/yL/r/s816eWC-2sl.gif);cursor:pointer;display:block;height:15px;position:absolute;right:18px;top:17px;width:15px}.fb_dialog_mobile .fb_dialog_close_icon{top:5px;left:5px;right:auto}.fb_dialog_padding{background-color:transparent;position:absolute;width:1px;z-index:-1}.fb_dialog_close_icon:hover{background:url(https://static.xx.fbcdn.net/rsrc.php/v2/yq/r/IE9JII6Z1Ys.png) no-repeat scroll 0 -15px transparent;_background-image:url(https://static.xx.fbcdn.net/rsrc.php/v2/yL/r/s816eWC-2sl.gif)}.fb_dialog_close_icon:active{background:url(https://static.xx.fbcdn.net/rsrc.php/v2/yq/r/IE9JII6Z1Ys.png) no-repeat scroll 0 -30px transparent;_background-image:url(https://static.xx.fbcdn.net/rsrc.php/v2/yL/r/s816eWC-2sl.gif)}.fb_dialog_loader{background-color:#f6f7f8;border:1px solid #606060;font-size:24px;padding:20px}.fb_dialog_top_left,.fb_dialog_top_right,.fb_dialog_bottom_left,.fb_dialog_bottom_right{height:10px;width:10px;overflow:hidden;position:absolute}.fb_dialog_top_left{background:url(https://static.xx.fbcdn.net/rsrc.php/v2/ye/r/8YeTNIlTZjm.png) no-repeat 0 0;left:-10px;top:-10px}.fb_dialog_top_right{background:url(https://static.xx.fbcdn.net/rsrc.php/v2/ye/r/8YeTNIlTZjm.png) no-repeat 0 -10px;right:-10px;top:-10px}.fb_dialog_bottom_left{background:url(https://static.xx.fbcdn.net/rsrc.php/v2/ye/r/8YeTNIlTZjm.png) no-repeat 0 -20px;bottom:-10px;left:-10px}.fb_dialog_bottom_right{background:url(https://static.xx.fbcdn.net/rsrc.php/v2/ye/r/8YeTNIlTZjm.png) no-repeat 0 -30px;right:-10px;bottom:-10px}.fb_dialog_vert_left,.fb_dialog_vert_right,.fb_dialog_horiz_top,.fb_dialog_horiz_bottom{position:absolute;background:#525252;filter:alpha(opacity=70);opacity:.7}.fb_dialog_vert_left,.fb_dialog_vert_right{width:10px;height:100%}.fb_dialog_vert_left{margin-left:-10px}.fb_dialog_vert_right{right:0;margin-right:-10px}.fb_dialog_horiz_top,.fb_dialog_horiz_bottom{width:100%;height:10px}.fb_dialog_horiz_top{margin-top:-10px}.fb_dialog_horiz_bottom{bottom:0;margin-bottom:-10px}.fb_dialog_iframe{line-height:0}.fb_dialog_content .dialog_title{background:#6d84b4;border:1px solid #3a5795;color:#fff;font-size:14px;font-weight:bold;margin:0}.fb_dialog_content .dialog_title>span{background:url(https://static.xx.fbcdn.net/rsrc.php/v2/yd/r/Cou7n-nqK52.gif) no-repeat 5px 50%;float:left;padding:5px 0 7px 26px}body.fb_hidden{-webkit-transform:none;height:100%;margin:0;overflow:visible;position:absolute;top:-10000px;left:0;width:100%}.fb_dialog.fb_dialog_mobile.loading{background:url(https://static.xx.fbcdn.net/rsrc.php/v2/ya/r/3rhSv5V8j3o.gif) white no-repeat 50% 50%;min-height:100%;min-width:100%;overflow:hidden;position:absolute;top:0;z-index:10001}.fb_dialog.fb_dialog_mobile.loading.centered{width:auto;height:auto;min-height:initial;min-width:initial;background:none}.fb_dialog.fb_dialog_mobile.loading.centered #fb_dialog_loader_spinner{width:100%}.fb_dialog.fb_dialog_mobile.loading.centered .fb_dialog_content{background:none}.loading.centered #fb_dialog_loader_close{color:#fff;display:block;padding-top:20px;clear:both;font-size:18px}#fb-root #fb_dialog_ipad_overlay{background:rgba(0, 0, 0, .45);position:absolute;left:0;top:0;width:100%;min-height:100%;z-index:10000}#fb-root #fb_dialog_ipad_overlay.hidden{display:none}.fb_dialog.fb_dialog_mobile.loading iframe{visibility:hidden}.fb_dialog_content .dialog_header{-webkit-box-shadow:white 0 1px 1px -1px inset;background:-webkit-gradient(linear, 0% 0%, 0% 100%, from(#738ABA), to(#2C4987));border-bottom:1px solid;border-color:#1d4088;color:#fff;font:14px Helvetica, sans-serif;font-weight:bold;text-overflow:ellipsis;text-shadow:rgba(0, 30, 84, .296875) 0 -1px 0;vertical-align:middle;white-space:nowrap}.fb_dialog_content .dialog_header table{-webkit-font-smoothing:subpixel-antialiased;height:43px;width:100%}.fb_dialog_content .dialog_header td.header_left{font-size:12px;padding-left:5px;vertical-align:middle;width:60px}.fb_dialog_content .dialog_header td.header_right{font-size:12px;padding-right:5px;vertical-align:middle;width:60px}.fb_dialog_content .touchable_button{background:-webkit-gradient(linear, 0% 0%, 0% 100%, from(#4966A6), color-stop(.5, #355492), to(#2A4887));border:1px solid #2f477a;-webkit-background-clip:padding-box;-webkit-border-radius:3px;-webkit-box-shadow:rgba(0, 0, 0, .117188) 0 1px 1px inset, rgba(255, 255, 255, .167969) 0 1px 0;display:inline-block;margin-top:3px;max-width:85px;line-height:18px;padding:4px 12px;position:relative}.fb_dialog_content .dialog_header .touchable_button input{border:none;background:none;color:#fff;font:12px Helvetica, sans-serif;font-weight:bold;margin:2px -12px;padding:2px 6px 3px 6px;text-shadow:rgba(0, 30, 84, .296875) 0 -1px 0}.fb_dialog_content .dialog_header .header_center{color:#fff;font-size:16px;font-weight:bold;line-height:18px;text-align:center;vertical-align:middle}.fb_dialog_content .dialog_content{background:url(https://static.xx.fbcdn.net/rsrc.php/v2/y9/r/jKEcVPZFk-2.gif) no-repeat 50% 50%;border:1px solid #555;border-bottom:0;border-top:0;height:150px}.fb_dialog_content .dialog_footer{background:#f6f7f8;border:1px solid #555;border-top-color:#ccc;height:40px}#fb_dialog_loader_close{float:left}.fb_dialog.fb_dialog_mobile .fb_dialog_close_button{text-shadow:rgba(0, 30, 84, .296875) 0 -1px 0}.fb_dialog.fb_dialog_mobile .fb_dialog_close_icon{visibility:hidden}#fb_dialog_loader_spinner{animation:rotateSpinner 1.2s linear infinite;background-color:transparent;background-image:url(https://static.xx.fbcdn.net/rsrc.php/v2/yD/r/t-wz8gw1xG1.png);background-repeat:no-repeat;background-position:50% 50%;height:24px;width:24px}@keyframes rotateSpinner{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}
.fb_iframe_widget{display:inline-block;position:relative}.fb_iframe_widget span{display:inline-block;position:relative;text-align:justify}.fb_iframe_widget iframe{position:absolute}.fb_iframe_widget_fluid_desktop,.fb_iframe_widget_fluid_desktop span,.fb_iframe_widget_fluid_desktop iframe{max-width:100%}.fb_iframe_widget_fluid_desktop iframe{min-width:220px;position:relative}.fb_iframe_widget_lift{z-index:1}.fb_hide_iframes iframe{position:relative;left:-10000px}.fb_iframe_widget_loader{position:relative;display:inline-block}.fb_iframe_widget_fluid{display:inline}.fb_iframe_widget_fluid span{width:100%}.fb_iframe_widget_loader iframe{min-height:32px;z-index:2;zoom:1}.fb_iframe_widget_loader .FB_Loader{background:url(https://static.xx.fbcdn.net/rsrc.php/v2/y9/r/jKEcVPZFk-2.gif) no-repeat;height:32px;width:32px;margin-left:-16px;position:absolute;left:50%;z-index:4}
</style>

<script src="//code.jquery.com/jquery-latest.js"></script>
<script src="js/main.js"></script></head>

<body class="lists-index" data-pinterest-extension-installed="cr1.39.1"><!-- Google Tag Manager -->
<noscript><iframe src="//www.googletagmanager.com/ns.html?id=GTM-5FS24Q"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'//www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5FS24Q');</script>
<!-- End Google Tag Manager -->

<div id="normal_view">
 
<header id="header">
	<div class="content">
		<h1 class="m-header-logo"><a href="https://monostudio.jp"><img src="images/logo.jpg" alt="monostudio" style="height: 25px;"></a></h1>
		
		<a class="header-button menu-button btn_slide">
			<span class="icon icon-menu"></span>
		</a>
		<a href="javascript:void(0)" id="header_search_btn" class="header-button search-button">
			<span class="icon icon-search"></span>
		</a>
	</div>
</header>
      
<div id="page_wrapp">
        
<section class="content-area">
  <h1 class="page-title">MonoStudio利用規約</h1>
  
  <div class="static-content">
<h2>第１条　monostudio会員資格</h2>

<p>１．monostudio会員とは、本規約を承認の上、インターネットを使って、株式会社White Label（以下、「当社」といいます。）が提供、運営するウェブサイト及びスマートフォン用アプリケーション「monostudio」（以下、「本サービス」といいます。）の利用のために、monostudio会員として入会を申し込み、当社が入会を認めた者のことをいいます。</p>

<p>２．monostudio会員は、本規約に基づき本サービスを利用するものとします。</p>

<p>３．本サービス内の各サービスにおいて別途規約（以下、「個別規約」といいます。）が定められている場合は、monostudio会員は本規約及び個別規約に基づき本サービスを利用するものとします。なお、本規約と個別規約に定める内容が異なる場合には個別規約に定める内容が優先して適用されるものとします。</p>

<p>４．monostudio会員はmonostudio会員資格を第三者に利用させ、または貸与、譲渡、売買、質入等をすることはできないものとします。</p>


<h2>第２条　monostudio会員規約の変更</h2>

<p>当社は、本規約及び個別規約を変更することができるものとします。本規約及び個別規約を変更した場合、本サービスに関する一切の事項は変更後の規約によるものとします。</p>


<h2>第３条　入会</h2>

<p>１．monostudio会員になろうとする方は、本規約を承認の上、当社の定める手続きにより当社に入会を申し込むものとします。</p>

<p>２．monostudio会員になろうとする方が未成年である場合は、入会申込をすることについて、法定代理人の同意を得るものとします。</p>


<h2>第４条　通信端末及びID、パスワード</h2>

<p>１．monostudio会員は、当社が付与する認証用データを記録した携帯電話端末等の通信端末（以下、「通信端末」といい、当該通信端末が通信を行うためにSIMカード等のICカード等が必要な場合、当該ICカード等も含みます。）並びにID、パスワードの管理責任を負うものとします。</p>

<p>２．monostudio会員は、会員資格を有する間、ID及びパスワードを第三者に利用させ、または、貸与、譲渡、売買、質入等をすることはできないものとします。また、monostudio会員は、通信端末を他者に貸与、譲渡、売買、質入等する場合、monostudio会員資格が他者に利用等されないよう適切な措置を施すものとします。</p>

<p>３．通信端末、ID及びパスワードの管理不十分、使用上の過誤、第三者の使用等による損害の責任はmonostudio会員が負うものとし、当社は一切責任を負いません。</p>

<p>４．monostudio会員は、ID及びパスワードを第三者に知られた場合、通信端末を第三者に使用されるおそれのある場合には、直ちに当社にその旨連絡するとともに、当社の指示がある場合にはこれに従うものとします。</p>


<h2>第５条　monostudio会員記述情報について</h2>

<p>１．monostudio会員記述情報とは、本サービス内にてmonostudio会員が自ら送信、投稿、登録、表示（以下、これらの行為を単に「記述」といいます。）したすべての情報をいいます。monostudio会員記述情報に対しては、これを記述したmonostudio会員が全責任を負うものとします。monostudio会員は以下の情報を記述することはできません。</p>

<p>a.  他人の名誉または信用を傷つけるもの<br>
b.  わいせつな表現またはヌード画像を含むもの<br>
c.  詐欺的、虚偽的、欺瞞的である、もしくは誤解を招くもの<br>
d.  個人または団体に対して差別、偏見、人種差別、憎悪、嫌がらせまたは侵害を助長するもの<br>
e.  暴力的もしくは脅迫的である、または他者に対して暴力的もしくは脅迫的な行為を助長するもの<br>
f.  特許権、実用新案権、意匠権、商標権、著作権、肖像権その他の他人の権利を侵害するもの<br>
g.  コンピューターウィルスを含むもの<br>
h.  異性交際を求めるもの<br>
i.  異性交際の求めに応じるもの<br>
j.  異性交際に関する情報を媒介するもの<br>
k.  公序良俗に反するもの<br>
l.  法令に違反するものまたは違反する行為を助長するもの<br>
m.  当社が定める基準に反するもの<br>
n.  その他当社が不適当と判断したもの</p>

<p>２．当社は、monostudio会員記述情報が本規約に違反する場合、その他の当社が不適当と判断した場合には、monostudio会員記述情報を削除することができるものとします。</p>

<p>３．当社は、monostudio会員記述情報を無償で、複製、翻案、改変、公衆送信（送信可能化を含みます。）その他の方法により利用すること及び他の利用者や当社が指定する第三者に対し利用許諾することができるものとします。なお、monostudio会員記述情報の著作権は当社に譲渡されるものではありません。</p>


<h2>第６条　個人情報について</h2>

<p>１．monostudio会員になろうとする方は、当社所定の情報を当社に登録する必要があります。</p>

<p>２．当社は、monostudio会員の個人情報を以下の目的で利用することができるものとします。</p>

<p>a.  ゲーム、オークション、ショッピングモール、コンテンツその他の情報提供サービス、システム利用サービスの提供のため<br>
b.  当社及び第三者の商品等（旅行、保険その他の金融商品を含む。以下同じ。）の販売、販売の勧誘、発送、サービス提供のため<br>
c.  当社及び第三者の商品等の広告または宣伝（ダイレクトメールの送付、電子メールの送信を含む。）のため<br>
d.  料金請求、課金計算のため<br>
e.  本人確認、認証サービスのため<br>
f.  アフターサービス、問い合わせ、苦情対応のため<br>
g.  アンケートの実施のため<br>
h.  懸賞、キャンペーンの実施のため<br>
i.  アフィリエイト、ポイントサービスの提供のため<br>
j.  マーケティングデータの調査、統計、分析のため<br>
k.  決済サービス、物流サービスの提供のため<br>
l.  新サービス、新機能の開発のため<br>
m.  システムの維持、不具合対応のため<br>
n.  monostudio会員記述情報の掲載のため</p>

<p>３．当社は、以下に定める場合には、monostudio会員の個人情報を第三者に提供することができるものとします。</p>

<p>a.  monostudio会員の同意がある場合<br>
b.  裁判所、検察庁、警察、税務署、弁護士会またはこれらに準じた権限を有する機関から開示を求められた場合<br>
c.  monostudio会員が当社に対し支払うべき料金その他の金員の決済を行うために、金融機関、クレジットカード会社、回収代行業者その他の決済またはその代行を行う事業者に開示する場合<br>
d.  当社が行う業務の全部または一部を第三者に委託する場合<br>
e.  当社に対して秘密保持義務を負う者に対して開示する場合<br>
f.  当社の権利行使に必要な場合<br>
g.  合併、営業譲渡その他の事由による事業の承継の際に、事業を承継する者に対して開示する場合<br>
h.  個人情報保護法その他の法令により認められた場合</p>

<p>４．当社は、monostudio会員に対し、第三者の広告又は宣伝等のために電子メールその他の広告宣伝物を送信できるものとし、monostudio会員はこれを予め承諾するものとします。 </p>


<h2>第７条　monostudio会員規約の違反等について</h2>

<p>１．monostudio会員が以下の各号に該当した場合、当社は、当社の定める期間、本サービスの一部もしくは全部の利用を認めないこと、又は、monostudio会員の会員資格を取り消すことができるものとします。</p>

<p>a.  会員登録申込みの際の個人情報登録、及びmonostudio会員となった後の個人情報変更において、その内容に虚偽や不正があった場合、または重複した会員登録があった場合<br>
b.  本サービスを利用せずに1年以上が経過した場合<br>
c.  他の利用者に不当に迷惑をかけたと当社が判断した場合<br>
d.  反社会的勢力と不適切な関係にあると当社が判断した場合<br>
e.  本規約及び個別規約に違反した場合<br>
f.  その他、monostudio会員として不適切であると当社が判断した場合</p>

<p>２．当社が会員資格を取り消したmonostudio会員は再入会することはできません。</p>

<p>３．当社の措置によりmonostudio会員に損害が生じても、当社は、一切損害を賠償しません。</p>


<h2>第８条　サービスの提供条件</h2>

<p>１．  当社は、メンテナンス等のために、monostudio会員に通知することなく、本サービスを停止し、または変更することがあります。</p>

<p>２．  本サービスを利用するために必要な機器、通信手段などは、monostudio会員の費用と責任で備えるものとします。</p>

<p>３．当社は、本サービスに中断、中止その他の障害が生じないことを保証しません。</p>

<p>４．当社は、当社が提供するサービス、ウェブサイト、アプリケーション等を現状有姿で提供するものであり、当該サービス、ウェブサイト、アプリケーション等が正常に動作すること及び当該サービス、ウェブサイト、アプリケーション等に瑕疵のないことを保証しません。</p>


<h2>第９条　禁止事項</h2>

<p>monostudio会員は、以下の行為を行ってはならないものとします。</p>
<p>a.  当社が提供するサービス・ウェブサイト・アプリケーション等、当社が保有するサーバー及びこれらが生成する情報、通信内容等の解読、解析、逆コンパイル、逆アセンブルまたはリバースエンジニアリング<br>
b.  他の利用者の個人情報、またはmonostudio会員記述情報を違法、不適切に収集、開示その他利用すること<br>
c.  他の個人または団体になりすまし、または他の個人または団体と関係があるように不当に見せかけること<br>
d.  他のmonostudio会員のID、パスワードを入手しようとすること<br>
e.  迷惑メール、チェーンメール、ウィルス等の不適切なデータを送信すること<br>
f.  ボットなどの自動化された手段を用いて本サービスを利用すること<br>
g.  本サービスを変更または妨げることを目的に利用すること<br>
h.  本サービスのバグ、誤動作を利用すること<br>
i.  詐欺的行為をすること<br>
j.  その他当社が不適当と判断するもの</p>


<h2>第１０条　コンテンツ使用許諾の条件</h2>

<p>１．monostudio会員は、本サービスのコンテンツ（アプリケーション、ウェブページ、デジタルコンテンツその他本サービスにおいて提供される情報等）を、電気通信回線を通じて当社の指定する設備に接続し、通信端末に表示またはダウンロード等することによって当社の定める範囲内でのみ使用することができるものとします。</p>

<p>２．本サービス内で当社が提供する全てのコンテンツに関する権利は当社または当社にコンテンツの配信を許諾した権利者に帰属するものとし、monostudio会員に対し、当社が有する特許権、実用新案権、意匠権、商標権、著作権、ノウハウその他の知的財産権の実施または使用許諾をするものではありません。</p>

<p>３．monostudio会員は、当社が認めた場合を除き、本サービスにおいて配信されるコンテンツを複製（私的使用のための複製を除く）、翻案、公衆送信、その他の方法により利用してはならないものとします。</p>

<p>４．monostudio会員は、本サービスのコンテンツにつき再使用許諾をすることはできないものとします。</p>

<p>５．本サービスのコンテンツの使用許諾は、非独占的なものとします。</p>

<p>６．当社は、各コンテンツの使用権の有効期間を変更することができるものとします。</p>

<p>７．退会等によりmonostudio会員が会員資格を喪失した場合は、コンテンツの使用権も消滅するものとします。</p>


<h2>第１１条　当社の責任</h2>

<p>１．当社は、本サービスの内容、ならびにmonostudio会員が本サービスを通じて入手したコンテンツ及び情報等について、その完全性、正確性、確実性、有用性等につき、いかなる責任も負わないものとします。</p>

<p>２．monostudio会員は自らの責任に基づいて本サービスを利用するものとし、当社は本サービス及び外部サービスにおけるmonostudio会員の一切の事項について何らの責任を負いません。</p>

<p>３．monostudio会員は法律の範囲内で本サービスをご利用ください。本サービスの利用に関連してmonostudio会員が日本及び外国の法律に触れた場合でも、当社は一切責任を負いません。</p>

<p>４．本規約において当社の責任について規定していない場合で、当社の責めに帰すべき事由によりmonostudio会員に損害が生じた場合、当社は、１万円を上限として賠償するものとします。</p>

<p>５．当社は、当社の故意または重大な過失によりmonostudio会員に損害を与えた場合には、その損害を賠償します。</p>

<p>６．当社は、本サービスに関して、利用者同士、または利用者とその他の第三者との間で発生した一切のトラブルについて、関知しません。したがって、これらのトラブルについては、当事者間で話し合い、訴訟などにより解決するものとします。</p>


<h2>第１２条　登録事項の変更</h2>

<p>１．monostudio会員は、メールアドレス等の登録事項に変更のあった場合、すみやかに当社の定める手続きにより当社に届け出るものとします。この届出のない場合、当社は、登録事項の変更のないものとして取り扱うことができるものとします。</p>

<p>２．monostudio会員は、登録事項を変更したことを当社に届け出なかった場合、本サービスを利用できなくなることがあります。</p>


<h2>第１３条　当社からの通知</h2>

<p>当社からの通知は、当社に登録されたメールアドレスにメールを送信することまたは当社が提供するアプリケーションの機能を用いた通知方法をもって行い、メールまたはアプリケーションによる通知が通常到達すべきときに到達したものとします。</p>


<h2>第１４条　サービス廃止</h2>

<p>当社は当社の都合によりいつでも本サービスを廃止できるものとします。</p>


<h2>第１５条　退会</h2>

<p>monostudio会員は、当社の定める手続きにより退会することができます。</p>


<h2>第１６条　準拠法</h2>

<p>本サービスその他の本規約に関する準拠法は日本法とします。</p>


<h2>第１７条　管轄裁判所</h2>

<p>本サービスに関し、monostudio会員と当社との間で訴訟が生じた場合、東京地方裁判所を第１審の専属的管轄裁判所とします。</p>

      <br>

      

      <p class="endRules">以 上</p>
      
      <p class="ruleChanges">
        2015年11月18日 制定<br>
      </p>
      </p>
  </div>
</section>
<section class="content-area category-list">
  <h2 class="title_section">カテゴリから探す</h2>
  <ul>
    <li class="home">
      <a href="https://monostudio.jp">
        <span class="icon icon-top"></span> トップ
      </a>
    </li>
    <li class="category-name">
      <a href="pc_tablet">
        <span class="icon icon-pc"></span> パソコン
      </a>
    </li>
    <li class="category-name">
      <a href="smartphone_mobile">
        <span class="icon icon-smartphone"></span> スマートフォン・タブレット
      </a>
    </li>
    <li class="category-name">
      <a href="image_audio">
        <span class="icon icon-audio"></span> 映像・オーディオ
      </a>
    </li>
    <li class="category-name">
      <a href="camera">
        <span class="icon icon-camera"></span> カメラ
      </a>
    </li>
    <li class="category-name">
      <a href="kitchen">
        <span class="icon icon-kitchen"></span> キッチン
      </a>
    </li>
    <li class="category-name">
      <a href="home_app">
        <span class="icon icon-ce"></span> 生活家電
      </a>
    </li>
    <li class="category-name">
      <a href="beauty_health">
        <span class="icon icon-ce"></span> 美容家電
      </a>
    </li>
     </ul>
</section>

          
</div>

        
        <footer class="m-footer ">
    <p class="m-footer-buttonTop">
      <a href="#page_wrapp">
        <span class="icon icon-page-top"></span>ページトップへ
      </a>
    </p>

    <p class="m-footer-sns">
      <a href="" target="_blank">
        <span class="icon icon-footer-facebook"></span>
      </a>
      <a href="" target="_blank">
        <span class="icon icon-footer-twitter"></span>
      </a>
    </p>

    <ul class="m-footer-links">
		<li><a href="https://monostudio.jp/">トップページ</a></li>
		<li><a href="sitemap.php">サイトマップ</a></li>
		<li><a href="report.php">お問い合わせ</a></li>
		<li><a href="rule.php">利用規約</a></li>
		<li><a href="policy.php">プライバシーポリシー</a></li>
    </ul>

  <ul class="m-footer-links">
    <li><a href="http://white-label.wix.com/whitelabel" target="_blank">運営者情報</a></li>
  </ul>


</footer>
        
      </div><div id="overlay" style="overflow: hidden; width: 100%; height: 100%; z-index: 999; position: fixed; left: 0px; top: 0px; display: none;"></div>

      
      
      

      

      
      <nav id="side_menu" class="m-drawerMenu" style="position: fixed; top: 0px; left: 0px; overflow: scroll; height: 100%; min-height: 100%; z-index: -1; display: none;">
    
    <div class="account">
    </div>
  
  <section class="m-drawerMenu-content">
    <ul>
    <li class="home">
      <a href="https://monostudio.jp">
        <span class="icon icon-top"></span> トップ
      </a>
    </li>
    <li class="category-name">
      <a href="pc_tablet">
        <span class="icon icon-pc"></span> パソコン
      </a>
    </li>
    <li class="category-name">
      <a href="smartphone_mobile">
        <span class="icon icon-smartphone"></span> スマートフォン・タブレット
      </a>
    </li>
    <li class="category-name">
      <a href="image_audio">
        <span class="icon icon-audio"></span> 映像・オーディオ
      </a>
    </li>
    <li class="category-name">
      <a href="camera">
        <span class="icon icon-camera"></span> カメラ
      </a>
    </li>
    <li class="category-name">
      <a href="kitchen">
        <span class="icon icon-kitchen"></span> キッチン
      </a>
    </li>
    <li class="category-name">
      <a href="home_app">
        <span class="icon icon-ce"></span> 生活家電
      </a>
    </li>
    <li class="category-name">
      <a href="beauty_health">
        <span class="icon icon-ce"></span> 美容家電
      </a>
    </li>
    </ul>
  </section>
  

  
</nav>
      

    </div>
    

    
    <div id="search_view" style="display:none;height:100%;width:100%">
      <header id="header">
        <div class="content">
          <h1><p>検索</p></h1>

          <a id="close_search" class="btn_hd_back header-button">
            <span class="icon icon-back"></span>
          </a>
        </div>
      </header>

      <form accept-charset="UTF-8" action="search.php" id="searchForm" method="get">
        <span class="icon icon-input-search"></span>

        <input class="searchForm" id="sp_search" name="query" placeholder="検索ワードを入力" type="text">
      </form>

      <section class="content-area keyword_list">
        <h2 class="title_section">話題のキーワード</h2>
          <section class="search-tags">
              <ul>
        <?php while($get_key = $get_keys->fetch(PDO::FETCH_ASSOC)){ ?>
                  <li class="tags">
                    <a href="tags-<?php echo $get_key['id']; ?>"><span class="icon icon-tag"></span><?php echo $get_key['tag_title']; ?></a>
                  </li>
        <?php } ?>
              </ul>
          </section>
      </section>
    </div>


</div><span style="height: 20px; width: 40px; position: absolute; opacity: 1; z-index: 8675309; display: none; cursor: pointer; border: none; background-image: background-color: transparent; background-size: 40px 20px;"></span></body></html>
