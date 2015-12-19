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
<html style="">
<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">

	<meta charset="UTF-8">
	<title>about | mono studio[モノスタジオ]</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=viewport content="width=device-width, initial-scale=1">
	<meta name="description" content="mono studio[モノスタジオ]は「家電」に関する知恵やノウハウが集まる情報サイトです。スマートフォン、パソコン、テレビ、カメラ、生活家電、キッチン家電、美容・健康家電、ガジェットなどに関する疑問や悩みがある方にとって役立つ情報を紹介しています。">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="description" content="mono studio[モノスタジオ]は「家電」に関する知恵やノウハウが集まる情報サイトです。スマートフォン、パソコン、テレビ、カメラ、生活家電、キッチン家電、美容・健康家電、ガジェットなどに関する疑問や悩みがある方にとって役立つ情報を紹介しています。">
    <meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="@monostudio_jp">
	<meta name="twitter:title" content="about | mono studio[モノスタジオ]">
	<meta name="twitter:description" content="">
	<meta name="twitter:image" content="">
    <meta property="fb:app_id" content="180196992327206">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:title" content="about | mono studio[モノスタジオ]">
    <meta property="og:type" content="website">
    <meta property="og:image" content="o">
    <meta property="og:url" content="https://monostudio.jp/abouts">
    <meta property="og:site_name" content="mono studio">
    <meta property="og:description" content="mono studio[モノスタジオ]は「家電」に関する知恵やノウハウが集まる情報サイトです。スマートフォン、パソコン、テレビ、カメラ、生活家電、キッチン家電、美容・健康家電、ガジェットなどに関する疑問や悩みがある方にとって役立つ情報を紹介しています。">
    <meta name="p:domain_verify" content="6ae5c3b79f2be421e8e68b1471007762">
	<link rel="canonical" href="https://monostudio.jp/500.php">
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
        
	<div class="error-page">
		<h1 class="title_error_page">500<span>error.</span></h1>
		<p class="text_error_page">
		エラーが発生しました。<br>
		ご迷惑をおかけして申し訳ございません。
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


</div><span style="height: 20px; width: 40px; position: absolute; opacity: 1; z-index: 8675309; display: none; cursor: pointer; border: none; background-color: transparent; background-size: 40px 20px;"></span><iframe id="google_osd_static_frame_9835926897358" name="google_osd_static_frame" style="display: none; width: 0px; height: 0px;"></iframe></body></html>
