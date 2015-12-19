<?php
	
	mb_language('ja');
	mb_internal_encoding('UTF-8');
	mb_regex_encoding('UTF-8');
	header('Content-Type: text/html; charset=UTF-8');
	require_once('assets/php/config.php');

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
	    
	    header('Location: https://monostudio.jp');
	    
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
	
	
	//contents数の取得(5contents以下はnoindex)
	if($_GET["id"] == 1){
		
		$sql2 = "select count(id) from contents where id=:id and public=1";
		$count_contents = $dbh->prepare($sql2);
		$count_contents->execute(array(":id"=>$get_contents_id["contents_id"]));
		$count_contents_noindex = $contents_counts->fetch();
	
	}
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
		$get_tags = $dbh->query("select * from tags ORDER BY count limit 10");
		$get_tags->execute();
	
?>
<!DOCTYPE html>
<html>
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
	<?php if($count_contents_noindex < 5) { ?>
	<meta name="robots" content="noindex,follow" />
	<?php } ?>
	<?php if($_GET["p"] !== "1"){ ?>
	<meta name="robots" content="noindex,follow" />
	<link rel='prev' href='https://monostudio.jp/tags-<?php echo $tag["id"]; ?>?p=<?= $_GET["p"]-1; ?>' />
	<?php } ?>
	<?php if($_GET["p"] !== $maxp){ ?>
	<link rel='next' href='https://monostudio.jp/tags-<?php echo $tag["id"]; ?>?p=<?= $_GET["p"]+1; ?>' />
	<?php } ?>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <!--ライター募集の導線-->
<script type='text/javascript'>
  var googletag = googletag || {};
  googletag.cmd = googletag.cmd || [];
  (function() {
    var gads = document.createElement('script');
    gads.async = true;
    gads.type = 'text/javascript';
    var useSSL = 'https:' == document.location.protocol;
    gads.src = (useSSL ? 'https:' : 'http:') +
      '//www.googletagservices.com/tag/js/gpt.js';
    var node = document.getElementsByTagName('script')[0];
    node.parentNode.insertBefore(gads, node);
  })();
</script>

<script type='text/javascript'>
  googletag.cmd.push(function() {
    googletag.defineSlot('/74229240/PC_tag_rectangle', [300, 250], 'div-gpt-ad-1448442343261-0').addService(googletag.pubads());
    googletag.pubads().enableSingleRequest();
    googletag.enableServices();
  });
</script>  
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
      <input class="m-header-search-input" id="q" name="query" placeholder="気になるワードを入力" type="text" value="<?php echo h($_GET['query']); ?>"/>
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
    <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="#" itemprop="url"><span itemprop="title">mono studioトップ</span></a></li>
    <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="#" itemprop="url"><span itemprop="title">キーワード</span></a></li>
      <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><strong itemprop="title"><?php echo $tag["tag_title"]; ?></strong></li>
      <?php if($_GET["p"] !== 1) { ?>
      <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><strong itemprop="title"><?= $_GET["p"]; ?>ページ</strong></li>
      <?php } ?>
  </ul>
</section>


<section id="eyecatch" class="category-catch">
  <div class="content" style="border: none;">
    <div class="text">
        <h1 class="title"><?php if($_GET["p"]!==1){ ?><a href="https://monostudio.jp/tags-<?php echo $tag["id"]; ?>"><?php } ?><?php echo $tag["tag_title"]; ?>に関する記事<?php if($_GET["p"] !== 1) { echo "(".$_GET["p"]."ページ目)"; } ?><?php if($_GET["p"]!==1){ ?></a><?php } ?></h1>

          <!--<ul class="genre_tags">
              <li class="tag">
                <a href="#">4S</a>
              </li>
              <li class="tag">
                <a href="#">6</a>
              </li>
          </ul>-->
    </div>

    <img alt="<?php echo $tag["tag_title"]; ?>" class="crop_image thumb" height="140" src="<?php echo $get_contents_img["top_img"]; ?>" width="140" />
  </div>
</section>

<div id="wrapper" class="clearfix" >
  <div id="column_content">
      <div class="m-headline is-border" style="padding-top:10px">
        <h2 class="m-headline-title"><?php echo $tag["tag_title"]; ?>のピックアップ記事</h2>
       <?php
	       //◯件〜◯件の取得
	       if($num==1){
		    
		    	$start = $num;
		    	if($contents_counts[0] > 10){
			    	
			    	$end = 10;	
			    	
		    	}else{
			    	
			    	$end = $contents_counts[0];
			    	
		    	}
		       
	       }else{
	       
	       		$start = (($num - 1) * 30);
	       		
	       		$rest = $contents_counts - $start;
	       		if($rest < 30){
		       		
		       		$end = $start + $rest;
	       		
	       		}else{
		       		
		       		$end = $start + 30;	
	       		}
	       
	       }
       ?>
        <p class="m-headline-annotation"><?php echo $contents_counts[0]; ?>件中 <?php echo $start; ?> - <?php echo $end; ?> 件</p>
      </div>

        <div class="article_list">
	    <?php while($get_list = $select_category->fetch(PDO::FETCH_ASSOC)){ ?>
	     <div class="article_list_content clearfix">
			<div class="article_list_thumb" style="width:180px">
				<a href="<?php echo $get_list["id"]; ?>" data-list-id="169835">
					<img alt="##" class="crop_image" height="100" src="<?php echo $get_list["top_img"]; ?>" width="160" />
				</a>
			</div>
			<div class="article_list_text">
				<p class="article_list_title">
					<a href="../<?php echo $get_list["id"]; ?>"><?php echo $get_list["title"]; ?></a>
				</p>
				<p class="article_list_lead">
					<?php echo $get_list["heading"]; ?>
				</p>
				<p class="article_list_next">
					<a href="../<?php echo $get_list["id"]; ?>">続きを読む</a>
				</p>
			</div>
		</div>
		<?php } ?>


		<div id="paginate">
			<?php if($page != 1) { ?>
			<a href="<?= "/?p=" . h($_GET['p'] - 1); ?>">＜</a>
			<?php } ?>
			<?php
			for ($i = $minp; $i <= $maxp; $i++) {
				if ($i == $page) {
					echo "<a href='/?p={$i}' class='selected'>".  h($i) . "</a>";
				} else {
					echo "<a href='/?p={$i}'>{$i}</a>";
				}
			}
			
			?>
			<?php if($page != $maxp) { ?>
			<a href="<?= "/?p=" . h($_GET['p'] + 1); ?>">＞</a>
			<?php } ?>
		</div>
    </div>
  </div>
  
<div id="column_sidebar">
	<!-- /74229240/PC_tag_rectangle -->
	<div id='div-gpt-ad-1448442343261-0' style='height:250px; width:300px;'>
	<script type='text/javascript'>
	googletag.cmd.push(function() { googletag.display('div-gpt-ad-1448442343261-0'); });
	</script>
	</div>

    <div class="title_section">
	    <div class="title_section_in">
		    <h2>人気記事ランキング</h2>
	    </div>
    </div>
    <div class="side_article_list">
	    <?php $i=1; ?>
	    <?php while($top_popular_contents_get = $top_popular_contents->fetch(PDO::FETCH_ASSOC)){  ?>
		<div class="article_list_content clearfix">
		    <div class="article_list_thumb" style="width:100px">
			    <a href="../<?php echo $top_popular_contents_get["id"]; ?>">
			    	<img alt="#" class="crop_image" height="60" src="<?php echo $top_popular_contents_get["top_img"]; ?>" width="90" />
					<img class="icon_rank" src="images/rank<?= $i; ?>.png" alt="<?= $i; ?>位">
			    </a>
			</div>
		    <div class="article_list_text">
		    <p class="side_article_title">
		    	<a href="../<?php echo $top_popular_contents_get["id"]; ?>"><?php echo $top_popular_contents_get["title"]; ?></a></p>
			</div>
		</div>
		<?php $i++; ?>
		<?php } ?>    
    </div>
    
 

    <div class="title_section">
      <div class="title_section_in">
        <h2>人気のキーワード</h2>
      </div>
    </div>
      <section class="side_keyword">
  <div class="keywords_area">
    <ul>
	  <?php while($tag = $get_tags->fetch(PDO::FETCH_ASSOC)){ ?>
          <li class="tag"><a href="<?php echo $tag['id']; ?>"><?php echo $tag['tag_title']; ?></a></li>
      <?php } ?>
    </ul>
  </div>
</section>

    <!--<p class="genre_to_allTags"><a href="#">人気のキーワード一覧</a></p>-->
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

  <p class="m-footerBottom-copyright">Copyright © 2015 mono studio All Rights Reserved.</p>
</div>
</footer>
</body></html>