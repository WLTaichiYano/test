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
	    
	    header('Location: index.php');
	    
    }
    
    //categoryの取得
    $category = $_GET["id"];
    $sql3 = "select * from categories where alias=:category";
	$get_category = $dbh->prepare($sql3);
	$get_category->execute(array(":category"=>$category));
	$get_category = $get_category->fetch();
		 
	 //大カテゴリーの取得
	$sql = "select * from categories where id=:category";
	$get_bigcategory = $dbh->prepare($sql);
	$get_bigcategory->execute(array(":category"=>$get_category["big_id"]));
	$get_bigcategory = $get_bigcategory->fetch();
	
	
		//top latest movies list
	if($get_category["middle_c"] == NULL){
		
	$sql = "select * from contents where big_id=:category and public=1 ORDER BY created DESC";
		
	}else{
	
	$sql = "select * from contents where middle_id=:category and public=1 ORDER BY created DESC";
	
	}
	if(empty($_GET['p'])) { 
		$_GET['p'] = "1";
	}
	
	
	
	if(!empty($_GET['p'])) { 
		
		$num = $_GET["p"];
		
		
		$sql .= " LIMIT " . (($num - 1) * 20) . ",20";

	}
	
	$select_category = $dbh->prepare($sql);
	$select_category->execute(array(":category"=>$get_category["id"]));

	
	
			//pagination
		$page = $_GET['p'];
		
		if($get_category["middle_c"] == NULL){
			$sql2 = 'SELECT count(id) FROM `contents` where big_id=:category and public=1';
		}else{
			$sql2 = 'SELECT count(id) FROM `contents` where middle_id=:category and public=1';
		}
		
		$contents_count = $dbh->prepare($sql2);
		$contents_count->execute(array(":category"=>$get_category["id"]));
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
		$top_popular_contents = $dbh->query("select * from contents where public=1 AND date_format(last_count_date , '%Y-%m-%d') = date_sub(date(date_format( now() , '%Y-%m-%d')),interval 1 day) limit 5");
		$top_popular_contents->execute();
		
		
		//get tags
		$get_tags = $dbh->query("select * from tags ORDER BY count limit 10");
		$get_tags->execute();
		
		
		$sql3 = "select * from categories where alias=:category";
		$category_num = $dbh->prepare($sql3);
		$category_num->execute(array(":category"=>$_GET["id"]));
		$category_num = $category_num->fetch();
		
		
			switch ($category_num["big_id"]){
			case 1:
			$number = 4;
			$cate["jp"][0] = 'ノートパソコン';
			$cate["alias"][0] = 'notepc';
			$cate["jp"][1] = 'デスクトップパソコン';
			$cate["alias"][1] = 'desktoppc';
			$cate["jp"][2] = 'Mac';
			$cate["alias"][2] = 'Mac';
			$cate["jp"][3] = 'パソコン周辺機器';
			$cate["alias"][3] = 'computerperipherals';
			break;
			case 2:
			$number = 2;
			$cate["jp"][0] = 'スマートフォン';
			$cate["alias"][0] = 'smartphone';
			$cate["jp"][1] = 'タブレット';
			$cate["alias"][1] = 'tablet';
			break;
			case 3:
			$number = 3;
			$cate["jp"][0] = 'テレビ';
			$cate["alias"][0] = 'tv';
			$cate["jp"][1] = 'ヘッドホン・イヤホン';
			$cate["alias"][1] = 'headphone_earphone';
			$cate["jp"][2] = 'スピーカー';
			$cate["alias"][2] = 'speaker';
			break;
			case 4:
			$number = 3;
			$cate["jp"][0] = 'デジタルカメラ';
			$cate["alias"][0] = 'degitalcamera';
			$cate["jp"][1] = 'デジタル一眼レフカメラ';
			$cate["alias"][1] = 'singlelensreflexcamera';
			$cate["jp"][2] = 'ビデオカメラ';
			$cate["alias"][2] = 'videocamera';
			break;
			case 5:
			$number = 4;
			$cate["jp"][0] = '炊飯器';
			$cate["alias"][0] = 'ricecooker';
			$cate["jp"][1] = '電子レンジ・オーブンレンジ';
			$cate["alias"][1] = 'microwave';
			$cate["jp"][2] = '冷蔵庫・冷凍庫';
			$cate["alias"][2] = 'refrigerator';
			$cate["jp"][3] = '食洗機・食器乾燥機';
			$cate["alias"][3] = 'dishwashers';
			break;
			case 6:
			$number = 5;
			$cate["jp"][0] = '洗濯機';
			$cate["alias"][0] = 'washingmachine';
			$cate["jp"][1] = '掃除機';
			$cate["alias"][1] = 'vacuumcleaner';
			$cate["jp"][2] = '電動アシスト自転車';
			$cate["alias"][2] = 'power_assisted_bicycle';
			$cate["jp"][3] = '空気清浄機';
			$cate["alias"][3] = 'airpurifier';
			$cate["jp"][4] = '除湿機・加湿器';
			$cate["alias"][4] = 'dehumidifier_humidifier';
			break;
			case 7:
			$number = 5;
			$cate["jp"][0] = 'ドライヤー・ヘアアイロン';
			$cate["alias"][0] = 'dryer_hairiron';
			$cate["jp"][1] = '体重計・体脂肪計';
			$cate["alias"][1] = 'weighingscale_bodyfatscale';
			$cate["jp"][2] = '血圧計・体温計';
			$cate["alias"][2] = 'sphygmomanometer_thermometer';
			$cate["jp"][3] = 'シェーバー';
			$cate["alias"][3] = 'shaver';
			$cate["jp"][4] = '美容家電';
			$cate["alias"][4] = 'beautyequipment';
			break;
			default:
			
			header('Location: https://monostudio.jp/');
		}
		
		
		//descriptionタグの生成
		$description = mb_strimwidth($get_category["intro"], 0, 199, "...");
					
		?>
<!DOCTYPE html>
<html>
  <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
    <meta charset="UTF-8">
    <title><?php echo $get_category["item_title"];  ?>の情報まとめ | mono studio[モノスタジオ]<?php if($_GET["p"] !== 1){ echo "(". $_GET["p"]. "} ページ目)"; } ?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="description" content="<?= $description; ?>">
    <meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="@monostudio_jp">
	<meta name="twitter:title" content="<?php echo $get_bigcategory["item_title"];  ?>の情報まとめ | mono studio[モノスタジオ]">
	<meta name="twitter:description" content="<?= $description; ?>">
	<meta name="twitter:image" content="">
    <meta property="fb:app_id" content="180196992327206">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:title" content="<?php echo $get_bigcategory["item_title"];  ?>の情報まとめ | mono studio[モノスタジオ]">
    <meta property="og:type" content="website">
    <meta property="og:image" content="o">
    <meta property="og:url" content="https://monostudio.jp/">
    <meta property="og:site_name" content="mono studio">
    <meta property="og:description" content="<?= $description; ?>">
    <meta name="p:domain_verify" content="6ae5c3b79f2be421e8e68b1471007762">
	<link rel="canonical" href="https://monostudio.jp/<?= $get_category["alias"]; ?>">
	<?php if($_GET["p"] !== "1"){ ?>
	<meta name="robots" content="noindex,follow" />
	<link rel='prev' href='https://monostudio.jp/<?= $get_category["alias"]; ?>?p=<?= $_GET["p"]-1; ?>' />
	<?php } ?>
	<?php if($_GET["p"] !== $maxp){ ?>
	<link rel='next' href='https://monostudio.jp/<?= $get_category["alias"]; ?>?p=<?= $_GET["p"]+1; ?>' />
	<?php } ?> 
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
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
    googletag.defineSlot('/74229240/PC_category_rectangle', [300, 250], 'div-gpt-ad-1447655854968-0').addService(googletag.pubads());
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
     <!-- <ul class="m-header-navi">
          <li class="m-header-navi-menu"><a href="#">無料会員登録</a></li>
          <li class="m-header-navi-menu"><a href="#">ログイン</a></li>
      </ul>-->
  </div>
</header>
<section id="topBar">
  <ul class="topBar_in breadcrumb">
    <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="http://monostudio.jp/" itemprop="url"><span itemprop="title">mono studioトップ</span></a></li>
    <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo $get_bigcategory["alias"];  ?>" itemprop="url"><span itemprop="title"><?php echo $get_bigcategory["item_title"];  ?></span></a></li>
      <?php if($get_category["middle_c"] !== NULL) { ?>
      <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?php echo $get_category["alias"]; ?>" itemprop="url"><span itemprop="title"><?php echo $get_category["item_title"]; ?></span></a></li>
      <?php } ?>
      <?php if($_GET["p"] !== 1) { ?>
      <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><strong itemprop="title"><?= $_GET["p"]; ?>ページ</strong></li>
      <?php } ?>
  </ul>
</section>


<section id="eyecatch" class="category-catch">
  <div class="content">
    <div class="text">
        <h1 class="title" itemprop="name"><?php if($_GET["p"]!==1){ ?><a href="https://monostudio.jp/<?php echo $get_category["alias"]; ?>"><?php } ?><?php echo $get_category["item_title"]; ?><?php if($_GET["p"] !== 1){ echo "(".$_GET["p"]."ページ目)"; } ?><?php if($_GET["p"]!==1){ ?></a><?php } ?></h1>
      <p class="lead"><?php echo $get_category["intro"]; ?></p>
    </div>

    <img alt="" class="crop_image thumb" height="140" src="<?php echo $get_category["img"]; ?> " width="140" />
  </div>
</section>



<div id="wrapper" class="clearfix">
  <div id="column_content">
    <div id="content">
      <div class="m-headline is-border" style="padding-top:10px">
        <h2 class="m-headline-title"><?php echo $get_category["item_title"]; ?>のピックアップ記事</h2>
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
					<a href="<?php echo $get_list["id"]; ?>"><?php echo $get_list["title"]; ?></a>
				</p>
				<p class="article_list_lead">
					<?php echo $get_list["heading"]; ?>
				</p>
				<p class="article_list_next">
					<a href="<?php echo $get_list["id"]; ?>">続きを読む</a>
				</p>
			</div>
		</div>
		<?php } ?>

       <?php if($contents_counts[0] !== "0"){ ?>
		
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
		<?php } ?>
    </div>
  </div>

    <nav class="m-categoryMenu is-icon">
  <ul class="js-scrollFollow">
    <li class="m-categoryMenu-item search_title">
      <span>カテゴリから探す</span>
    </li>
    <?php for($i=0;$i<$number;$i++) { ?>
    <li class="m-categoryMenu-item">
      <a href="<?php echo $cate["alias"][$i]; ?>"><span><?php echo $cate["jp"][$i]; ?></span></a>
    </li>
    <?php } ?>     
   </ul>
</nav>
  </div>
  
<div id="column_sidebar">
	<!-- /74229240/PC_category_rectangle -->
	<div id='div-gpt-ad-1447655854968-0' style='height:250px; width:300px;'>
		<script type='text/javascript'>
		googletag.cmd.push(function() { googletag.display('div-gpt-ad-1447655854968-0'); });
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
			    <a href="<?php echo $top_popular_contents_get["id"]; ?>">
			    	<img alt="#" class="crop_image" height="60" src="<?php echo $top_popular_contents_get["top_img"]; ?>" width="90" />
					<img class="icon_rank" src="images/rank<?= $i; ?>.png" alt="<?= $i; ?>位">
			    </a>
			</div>
		    <div class="article_list_text">
		    <p class="side_article_title">
		    	<a href="<?php echo $top_popular_contents_get["id"]; ?>"><?php echo $top_popular_contents_get["title"]; ?></a></p>
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
          <li class="tag"><a href="tags-<?php echo $tag['id']; ?>"><?php echo $tag['tag_title']; ?></a></li>
      <?php } ?>
    </ul>
  </div>
</section>

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
</body></html>