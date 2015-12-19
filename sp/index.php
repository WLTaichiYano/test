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
			$_GET['p'] = "1";
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
		$contents_counts = $contents_count->fetchColumn();
		$pagemax = ceil($contents_counts / 20);
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
<head prefix="">

	<meta charset="UTF-8">
	<title>mono studio[モノスタジオ] | 家電のまとめ情報<?php if($_GET["p"] !== 1){ echo "(". $_GET["p"]. "} ページ目)"; } ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=viewport content="width=device-width, initial-scale=1">
	<meta name="description" content="mono studio[モノスタジオ]は「家電」に関する知恵やノウハウが集まる情報サイトです。スマートフォン、パソコン、テレビ、カメラ、生活家電、キッチン家電、美容・健康家電、ガジェットなどに関する疑問や悩みがある方にとって役立つ情報を紹介しています。">
    <meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="@monostudio_jp">
	<meta name="twitter:title" content="mono studio[モノスタジオ] | 家電のノウハウ">
	<meta name="twitter:description" content="mono studio[モノスタジオ]は「家電」に関する知恵やノウハウが集まる情報サイトです。スマートフォン、パソコン、テレビ、カメラ、生活家電、キッチン家電、美容・健康家電、ガジェットなどに関する疑問や悩みがある方にとって役立つ情報を紹介しています。">
	<meta name="twitter:image" content="">
    <meta property="fb:app_id" content="180196992327206">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:title" content="mono studio[モノスタジオ] | 家電のノウハウ">
    <meta property="og:type" content="website">
    <meta property="og:image" content="o">
    <meta property="og:url" content="https://monostudio.jp/">
    <meta property="og:site_name" content="mono studio">
    <meta property="og:description" content="mono studio[モノスタジオ]は「家電」に関する知恵やノウハウが集まる情報サイトです。スマートフォン、パソコン、テレビ、カメラ、生活家電、キッチン家電、美容・健康家電、ガジェットなどに関する疑問や悩みがある方にとって役立つ情報を紹介しています。">
    <meta name="p:domain_verify" content="6ae5c3b79f2be421e8e68b1471007762">
	<link rel="canonical" href="https://monostudio.jp/">
	<?php if($_GET["p"] !== "1"){ ?>
	<link rel='prev' href='https://monostudio.jp/?p=<?= $_GET["p"]-1; ?>' />
	<?php } ?>
	<?php if($_GET["p"] !== $maxp){ ?>
	<link rel='next' href='https://monostudio.jp/?p=<?= $_GET["p"]+1; ?>' />
	<?php } ?>

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

</head>

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
        
<div id="wrapper">
	<?php if($_GET["p"] == 1) { ?>
<section class="big-list" style="max-height: 300px; height: 211px;">
	<a href="<?= $top["id"]; ?>">
	<img alt="hoge" class="crop_image" src="<?= $top["top_img"]; ?>">
	<div class="filter"></div>
	<h3 class="title"><?= $top["title"]; ?></h3>
	</a>
</section>
<?php } ?>
  
<script>!function(e,t){var i=t.getElementsByClassName("big-list")[0];if(i){i.style.maxHeight="300px";var n=function(){i.style.height=Math.round(.5625*e.innerWidth)+"px"};n(),e.addEventListener("resize",n,!1)}}(window,document);</script>

<section class="content-area article_list">
	<ul>
		<?php while($contents_get = $top_movies_list->fetch(PDO::FETCH_ASSOC)){ ?>
		<?php
			//writerの取得
			//get contents
			$stmt = $dbh->prepare("select * from writers where id=:id");
		    $stmt->execute(array(":id"=>$contents_get["writer_id"]));
		    $get_writer = $stmt->fetch();
				
			
		?>
		<li>
			<a href="<?= h($contents_get["id"]); ?>">
				<div class="list_thumb" data-list-id="179113">
					<span class="crop_image" style="display: block; width: 70px; height: 70px; vertical-align: middle; background-image: url(<?php echo h($contents_get["top_img"]); ?>); background-color: rgb(245, 245, 245); background-size: cover; background-position: 50% 50%; background-repeat: no-repeat;"></span>
				</div>
				<div class="list_content">
					<h3><?= h($contents_get["title"]); ?></h3>
					<div class="list_info">
						<!--<p class="view"><span>25372</span>views</p>-->
						<p class="author"><?= h($get_writer["name"]); ?></p>
					</div>
				</div>
			</a>
		</li>
		<?php } ?>
	</ul>
	 
	<div id="paginate">
		<nav class="pagination">
			<?php if($page != 1) { ?>
			<span class="prev">
				<a href="/?p=<?php
							$page_prev = $page - 1;
							echo $page_prev;
							?>" rel="next"><img alt="前のページ" height="20" src="https://assets.mery.jp/1447830072859/images/smart_phone/paginate-prev.png" width="10"></a>
			</span>
			<?php } ?>
			<?php if($pagemax == 0){ echo 0;}else{ echo $page; } ?>/<?= $pagemax; ?>
			<?php if($page != $maxp) { ?>
			<span class="next">
				<a href="/?p=<?php
							$page_next = $page + 1;
							echo $page_next;
							?>" rel="next"><img alt="次のページ" height="20" src="https://assets.mery.jp/1447830072859/images/smart_phone/paginate-next.png" width="10"></a>
			</span>
			<?php } ?>
		</nav>
	</div>
</section>

</div>


<section class="content-area article_list ranking_list">
	<h2 class="title_section">人気記事ランキング</h2>
	<ul>
		<?php $i=1; ?>
	    <?php while($top_popular_contents_get = $top_popular_contents->fetch(PDO::FETCH_ASSOC)){  ?>
		<?php
			//writerの取得
			$stmt2 = $dbh->prepare("select * from writers where id=:id");
		    $stmt2->execute(array(":id"=>$contents_get["writer_id"]));
		    $get_writer2 = $stmt2->fetch();
				
			
		?>
		<li>
			<a href="<?= $top_popular_contents_get["id"]; ?>">
				<div class="list_thumb">
					<img alt="hoge" class="crop_image" height="70" src="<?= $top_popular_contents_get["top_img"]; ?>" width="70">
				</div>
				<div class="list_content">
					<h3><?= $top_popular_contents_get["title"]; ?></h3>
					<div class="list_info"><p class="author"><?= $get_writer2["name"]; ?></p></div>
				</div>
				<span class="rank-icon"><?= $i; ?></span>
			</a>
		</li>
		<?php $i++; ?>
		<?php } ?>
	</ul>
	
</section>


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
      <a href="">
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
                    <a href="#"><span class="icon icon-tag"></span><?php echo $get_key['tag_title']; ?></a>
                  </li>
        <?php } ?>
              </ul>
          </section>
      </section>
    </div>
    
<div id="fb-root" class=" fb_reset"><div style="position: absolute; top: -10000px; height: 0px; width: 0px;"><div></div></div><div style="position: absolute; top: -10000px; height: 0px; width: 0px;"><div></div></div></div>

</div><span style="height: 20px; width: 40px; position: absolute; opacity: 1; z-index: 8675309; display: none; cursor: pointer; border: none; background-color: transparent; background-size: 40px 20px;"></span><script src="//code.jquery.com/jquery-latest.js"></script>
<script src="js/main.js"></script></body></html>
