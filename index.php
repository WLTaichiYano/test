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
		//top pickup movie
		$top_contents = $dbh->query("select * from contents where id=1 OR id=19 OR id=20");
		$top_contents->execute();
		
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
	    $get_tags = $dbh->query("select * from tags ORDER BY count limit 15");
		$get_tags->execute();		
	
		
		
		
?>
<!DOCTYPE html>
<html lang="ja">
  <head prefix="og: http://ogp.me/ns# fb: http://ogp.me/ns/fb#">
    <meta charset="UTF-8">
    <title>mono studio[モノスタジオ] | 家電の情報まとめ<?php if($_GET["p"] !== 1){ echo "(". $_GET["p"]. "} ページ目)"; } ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name=viewport content="width=device-width, initial-scale=1">
    <meta name="description" content="mono studio[モノスタジオ]は「家電」に関する知恵やノウハウが集まる情報サイトです。スマートフォン、パソコン、テレビ、カメラ、生活家電、キッチン家電、美容・健康家電、ガジェットなどに関する疑問や悩みがある方にとって役立つ情報を紹介しています">
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
	<meta name="robots" content="noindex,follow" />
	<link rel='prev' href='https://monostudio.jp/?p=<?= $_GET["p"]-1; ?>' />
	<?php } ?>
	<?php if($_GET["p"] !== $maxp){ ?>
	<link rel='next' href='https://monostudio.jp/?p=<?= $_GET["p"]+1; ?>' />
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
    googletag.defineSlot('/74229240/PC_top_rectangle', [300, 250], 'div-gpt-ad-1447655650389-0').addService(googletag.pubads());
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
<?php if($_GET["p"] == 1) { ?>
  <section id="eyecatch">
    <div class="eyecatch_in clearfix">
	    <div class="eyecatch_main">
    <?php
	        $i=0;
	    while($top_contents_get = $top_contents->fetch(PDO::FETCH_ASSOC)){
		    $i++;
	    ?>
        <div class="eyecatch_content2 eyecatch_content_<?= $i ?>">
	      <a href="<?= $top_contents_get['id']; ?>">
		　<img alt="" class="crop_image" height="200" src="<?= $top_contents_get['top_img']; ?>" width="320" /></a>
		　<p class="article_list_title"><a href="<?= $top_contents_get["id"]; ?>"><?= $top_contents_get['title']; ?></a></p>
		　<p class="article_list_lead"><?= $top_contents_get['heading']; ?></p>
		<ul class="eyecatch_content_info clearfix">
  <li class="eyecatch_content_user">
    

  <!--<a href="#">
    <img alt="MERY公式" height="20" src="user_img/monostudio.png" width="20" />
    Monostudio公式
	</a>-->
  </li>
 <!-- <li class="eyecatch_content_view">
    <span>23273</span>view
  </li>-->
</ul>
        </div>    
    <?php } ?>
	    </div>
    </div>
  </section>
<?php } ?>
<div id="wrapper" class="clearfix">
  <div id="column_content">
    <nav class="m-categoryMenu is-icon">
  <ul class="js-scrollFollow">
    <li class="m-categoryMenu-item search_title">
      <span>カテゴリから探す</span>
    </li>
    <li class="m-categoryMenu-item">
      <a href="pc_tablet"><span>パソコン</span></a>
    </li>
    <li class="m-categoryMenu-item">
      <a href="smartphone_mobile"><span>スマートフォン・タブレット</span></a>
    </li>
    <li class="m-categoryMenu-item">
      <a href="image_audio"><span>映像・オーディオ</span></a>
    </li>
    <li class="m-categoryMenu-item is-nail">
      <a href="camera"><span>カメラ</span></a>
    </li>
    <li class="m-categoryMenu-item is-beauty">
      <a href="kitchen"><span>キッチン</span></a>
    </li>
    <li class="m-categoryMenu-item is-gourmet">
      <a href="home_app"><span>生活家電</span></a>
    </li>
    <li class="m-categoryMenu-item is-gourmet">
      <a href="beauty_health"><span>美容・健康</span></a>
    </li>
      </ul>
</nav>

   <div id="content">
		<div class="m-headline is-border" style="padding-top:10px">
			<h2 class="m-headline-title">ピックアップ</h2>
		<!--<p class="m-headline-annotation">今日のピックアップまとめ</p>-->
		</div>
		
		<div class="article_list pickup_list">
		<?php while($contents_get = $top_movies_list->fetch(PDO::FETCH_ASSOC)){ ?>

			<div class="article_list_content clearfix">
				<div class="article_list_thumb" style="width:180px">
					<a href="<?= $contents_get['id']; ?>">
					<img alt="##" class="crop_image" height="100" src="<?= $contents_get['top_img']; ?>" width="160" />
					</a>
				</div>
				<div class="article_list_text">
					<p class="article_list_title">
					<a href="<?= $contents_get['id']; ?>"><?= $contents_get['title']; ?></a>
					</p>
					<p class="article_list_lead">
					<?= $contents_get['heading']; ?></p>
					<p class="article_list_next">
					<a href="<?= $contents_get['id']; ?>">続きを読む</a>
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
  </div>
<div id="column_sidebar">
	
	<!--DFPtag-->
	<!-- /74229240/PC_top_rectangle -->
	<div id='div-gpt-ad-1447655650389-0' style='height:250px; width:300px;'>
	<script type='text/javascript'>
	googletag.cmd.push(function() { googletag.display('div-gpt-ad-1447655650389-0'); });
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
			    <a href="/<?php echo $top_popular_contents_get["id"]; ?>">
			    	<img alt="#" class="crop_image" height="60" src="<?php echo $top_popular_contents_get["top_img"]; ?>" width="90" />
					<img class="icon_rank" src="images/rank<?= $i; ?>.png" alt="<?= $i; ?>位">
			    </a>
			</div>
		    <div class="article_list_text">
		    <p class="side_article_title">
		    	<a href="#"><?php echo $top_popular_contents_get["title"]; ?></a></p>
			</div>
		</div>
		<?php $i++; ?>
		<?php } ?>
    
    </div>

    <div class="title_section">
      <div class="title_section_in">
        <h2>今人気のキーワード</h2>
        <!--<p>いまMERYで話題になっているキーワード</p>-->
      </div>
    </div>
      <section class="side_keyword">
  <div class="keywords_area">
    <ul>
	   <?php while($get_tag = $get_tags->fetch(PDO::FETCH_ASSOC)){ ?>
          <li class="tag"><a href="tags-<?php echo $get_tag['id']; ?>"><?php echo $get_tag['tag_title']; ?></a></li>
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

  <p class="m-footerBottom-copyright">Copyright © 2015 mono stugio All Rights Reserved.</p>
</div>
</footer>
    
</body></html>