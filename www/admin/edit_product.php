<?php 
	session_start();

	if ($_SESSION['auth_admin'] == "yes_auth") {

		define('myeshop', true);

		if (isset($_GET["logout"]))
		{
			unset($_SESSION['auth_admin']);
			header("Location: login.php");
		}
	$_SESSION['urlpage'] = "<a href='index.php'>Главная</a> / <a href='tovar.php'>Товары</a> / <a>Изменение товара</a>";
	include("include/db_connect.php");
	include("include/functions.php");

	$id = clear_string($_GET["id"]);

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
            $_SESSION['message'] = "<p id='form-error'>".implode('<br />',$error)."</p>";
            
       }else
       {
                           
       $querynew = "title='{$_POST["form_title"]}',price='{$_POST["form_price"]}',brand='$selectbrand',seo_words='{$_POST["form_seo_words"]}',seo_description='{$_POST["form_seo_description"]}',mini_description='{$_POST["txt1"]}',description='{$_POST["txt2"]}',mini_features='{$_POST["txt3"]}',features='{$_POST["txt4"]}',new='$chk_new',leader='$chk_leader',sale='$chk_sale',visible='$chk_visible',type_tovara='{$_POST["form_type"]}',brand_id='{$_POST["form_category"]}'"; 
           
       $update = mysql_query("UPDATE table_products SET $querynew WHERE products_id = '$id'",$link); 
                   
      $_SESSION['message'] = "<p id='form-success'>Òîâàð óñïåøíî èçìåíåí!</p>";
                
}

     
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link href="css/style.css" rel="stylesheet" type="text/css">
    <link href="jquery_confirm/jquery_confirm.css" rel="stylesheet" type="text/css" />
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
		<?php 
			$result = mysql_query("SELECT * FROM table_products WHERE product_id='$id'", $link);
			if (mysql_num_rows($result) > 0)
			{
				$row = mysql_fetch_array($result);
				do
				{
					echo '
						
						<form method="post" enctype="multipart/form-data">
			<ul id="edit-tovar">
				<li>
					<label>Название товара</label>
					<input type="text" name="form_title" value="'.$row["title"].'">
				</li>
				<li>
					<label>Цена</label>
					<input type="text" name="form_price" value="'.$row["price"].'">
				</li>
				<li>
					<label>Ключевые слова</label>
					<input type="text" name="form_seo_words" value="'.$row["seo_words"].'">
				</li>
				<li>
					<label>Краткое описание</label>
					<textarea name="form_seo_description">'.$row["seo_description"].'</textarea>
				</li>
				


					';
							$category = mysql_query("SELECT * FROM category", $link);
							if (mysql_num_rows($category) > 0) 
							{
								$result_category = mysql_fetch_array($category);

								if ($row["type_tovara"] == "food") $type_food = "selected";
								if ($row["type_tovara"] == "drink") $type_drink = "selected";
								if ($row["type_tovara"] == "prochee") $type_prochee = "selected";

								echo '
									<li>
					<label>Тип товара</label>
					<select name="form_type" id="type" size="1">
						<option '.$type_food.' value="food">Продукты</option>
						<option '.$type_drink.' value="drink">Напитки</option>
						<option '.$type_prochee.' value="prochee">Прочее</option>
					</select>
				</li>
				<li>
					<label>Категория</label>
					<select name="form_category" size="10">
								';

								do {
									echo '
										<option value="'.$result_category["id"].'">'.$result_category["type"].'-'.$result_category["brand"].'</option>
									';
								}
								while ($result_category = mysql_fetch_array($category));
							}

							echo '
								
								</select>
				</li>
			</ul>
			';

			if (strlen($row["image"]) > 0 && file_exists("../uploads_images/".$row["image"]))
			{
				$img_path = '../uploads_images/'.$row["image"];
				$max_width = 110;
				$max_height = 110;
				list($width, $height) = getimagesize($img_path);
				$ratioh = $max_height/$height;
				$ratiow = $max_width/$width;
				$ratio = min($ratioh, $ratiow);

				$width = intval($ratio*$width);
				$height = intval($ratio*$height);

				echo '
				<label class="stylelabel">Основная картинка</label>
				<div id="baseimg">
					<img src="'.$img_path.'" width="'.$width.'" height="'.$height.'">
					<a href="edit_product.php?id='.$row["product_id"].'&img='.$row["image"].'&actions=delete"></a>
				</div>
				';
			}
			else {
				echo '
					<label class="stylelabel">Основная картинка</label>
					<div id="baseimg-upload">
						<input type="hidden" name="MAX_FILE_SIZE" value="5000000">
						<input type="file" name="upload_image">
					</div>
				';
			}

			echo '
			
			<h3 class="h3click">Краткое описание товара</h3>
			<div class="div-editor1">
				<textarea name="txt1" id="editor1" cols="100" rows="20">'.$row["mini_description"].'</textarea>
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
				<textarea name="txt2" id="editor2" cols="100" rows="20">'.$row["description"].'</textarea>
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
				<textarea name="txt3" id="editor3" cols="100" rows="20">'.$row["mini_features"].'</textarea>
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
				<textarea name="txt4" id="editor4" cols="100" rows="20">'.$row["features"].'</textarea>
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
			';

			
				if ($row["visible"] == '1') $checked1 = "checked";
				if ($row["new"] == '1') $checked2 = "checked";
				if ($row["leader"] == '1') $checked3 = "checked";
				if ($row["sale"] == '1') $checked4 = "checked";

				echo '
					<h3 class="h3title">Настройки товара</h3>
					<ul id="chkbox">
						<li><input type="checkbox" name="chk_visible" id="chk_visible" '.$checked1.'><label for="chk_visible">Показывать товар</label></li>
						<li><input type="checkbox" name="chk_new" id="chk_new" '.$checked2.'><label for="chk_new">Новый товар</label></li>
						<li><input type="checkbox" name="chk_leader" id="chk_leader" '.$checked3.'><label for="chk_leader">Популярный товар</label></li>
						<li><input type="checkbox" name="chk_sale" id="chk_sale" '.$checked4.'><label for="chk_sale">Товар со скидкой</label></li>
					</ul>
					<p align="right"><input type="submit" id="submit_form" name="submit_save" value="Сохранить изменения"></p>
				</form>

				';

					}while ($row = mysql_fetch_array($result));
				}
			?>
					
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