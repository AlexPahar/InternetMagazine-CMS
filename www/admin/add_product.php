<?php 
	session_start();

	if ($_SESSION['auth_admin'] == "yes_auth") {

		define('myeshop', true);

		if (isset($_GET["logout"]))
		{
			unset($_SESSION['auth_admin']);
			header("Location: login.php");
		}
	$_SESSION['urlpage'] = "<a href='index.php'>Главная</a> / <a href='tovar.php'>Товары</a> / <a>Добавление товара</a>";
	include("include/db_connect.php");
	include("include/functions.php");

	if ($_POST["submit_add"])
	{
		$error = array();

		//Проверка полей
		if (!$_POST["form_title"])
		{
			$error[] = "Укажите название товара";
		}
		if (!$_POST["form_price"])
		{
			$error[] = "Укажите цену товара";
		}
		if (!$_POST["form_category"])
		{
			$error[] = "Укажите категорию товара";
		}else 
		{
			$result = mysql_query("SELECT * FROM category WHERE id='{$_POST["form_category"]}'", $link);
			$row = mysql_fetch_array($result);
			$selectbrand = $row["brand"];
		}
		//Проверка чекбоксов
		if ($_POST["chk_visible"])
		{
			$chk_visible = "1";
		}
		else { $chk_visible = "0";}

		if ($_POST["chk_new"])
		{
			$chk_leader = "1";
		}
		else { $chk_leader = "0";}

		if ($_POST["chk_leader"])
		{
			$chk_sale = "1";
		}
		else { $chk_sale = "0";}

		if ($_POST["chk_sale"])
		{
			$chk_sale = "1";
		}else { $chk_sale = "0";}

		if (count($error))
		{
			$_SESSION['message'] = "<p id='form-error'>".implode('<br />', $error)."</p>";
		} else
		{
			mysql_query("INSERT INTO table_products(title,price,brand,seo_words,seo_description,mini_description,description,mini_features,features,new,leader,sale,visible,type_tovara,brand_id)
				VALUES(
					'".$_POST["form_title"]."',
					'".$_POST["form_price"]."',
					'".$selectbrand."',
					'".$_POST["form_seo_words"]."',
					'".$_POST["form_seo_description"]."',
					'".$_POST["txt1"]."',
					'".$_POST["txt2"]."',
					'".$_POST["txt3"]."',
					'".$_POST["txt4"]."',
					'".$chk_new."',
					'".$chk_leader."',
					'".$chk_sale."',
					'".$chk_visible."',
					'".$_POST["form_type"]."',
					'".$_POST["form_category"]."'
				)",$link);
			$_SESSION['message'] = "<p id='form-success'>Товар успешно добавлен!</p>";
			$id = mysql_insert_id();

			if(empty($_POST["upload_image"]))
			{
				include('/actions/upload-image.php');
				unset($_POST["upload_image"]);
			}

			//if(empty($_POST["galleryimg"]))
			//{
			//	include("/actions/upload-gallery.php");
			//	unset($_POST["galleryimg"]);
			//}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link href="css/style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="./ckeditor/ckeditor.js"></script>
	<script></script>
	<title>Панель управления</title>
</head>
<body>
	<div id="block-body">
		<?php
			include('include/block-header.php');
		?>
	<div id="block-content">
		<div id="block-parametrs">
			<p id="title-page">Добавление товара</p>
		</div>

		<?php 
			if(isset($_SESSION['message']))
			{
				echo $_SESSION['message'];
				unset($_SESSION['message']);
			}

			if(isset($_SESSION['answer']))
			{
				echo $_SESSION['answer'];
				unset($_SESSION['answer']);				
			}
		?>

		<form method="post" enctype="multipart/form-data">
			<ul id="edit-tovar">
				<li>
					<label>Название товара</label>
					<input type="text" name="form_title">
				</li>
				<li>
					<label>Цена</label>
					<input type="text" name="form_price">
				</li>
				<li>
					<label>Ключевые слова</label>
					<input type="text" name="form_seo_words">
				</li>
				<li>
					<label>Краткое описание</label>
					<textarea name="form_seo_description"> </textarea>
				</li>
				<li>
					<label>Тип товара</label>
					<select name="form_type" id="type" size="1">
						<option value="food">Продукты</option>
						<option value="drink">Напитки</option>
						<option value="prochee">Прочее</option>
					</select>
				</li>
				<li>
					<label>Категория</label>
					<select name="form_category" size="10">
						<?php 
							$category = mysql_query("SELECT * FROM category", $link);
							if (mysql_num_rows($category) > 0) 
							{
								$result_category = mysql_fetch_array($category);
								do {
									echo '
										<option value="'.$result_category["id"].'">'.$result_category["brand"].'</option>
									';
								}
								while ($result_category = mysql_fetch_array($category));
							}
						?>
					</select>
				</li>
			</ul>
			<label class="stylelabel">Основная картинка</label>
			<div id="baseimg-upload">
				<input type="hidden" name="MAX_FILE_SIZE" value="5000000">
				<input type="file" name="upload_image">
			</div>
			<h3 class="h3click">Краткое описание товара</h3>
			<div class="div-editor1">
				<textarea name="txt1" id="editor1" cols="100" rows="20"></textarea>
				<script type="text/javascript">
					var ckeditor1 = CKEDITOR.replace("editor1");
					AjexFileManager.init({
						returnTo: "ckeditor",
						editor: ckeditor1
					});
				</script>
			</div>
			<h3 class="h3click">Описание товара</h3>
			<div class="div-editor2">
				<textarea name="txt2" id="editor2" cols="100" rows="20"></textarea>
				<script type="text/javascript">
					var ckeditor1 = CKEDITOR.replace("editor2");
					AjexFileManager.init({
						returnTo: "ckeditor",
						editor: ckeditor1
					});
				</script>
			</div>
			<h3 class="h3click">Краткие характеристики</h3>
			<div class="div-editor3">
				<textarea name="txt3" id="editor3" cols="100" rows="20"></textarea>
				<script type="text/javascript">
					var ckeditor1 = CKEDITOR.replace("editor3");
					AjexFileManager.init({
						returnTo: "ckeditor",
						editor: ckeditor1
					});
				</script>
			</div>
			<h3 class="h3click">Характеристики</h3>
			<div class="div-editor4">
				<textarea name="txt4" id="editor4" cols="100" rows="20"></textarea>
				<script type="text/javascript">
					var ckeditor1 = CKEDITOR.replace("editor4");
					AjexFileManager.init({
						returnTo: "ckeditor",
						editor: ckeditor1
					});
				</script>
			</div>
			<label class="stylelabel">Галерея картинок</label>
			<div id="objects">
				<div id="addimage1" class="addimage">
					<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
					<input type="file" name="galleryimg[]">
				</div>
			</div>
			<p id="add-input">Добавить</p>
			<h3 class="h3title">Настройки товара</h3>
			<ul id="chkbox">
				<li><input type="checkbox" name="chk_visible" id="chk_visible"><label for="chk_visible">Показывать товар</label></li>
				<li><input type="checkbox" name="chk_new" id="chk_new"><label for="chk_new">Новый товар</label></li>
				<li><input type="checkbox" name="chk_leader" id="chk_leader"><label for="chk_leader">Популярный товар</label></li>
				<li><input type="checkbox" name="chk_sale" id="chk_sale"><label for="chk_sale">Товар со скидкой</label></li>
			</ul>
			<p align="right"><input type="submit" id="submit_form" name="submit_add" value="Добавить товар"></p>
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