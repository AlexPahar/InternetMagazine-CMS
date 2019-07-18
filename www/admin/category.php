<?php 
	session_start();

	if ($_SESSION['auth_admin'] == "yes_auth") {

		define('myeshop', true);

		if (isset($_GET["logout"]))
		{
			unset($_SESSION['auth_admin']);
			header("Location: login.php");
		}
	$_SESSION['urlpage'] = "<a href='index.php'>Главная</a> / <a href='category.php'>Категории</a>";
	include("include/db_connect.php");
	include("include/functions.php");
	if ($_POST["submit_cat"])
	{
		$error = array();
		if (!$_POST["cat_type"]) $error[] = "Укажите тип товара!";
		if (!$_POST["cat_brand"]) $error[] = "Укажите название категории!";

		if(count($error))
		{
			$_SESSION['message'] = "<p id='form-error'>".implode('<br />', $error)."</p>";
		} else
		{
			$cat_type = clear_string($_POST["cat_type"]);
			$cat_brand = clear_string($_POST["cat_brand"]);

				mysql_query("INSERT INTO category(type, brand)
					VALUES(
						'".cat_type."',
						'".cat_brand."'
					)", $link);
			$_SESSION['message'] = "<p id='form-success'>Категория успешно добавлена!</p>";
		}

	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<script src="https://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.12.4.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<title>Панель управления - Категории</title>
</head>
<body>
	<div id="block-body">
		<?php
			include('include/block-header.php');
		?>
	<div id="block-content">
		<div id="block-parametrs">
			<p id="title-page">Категории</p>
		</div>
		<?php 
				if(isset($_SESSION['message']))
				{
					echo $_SESSION['message'];
					unset($_SESSION['message']);
				}
		?>
		<form method="POST">
			<ul id="cat_product">
				<li>	
					<label>Категории</label>
					<?php
				       echo '<div><a class="delete-cat">Удалить</a></div>'; 
					?>
					<select name="cat_type" id="cat_type" size="10">
						<?php 
							$result = mysql_query("SELECT * FROM category ORDER BY type DESC", $link);
							if (mysql_num_rows($result) > 0)
							{
								$row = mysql_fetch_array($result);
								do
								{
									echo '
									<option value="'.$row["id"].'">'.$row["type"].' - '.$row["brand"].'</option>
									';
								}
								while (mysql_fetch_array($result));
							}
						?>
					</select>
				</li>
				<li>
					<label>Тип товара</label>
					<input type="text" name="cat_type">
				</li>
				<li>
					<label>Бренд</label>
					<input type="text" name="cat_brand">
				</li>
			</ul>
			<p align="right"><input type="submit" name="submit_cat" id="submit_form"></p>
		</form>
	</div>
	</div>
</body>
</html>
		
<?php
 }  else 
 {
 	header("Location: login.php");
 }
?>