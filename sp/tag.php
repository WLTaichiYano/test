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
    
    if(empty($_GET["id"])){
	    
	    header('Location: index.php');
	    
    }
    
    //タグの取得
    $id = $_GET["id"];
    $sql2 = "select * from tags where id=:id";
	$get_tag = $dbh->prepare($sql2);
	$get_tag->execute(array(":id"=>$id));
	$tag = $get_tag->fetch();
	
	if($tag == NULL){
		
		header('Location: https://monostudio.jp');
		
	}
	//リレーションから取得
	$sql2 = "select contents_id from relations where tag_id=:id";
	$get_c = $dbh->prepare($sql2);
	$get_c->execute(array(":id"=>$tag["id"]));
	$get_contents_id = $get_c->fetch();
	
		//get contents list
	$sql = "select * from contents where id=:id and public=1 ORDER BY created DESC";
	
	if(empty($_GET['p'])) { 
		$_GET['p'] = "1";
	}
	
	
	
	if(!empty($_GET['p'])) { 
		
		$num = $_GET["p"];
		
		
		$sql .= " LIMIT " . (($num - 1) * 20) . ",20";

	}
	
	$select_category = $dbh->prepare($sql);
	$select_category->execute(array(":id"=>$get_contents_id["contents_id"]));
	
	
	//コンテンツからtopimgの取得
	$sql3 = "select top_img from contents where id=:id and public=1 limit 1";
	$get_c_img = $dbh->prepare($sql3);
	$get_c_img->execute(array(":id"=>$get_contents_id["contents_id"]));
	$get_contents_img = $get_c_img->fetch();
	
			//pagination
		$page = $_GET['p'];
		$contents_count = $dbh->prepare("SELECT count(id) FROM `contents` where id=:id and public=1 ");
		$contents_count->execute(array(":id"=>$get_contents_id["contents_id"]));
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



		//get popular contents
		$top_popular_contents = $dbh->query("select * from contents where date_format(last_count_date , '%Y-%m-%d') = date_sub(date(date_format( now() , '%Y-%m-%d')),interval 1 day) limit 5");
		$top_popular_contents->execute();
		
		
		//get tags
		$get_tags = $dbh->query("select * from tags where count > 10 ORDER BY count limit 10");
		$get_tags->execute();
		
		//get keywords
		$get_keys = $dbh->query("select * from tags where count > 10 ORDER BY count limit 10");
		$get_keys->execute();
	
?>
<!DOCTYPE html>
<html style="">
	<head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">   
    <meta charset="UTF-8">
    <title><?php echo $tag["tag_title"]; ?>の情報まとめ | mono studio[モノスタジオ]<?php if($_GET["p"] !== 1){ echo "(". $_GET["p"]. "} ページ目)"; } ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=viewport content="width=device-width, initial-scale=1">
	<meta name="description" content="mono studioには「<?php echo $tag["tag_title"]; ?>」に関するまとめが<?php echo $contents_counts; ?>件掲載されています。「<?php echo $tag["tag_title"]; ?>」に関する疑問や悩みを解決する情報はmono studioでお楽しみいただけます。">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="description" content="mono studioには「<?php echo $tag["tag_title"]; ?>」に関するまとめが<?php echo $contents_counts; ?>件掲載されています。「<?php echo $tag["tag_title"]; ?>」に関する疑問や悩みを解決する情報はmono studioでお楽しみいただけます。">
    <meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="@monostudio_jp">
	<meta name="twitter:title" content="<?php echo $tag["tag_title"]; ?>の情報まとめ | mono studio[モノスタジオ]">
	<meta name="twitter:description" content="">
	<meta name="twitter:image" content="">
    <meta property="fb:app_id" content="180196992327206">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:title" content="<?php echo $tag["tag_title"]; ?>の情報まとめ | mono studio[モノスタジオ]">
    <meta property="og:type" content="website">
    <meta property="og:image" content="o">
    <meta property="og:url" content="https://monostudio.jp/tags-<?php echo $tag["id"]; ?>">
    <meta property="og:site_name" content="mono studio">
    <meta property="og:description" content="mono studioには「<?php echo $tag["tag_title"]; ?>」に関するまとめが<?php echo $contents_counts; ?>件掲載されています。「<?php echo $tag["tag_title"]; ?>」に関する疑問や悩みを解決する情報はmono studioでお楽しみいただけます。">
    <meta name="p:domain_verify" content="6ae5c3b79f2be421e8e68b1471007762">
	<link rel="canonical" href="https://monostudio.jp/tags-<?php echo $tag["id"]; ?>">
	<?php if($_GET["p"] !== "1"){ ?>
	<meta name="robots" content="noindex,follow" />
	<link rel='prev' href='https://monostudio.jp/tags-<?php echo $tag["id"]; ?>?p=<?= $_GET["p"]-1; ?>' />
	<?php } ?>
	<?php if($_GET["p"] !== $maxp){ ?>
	<link rel='next' href='https://monostudio.jp/tags-<?php echo $tag["id"]; ?>?p=<?= $_GET["p"]+1; ?>' />
	<?php } ?>
    
    <link rel="stylesheet" href="smart.css">

    
    
    

   <style id="style-1-cropbar-clipper">/* Copyright 2014 Evernote Corporation. All rights reserved. */
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
</style><script src="//code.jquery.com/jquery-latest.js"></script>
<script src="js/main.js"></script></head>

  <body class="big_categories-show" data-pinterest-extension-installed="cr1.39.1">
    
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

<section class="list-cover" style="max-height: 300px; height: 211px;">
	<img alt="<?php echo $tag["tag_title"]; ?>" class="crop_image" src="<?php echo $get_contents_img["top_img"]; ?>">
	<div class="filter"></div>
	<div class="title">
		<div class="content"><h1><?php if($_GET["p"]!==1){ ?><a href="https://monostudio.jp/tags-<?php echo $tag["id"]; ?>" style="color: white;"><?php } ?><?php echo $tag["tag_title"]; ?>に関する記事<?php if($_GET["p"]!==1){ ?></a><?php } ?></h1></div>
	</div>
</section>
  

<script>!function(e,t){var n=t.getElementsByClassName("list-cover")[0];if(n){n.style.maxHeight="300px";var i=function(){n.style.height=Math.round(.5625*e.innerWidth)+"px"};i(),e.addEventListener("resize",i,!1)}}(window,document);</script>
<section class="content-area article_list">
	<h2 class="title_section"><?php echo $tag["tag_title"]; ?>に関する記事<span><?php echo $contents_counts[0]; ?>件</span></h2>
	<ul>
	    <?php while($get_list = $select_category->fetch(PDO::FETCH_ASSOC)){ ?>
		<li>
			<a href="<?php echo $get_list["id"]; ?>">
				<div class="list_thumb">
					<span class="crop_image" style="display: block; width: 70px; height: 70px; vertical-align: middle; background-image: url(<?php echo $get_list["top_img"]; ?>); background-color: rgb(245, 245, 245); background-size: cover; background-position: 50% 50%; background-repeat: no-repeat;"></span>
				</div>
				<div class="list_content">
					<h3><?php echo $get_list["title"]; ?></h3>
					<?php
						//writerの取得
						$stmt2 = $dbh->prepare("select * from writers where id=:id");
					    $stmt2->execute(array(":id"=>$get_list["writer_id"]));
					    $get_writer = $stmt2->fetch();
							
						
					?>
					<div class="list_info">
						<!--<p class="view"><span>25372</span>views</p>-->
						<p class="author"><?php echo $get_writer["name"]; ?></p>
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


<section class="content-area article_list ranking_list">
	<h2 class="title_section">人気記事ランキング</h2>
	<ul>
		<?php $i=1; ?>
	    <?php while($top_popular_contents_get = $top_popular_contents->fetch(PDO::FETCH_ASSOC)){  ?>
		<li>
			<a href="<?php echo $top_popular_contents_get["id"]; ?>">
				<div class="list_thumb">
					<img alt="" class="crop_image" height="70" width="70" src="../<?php echo $top_popular_contents_get["top_img"]; ?>">
				</div>
				<div class="list_content">
					<h3><?php echo $top_popular_contents_get["title"]; ?></h3>
					<?php
						//writerの取得
						$stmt2 = $dbh->prepare("select * from writers where id=:id");
					    $stmt2->execute(array(":id"=>$top_popular_contents_get["writer_id"]));
					    $get_writer2 = $stmt2->fetch();
							
						
					?>
					<div class="list_info"><p class="author"><?php echo $get_writer2["name"]; ?></p></div>
				</div>
				<span class="rank-icon"><?= $i; ?></span>
			</a>
		</li>
		<?php $i++; ?>
		<?php } ?>
	</ul>
</section>


<section class="content-area tag-cloud">
  <h2 class="title_section">の人気キーワード</h2>
  <ul class="side_keyword">
	  <?php while($tag = $get_tags->fetch(PDO::FETCH_ASSOC)){ ?>
      <li class="tag"><a href="tags-<?php echo $tag["id"]; ?>"><span><?php echo $tag["tag_title"]; ?></span></a></li>
      <?php } ?>
  </ul>
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
      <a href="../pc_tablet">
        <span class="icon icon-pc"></span> パソコン
      </a>
    </li>
    <li class="category-name">
      <a href="../smartphone_mobile">
        <span class="icon icon-smartphone"></span> スマートフォン・タブレット
      </a>
    </li>
    <li class="category-name">
      <a href="../image_audio">
        <span class="icon icon-audio"></span> 映像・オーディオ
      </a>
    </li>
    <li class="category-name">
      <a href="../camera">
        <span class="icon icon-camera"></span> カメラ
      </a>
    </li>
    <li class="category-name">
      <a href="../kitchen">
        <span class="icon icon-kitchen"></span> キッチン
      </a>
    </li>
    <li class="category-name">
      <a href="../home_app">
        <span class="icon icon-ce"></span> 生活家電
      </a>
    </li>
    <li class="category-name">
      <a href="../beauty_health">
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



  <p class="m-footer-copyright">Copyright© peroli, Inc. All Rights Reserved.</p>
  
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
      <a href="../pc_tablet">
        <span class="icon icon-pc"></span> パソコン
      </a>
    </li>
    <li class="category-name">
      <a href="../smartphone_mobile">
        <span class="icon icon-smartphone"></span> スマートフォン・タブレット
      </a>
    </li>
    <li class="category-name">
      <a href="../image_audio">
        <span class="icon icon-audio"></span> 映像・オーディオ
      </a>
    </li>
    <li class="category-name">
      <a href="../camera">
        <span class="icon icon-camera"></span> カメラ
      </a>
    </li>
    <li class="category-name">
      <a href="../kitchen">
        <span class="icon icon-kitchen"></span> キッチン
      </a>
    </li>
    <li class="category-name">
      <a href="../home_app">
        <span class="icon icon-ce"></span> 生活家電
      </a>
    </li>
    <li class="category-name">
      <a href="../beauty_health">
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

</div><span style="height: 20px; width: 40px; position: absolute; opacity: 1; z-index: 8675309; display: none; cursor: pointer; border: none; background-color: transparent; background-size: 40px 20px;"></span></style><script src="//code.jquery.com/jquery-latest.js"></script>
<script src="js/main.js"></script></body></html>