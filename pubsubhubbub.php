<?php
	mb_language('ja');
	mb_internal_encoding('UTF-8');
	mb_regex_encoding('UTF-8');
	header('Content-Type: text/html; charset=UTF-8');
	require_once('assets/php/config.php');

	try {
        $dbh = new PDO(DSN, DB_USER, DB_PASSWORD);
        $stmt = $dbh -> query("SET NAMES utf8;");
    } catch (PDOException $e) {
        echo $e->getMessage();
        exit;
    }
    
    $sql = "SELECT * FROM contents WHERE created > current_timestamp + interval -10 minute";
	$within_10min = $dbh->query($sql);
	$within_10min->execute();
	$get_c = $within_10min->fetch();

	
	if($get_c !== FALSE){

		// ライブラリを読み込む
		require_once 'assets/php/publisher.php' ;
	
		// プッシュ通知先のURL(Googleに通知する場合は変更しない)
		$hub_url = 'http://pubsubhubbub.appspot.com/' ;
	
		// インスタンスを作成し、そのパスを$pshbに代入する
		$pshb = new Publisher($hub_url) ;
		
		
		while($get_contents = $within_10min->fetch(PDO::FETCH_ASSOC)){
			
			
			// インデックスさせたい記事のURLアドレス
			$post_url = 'https://monostudio.jp/'.$get_contents["id"];
		
			// プッシュ通知
			$pshb->publish_update($post_url);
		
		}
	
	}
	
	
	