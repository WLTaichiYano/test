<?php
define('DSN', 'mysql:host=mysql476.db.sakura.ne.jp;dbname=for815_monostudio');
define('DB_USER', 'for815');
define('DB_PASSWORD', 'seven00102');
define('LIFETIME', 60 * 60 * 24 * 30);

date_default_timezone_set('Asia/Tokyo');
 
error_reporting(E_ALL & ~E_NOTICE);
 
session_set_cookie_params(0, '/');

?>