<?php
    session_start();
	define('myeshop', true);
    include("include/db_connect.php");
    include("include/functions.php");
    if (isset($_POST['submit_enter']))
 {
    $login = $_POST["input_login"];
    $pass  = $_POST["input_pass"];
    
 if ($login && $pass)
  {   
   $result = mysql_query("SELECT * FROM reg_admin WHERE login = '$login' AND pass = '$pass'",$link);
   
 if (mysql_num_rows($result) > 0)
  {
    $row = mysql_fetch_array($result);
    $_SESSION['auth_admin'] = 'yes_auth'; 
    header("Location: index.php");
  }else
  {
    $msgerror = "Неверный Логин и(или) Пароль."; 
  }
    }else
    {
     $msgerror = "Заполните все поля!";
    }
 }
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<link href="css/style-login.css" rel="stylesheet" type="text/css">
	<meta charset="UTF-8">
	<title>CMS - Вход</title>
</head>
<body>
	<div id="block-pass-login">

		<?php 
			if ($msgerror) 
			{
			echo '<p id="msgerror">'.$msgerror.'</p>';
			}
		 ?>

		<form method="POST">
			<ul id="pass-login">
				<li><label for="">Логин</label><input type="text" name="input_login"></li>
				<li><label for="">Пароль</label><input type="password" name="input_pass"></li>
			</ul>
			<p align="right"><input type="submit" name="submit_enter" id="submit_enter" value="Вход"></p>
		</form>
	</div>
</body>
</html>