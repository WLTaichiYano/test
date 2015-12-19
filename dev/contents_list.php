<?php
session_start();
mb_language('ja');
mb_internal_encoding('UTF-8');
mb_regex_encoding('UTF-8');
header('Content-Type: text/html; charset=UTF-8');
require_once('config.php');

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
    
    	if(empty($_SESSION['admin'])){
	    	
	    	header('Location: http://dev-monostudio.com/');
    	}
    
		//top latest movies list
		$sql = "select * from contents where public=0 ORDER BY created DESC";
		
		if(empty($_GET['p'])) { 
			$_GET['p'] = 1;
		}
		
		if(!empty($_GET['p'])) { 
			$sql .= " LIMIT " . (($_GET['p'] -1) * 10) . ",10";
		}

		$stmt = $dbh->prepare($sql);
		$stmt->execute();

		
		//pagination
		$page = $_GET['p'];
		$contents_count = $dbh->prepare("SELECT count(id) FROM `contents`");
		$contents_count->execute();
		$contents_counts = $contents_count->fetch();
		$pagemax = ceil($contents_counts[0] / 10);
		$minp = max(1, $page - 2);
		$maxp = min($pagemax, $page + 2);
		if ($minp === 1) { $maxp = min($pagemax, 5); }
		if ($maxp === $pagemax) { $minp = max(1, $maxp - 4); }
		
		//maxpage以上のリクエストはpage1へ遷移させる
		/*if($_GET['p'] > $pagemax){
			
			header('Location: http://dev-monostudio.com/contents_list.php');
		}*/
		

		if(!empty($_POST['public'])){

			$sql = "UPDATE contents SET public = 1 where id =".$_POST['public'];
			$go_public = $dbh->prepare($sql);
			$go_public->execute();
			$sql2 = "UPDATE contents SET created = now() where id =".$_POST['public'];
			$go_public2 = $dbh->prepare($sql2);
			$go_public2->execute();
			header('Location: http://dev-monostudio.com/contents_list.php');
			
		}
		
		
?>	
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>mono studio</title>
<!--// Stylesheets //-->
<link href="../css/style.css" rel="stylesheet" type="text/css" />
<link href="../css/ddsmoothmenu.css" rel="stylesheet" type="text/css" />
<link href="../css/scrollbar.css" rel="stylesheet" type="text/css" />
<!--// Javascript //-->
<script type="text/javascript" src="../js/jquery.min.js"></script>
<script type="text/javascript" src="../js/ddsmoothmenu.js"></script>
<script type="text/javascript" src="../js/menu.js"></script>
<script type="text/javascript" src="../js/contentslider.js"></script>
<script type="text/javascript" src="../js/jquery.1.4.2.js"></script>
<script type="text/javascript" src="../js/jquery.lint.js"></script>
<script type="text/javascript" src="../js/jquery.scroll.js"></script>
<script type="text/javascript" src="../js/scroll.js"></script>
<script type="text/javascript" src="../js/jquery.idTabs.min.js"></script>
<script type="text/javascript" src="../js/switch.js"></script>
<script type="text/javascript" src="../js/tabs.js"></script>
<script type="text/javascript" src="../js/cufon-yui.js"></script>
<script type="text/javascript" src="../js/cufon.js"></script>
<script type="text/javascript" src="../js/Myriad_Pro_400-Myriad_Pro_700-Myriad_Pro_italic_400-Myriad_Pro_italic_700.font.js"></script>
</head>
<body>
<span class="biglines">&nbsp;</span>
<!-- Wrapper -->
<div id="wrapper_sec">
    <!-- Content Section -->
    <div id="content_sec">
    	<!-- Column 1 -->
        <div class="col1">
        <h2><a href="insert.php" style="color:blue;">insertする</a></h2>
            <!-- Recent Videos -->
            <div class="recent_videos">
            	<div class="recent_head">
            	<h1>管理画面です。</h1>
                   <!-- <a href="#" class="viewall">(View All)</a>-->
                </div>
                <hr style="margin-bottom:5px;" size="5"; noshade>
                <div class="clear"></div>
				<ul class="display">
					<?php while($contents = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
					<li style="margin:20px;">
						<?php
						
							$get_img = str_replace('../admin/', '', $contents['top_img']);
						
						?>
						<a href="#"><img src="<?php echo h($get_img); ?>" alt="" style="height:50px;"/></a>
						<h4><a href="" class="colr"><?php echo h($contents['title']); ?></a></h4>
						<div class="clear"></div>
						<div class="yourhere">
						<span>bigCategory:</span>
						<a href="#"><?php 
							
							$intval = intval($contents['big_id']);
							
							$sql3 = "select * from categories where id = " . $intval;
							$big = $dbh->prepare($sql3);
							$big->execute();
							$big = $big->fetch();
																
							echo $big['item_title'];
						
						?></a>
						</div>
						<div class="yourhere">
						<span>middleCategory:</span>
						<a href="#"><?php 
							
							$intval2 = intval($contents['middle_id']);
							$sql4 = "select * from categories where id = " . $intval2;
							$middle = $dbh->prepare($sql4);
							$middle->execute();
							$middle = $middle->fetch();
									
							echo $middle['item_title'];
						
						?></a>
						</div>
						<div class="yourhere">
						<span>intro:</span>
						<a href="#"><?php 
						
							echo h($contents['intro']);
						
						?></a>
						</div>
						<?php echo $contents['text_html']; ?>
						<div class="clear"></div>
						<div class="right">
						<form method="post" action="">
							<input type="hidden" name="public" value="<?php echo h($contents['id']); ?>">
							<input type="submit" value="公開する" style="width:100px;height:30px;font-size:48px;">
						</form>
						<a href="edit.php?id=<?php echo h($contents['id']); ?>"><button>編集する</button></a>
						</div>
					</li>
					<?php } ?>
				</ul>
            </div>
                <!-- Pagination -->
                <div class="paginations" style="margin-bottom:20px;">
                	<h5 class="pagehead">PAGE</h5>
                    <ul>
                    
                        <?php if($page != 1) { ?>
                     	<li class="leftpage"><a href="<?= "/?p=" . h($_GET['p'] - 1); ?>">＜</a></li>
                     	<?php } ?>
                    	<?php
							for ($i = $minp; $i <= $maxp; $i++) {
							
								if ($i == $page) {
									echo "<li class='pages'><a href='/?p={$i}' class='selected'>".  h($i) . "</a></li>";
								} else {
									echo "<li class='pages'><a href='/?p={$i}'>{$i}</a></li>";
								}
							}

							?>
						<?php if($page != $maxp) { ?>
                         <li class="nextpage"><a href="<?= "/?p=" . h($_GET['p'] + 1); ?>">＞</a></li>
						<?php } ?>
                        
                        
                    </ul>
                </div>
        </div>
</body>
</html>