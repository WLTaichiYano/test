<?php
// セッション開始
session_start();

$db['user'] = "for815";
$db['pass'] = "chogo1991";


if(!empty($_SESSION['writer'])){
		
		header("Location: contents_list.php");
	    exit;
		
	}


if(!empty($_POST)){
	
	if(empty($_POST['user']) || empty($_POST['pass'])){
		echo "<p style='color:red'>空欄があります。</p>";
	}else{
		
		if($_POST['user'] == $db['user'] AND $_POST['pass'] == $db['pass']){
			
			$_SESSION['admin'] = 1;
			header('Location: http://dev-monostudio.com/contents_list.php');
			exit();
			
		}else{
			
			echo "<p style='color:red'>user名かpassが違います</p>";
			
		}
		
		
	}	
	
}

?>

<!doctype html>
<html>
  <head>
  <meta charset="UTF-8">
  <meta name=”robots” content=”noindex” />
  <title>adminログイン</title>
  </head>
  <body>
  <h1>adminログイン</h1>
  <form id="loginForm" name="loginForm" action="" method="POST">
  <fieldset>
  <div><?php echo $errorMessage ?></div>
  <label for="userid">ユーザID</label><input type="text" id="userid" name="user" value="<?php echo htmlspecialchars($_POST["userid"], ENT_QUOTES); ?>">
  <br>
  <label for="password">パスワード</label><input type="password" id="password" name="pass" value="">
  <br>
  <input type="submit" id="login" name="login" value="ログイン">
  </fieldset>
  </form>
  </body>
</html>