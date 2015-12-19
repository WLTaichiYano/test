<?php
define('DSN', 'mysql:host=db3.ckbymndjdhxe.ap-northeast-1.rds.amazonaws.com;dbname=main1');
define('DB_USER', 'monostudio_root');
define('DB_PASSWORD', 'monostudio_root');
define('LIFETIME', 60 * 60 * 24 * 30);

date_default_timezone_set('Asia/Tokyo');
 
error_reporting(E_ALL & ~E_NOTICE);
 
session_set_cookie_params(0, '/');

?>
