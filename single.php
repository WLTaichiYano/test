<?php
	
	mb_language('ja');
	mb_internal_encoding('UTF-8');
	mb_regex_encoding('UTF-8');
	header('Content-Type: text/html; charset=UTF-8');
	require_once('assets/php/config.php');
	session_start();

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
    
    
        //get contents
		$stmt = $dbh->prepare("select * from contents where id=:request AND public=1");
	    $stmt->execute(array(":request"=>$_GET['id']));
	    $get_contents = $stmt->fetch();
	    
	    //get elements
	    $stmt2 = $dbh->prepare("select * from elements where contents_id=:request ORDER BY num asc");
	    $stmt2->execute(array(":request"=>$get_contents["id"]));
	    
	    
	    //月日の取得
	    $get_date = date("Y年m月d日", strtotime($get_contents["created"]));
	    $date = new DateTime($get_contents["created"]);
		$get_date_content = $date->format('Y-m-d');

	    if($get_contents == NULL){
		
			header('Location: https://monostudio.jp');
		
		}
		
		//pvcount
		
		
		$contents_num = $_GET['id'];
		$ip = $_SERVER["REMOTE_ADDR"];
		
		
		$sql2 = "select * from pv_counts where page_id = '".$contents_num."' AND ip ='".$ip."' AND created > current_timestamp - interval 30 minute";
		$within_threeminutes = $dbh->prepare($sql2);
		$within_threeminutes->execute();
		$within_threeminutes_count = $within_threeminutes->fetch();
		
		if($within_threeminutes_count == false){
		
			$sql = "insert into `pv_counts` 
			(`page_id`, `ip`, `created`) 
			values 
			(:page_id, :ip, now())";
			$insert_pv = $dbh->prepare($sql);
			$params = array(
			":page_id" => $contents_num,
			":ip" => $ip
						);
			$insert_pv->execute($params);
			
			
			$sql5 = "UPDATE contents SET count = count + 1 where id =".$contents_num;
			$change_now = $dbh->prepare($sql5);
			$change_now->execute();
			$sql6 = "UPDATE contents SET last_count_date = now() where id =".$contents_num;
			$change_now2 = $dbh->prepare($sql6);
			$change_now2->execute();
			
		
		}
		
		
				//get popular contents
		$top_popular_contents = $dbh->query("select * from contents where public=1 AND date_format(last_count_date , '%Y-%m-%d') = date_sub(date(date_format( now() , '%Y-%m-%d')),interval 1 day) limit 5");
		$top_popular_contents->execute();
		
		
		//descriptionタグの生成
		$description = mb_strimwidth($get_contents["intro"], 0, 199, "...");
		
		
		//get popular contents
		$top_popular_contents = $dbh->query("select * from contents where public=1 AND date_format(last_count_date , '%Y-%m-%d') = date_sub(date(date_format( now() , '%Y-%m-%d')),interval 1 day) limit 5");
		$top_popular_contents->execute();
		    
	
?>
<!DOCTYPE html>
<html>
  <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
    <meta charset="UTF-8">
    <title><?php echo h($get_contents["title"]); ?>| mono studio[モノスタジオ]</title>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="<?= $description; ?>">
    <meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:site" content="@monostudio_jp">
	<meta name="twitter:title" content="<?php echo h($get_contents["title"]); ?>| mono studio[モノスタジオ]">
	<meta name="twitter:description" content="<?= $description; ?>">
	<meta name="twitter:image" content="">
    <meta property="fb:app_id" content="180196992327206">
    <meta property="og:locale" content="ja_JP">
    <meta property="og:title" content="<?php echo h($get_contents["title"]); ?>| mono studio[モノスタジオ]">
    <meta property="og:type" content="website">
    <meta property="og:image" content="o">
    <meta property="og:url" content="https://monostudio.jp/">
    <meta property="og:site_name" content="mono studio">
    <meta property="og:description" content="<?= $description; ?>">
    <meta name="p:domain_verify" content="6ae5c3b79f2be421e8e68b1471007762">
	<link rel="canonical" href="https://monostudio.jp/<?php echo h($get_contents["id"]); ?>">
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
    googletag.defineSlot('/74229240/PC_content_rectangle', [300, 250], 'div-gpt-ad-1447655890130-0').addService(googletag.pubads());
    googletag.pubads().enableSingleRequest();
    googletag.enableServices();
  });
</script>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');</script>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.5&appId=569930266377855";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>   
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
      <!--<ul class="m-header-navi">
          <li class="m-header-navi-menu"><a href="#">無料会員登録</a></li>
          <li class="m-header-navi-menu"><a href="#">ログイン</a></li>
      </ul>-->
  </div>
</header>
<?php
	$stmt = $dbh->prepare("select * from categories where id=:request");
    $stmt->execute(array(":request"=>$get_contents["big_id"]));
    $get_big = $stmt->fetch();
    
    
    $stmt = $dbh->prepare("select * from categories where id=:request");
    $stmt->execute(array(":request"=>$get_contents["middle_id"]));
    $get_middle = $stmt->fetch();
    
?>
<section id="topBar">
  <ul class="topBar_in breadcrumb">
    <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="https://monostudio.jp/" itemprop="url"><span itemprop="title">mono studioトップ</span></a></li>
    <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><a href="<?= $get_big["alias"] ?>" itemprop="url"><span itemprop="title"><?php echo h($get_big["item_title"]); ?></span></a></li>
      <li itemscope itemtype="http://data-vocabulary.org/Breadcrumb"><strong itemprop="title"><?php echo h($get_middle["item_title"]); ?></strong></li>
  </ul>
</section>
	<section id="eyecatch" class="movie">
		<div class="eyecatch_in clearfix">
			<p class="article_date" style="margin-bottom:10px;font-size: 12px; opacity: 0.7;" itemprop="dateModified" content="<?= $get_date_content; ?>"><?= $get_date; ?></p>
			<div id="eyecatch_container" style="width:720px;float:left;">
				<div class="eyecatch_content eyecatch_content_1">
					<h1 class="title" itemprop="name">
						<?php echo h($get_contents["title"]); ?>
					</h1>
					<div class="text">
						<p class="article_lead" itemprop="description"><?php echo h($get_contents["intro"]); ?></p>
					</div>
				</div>
			</div>
			<div id="eyecatch_container" style="width:280px;float:left;">
				<div class="user_left" style="width:100px;">
					<img src="user_img/monostudio.png" style="width:90px;height:90px;float:left;margin:5px;"/>
				</div>
				<div class="user_right" style="width:175px;float:left;margin-left:5px;">
					<p class="side_curator_name">monostudio公式アカウント</p>
					<p class="side_curator_desc">MonoStudioがファッション・メイクコスメの新作アイテムや、最新のグルメ情報・おでかけスポットをお届け！</p>
				</div>
			</div>
		</div>
	</section>
</section>
<div id="wrapper" class="clearfix">
  <div id="column_content" class="column_article">
     <article id="article">
	<div class="articleArea" data-page="1" itmprop="articleBody">
		<div id="list_content">
		
			<?php while($main = $stmt2->fetch(PDO::FETCH_ASSOC)){  ?>
			
				<?php if($main["type"] == "title"){ ?>
				
					<!--タイトルの場合-->
					<div class="article_content">
						<h2 class="article_headline" style="border-bottom-color:#0096CC;"><?= $main["content"]; ?></h2>	
					</div>
				
				<?php }elseif($main["type"] == "img"){ ?>
				
					<!-- imgとrefの場合 -->
					<div class="article_content" data-item-type="Image">
						<div class="article_image_area clearfix">
							<div class="article_image  ">
								<img class="article_img x-article-image " src="<?= $main["content"]; ?>" />
								<p class="rel">出典：
								<a href="http://<?= $main["ref"]; ?>" target="_blank"><?= $main["ref"]; ?></a>
								</p>
							</div>
						</div>
					</div>
				
				<?php }elseif($main["type"] == "text"){ ?>
				
					<!--textの場合-->
				    <div class="article_content">
						<div class="article_image_text">
							<p class="article_text"><?= $main["content"]; ?></p>
						</div>
				    </div>
				
				<?php } ?>
				
			<?php } ?>
		</div><!-- list content -->
	</div>
      <div class="articleInfo afterInfo clearfix">
        <ul class="share">
          <li data-page="1" data-position="lower" data-target-action="page_share_clk" data-at="twitter">
            <a href="https://twitter.com/share" class="twitter-share-button"{count} data-via="monostudio_jp" data-lang="ja">ツイート</a>
          </li>

          <li>
            <div class="fb-share-button" data-href="https://monostudio.jp/<?php echo h($get_contents["id"]); ?>" data-layout="button_count"></div>
          </li>
        </ul>
      </div>
    </article>

  </div>

  <div id="column_sidebar">

    <div id="column_sidebar_inner">
	    
	  	<div id='div-gpt-ad-1447655890130-0' style='height:250px; width:300px;'>
			<script type='text/javascript'>
			googletag.cmd.push(function() { googletag.display('div-gpt-ad-1447655890130-0'); });
			</script>
		</div>
  
      <div class="title_section">
        <div class="title_section_in">
          <h2>人気記事一覧</h2>
          <!--<p>いま注目のまとめ</p>-->
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
    </div>
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