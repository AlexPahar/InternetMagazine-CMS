<?php 
	session_start();

	if ($_SESSION['auth_admin'] == "yes_auth") {

		define('myeshop', true);

		if (isset($_GET["logout"]))
		{
			unset($_SESSION['auth_admin']);
			header("Location: login.php");
		}
	$_SESSION['urlpage'] = "<a href='index.php'>Главная</a> / <a href='tovar.php'>Товары</a>";
	include("include/db_connect.php");

	include("include/functions.php");
	$cat = $_GET["cat"];
	$type = $_GET["type"];

	if (isset($cat))
	{
		switch ($cat) {
			case 'all':
			$cat_name = "Все товары";
			$url = "cat=all&";
			$cat = "";
			break;

			case 'food':
			$cat_name = "Продукты";
			$url = "cat=food&";
			$cat = "WHERE type_tovara='food'";
			break;

			case 'drink':
			$cat_name = "Напитки";
			$url = "cat=drink&";
			$cat = "WHERE type_tovara='drink'";
			break;

			case 'prochee':
			$cat_name = "Прочее";
			$url = "cat=prochee&";
			$cat = "WHERE type_tovara='prochee'";
			break;
			
			default:
			$cat_name = $cat;
			$url = "type=".clear_string($type)."&cat=".clear_string($cat)."&";
			$cat = "WHERE type_tovara='".clear_string($type)."'AND brand='".clear_string($cat)."'";

			break;
		}
	}
	else {

			$cat_name = 'Все товары';
			$url = "";
			$cat = "";
	}


	$action = $_GET["action"];
	if (isset($action))
	{
		$id = (int)$_GET["id"];
		switch ($action) {

			case 'delete' :

				$delete = mysql_query("DELETE FROM table_products WHERE product_id = '$id' ",$link);

			break;
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link href="css/style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>
	<script></script>
	<title>Панель управления</title>
</head>
<body>
	<div id="block-body">
		<?php
			include('include/block-header.php');

			$all_count = mysql_query("SELECT * FROM table_products",$link);
			$all_count_result = mysql_num_rows($all_count);
		?>
	<div id="block-content">
		<div id="block-parametrs">
			<ul id="options-list">
				<li>Товары</li>
				<li><a href="#" id="select-links"><?php echo $cat_name; ?></a></li>
				<div id="list-links">
					<ul>
						<li><a href="tovar.php?ct=all"><strong>Все товары</strong></a></li>
						<li><a href="tovar.php?ct=all"><strong>Продукты</strong></a></li>
						<?php 
							$result1 = mysql_query("SELECT * FROM category WHERE type='food'", $link);
							if (mysql_num_rows($result1) > 0)
							{
								$row1 = mysql_fetch_array($result1);
								do 
								{
									echo '
										<li><a href="tovar.php?type='.$row1["type"].'&cat='.$row1["brand"].'">'.$row1["brand"].'</a></li>
									';
								} while ($row1 = mysql_fetch_array($result1));
							}
						?>
					</ul>
					<ul>
						<li><a href="tovar.php?ct=all"><strong>Напитки</strong></a></li>
						<?php 
							$result1 = mysql_query("SELECT * FROM category WHERE type='drink'", $link);
							if (mysql_num_rows($result1) > 0)
							{
								$row1 = mysql_fetch_array($result1);
								do 
								{
									echo '
										<li><a href="tovar.php?type='.$row1["type"].'&cat='.$row1["brand"].'">'.$row1["brand"].'</a></li>
									';
								} while ($row1 = mysql_fetch_array($result1));
							}
						?>
					</ul>
					<ul>
						<li><a href="tovar.php?ct=all"><strong>Прочее</strong></a></li>
						<?php 
							$result1 = mysql_query("SELECT * FROM category WHERE type='all'", $link);
							if (mysql_num_rows($result1) > 0)
							{
								$row1 = mysql_fetch_array($result1);
								do 
								{
									echo '
										<li><a href="tovar.php?type='.$row1["type"].'&cat='.$row1["brand"].'">'.$row1["brand"].'</a></li>
									';
								} while ($row1 = mysql_fetch_array($result1));
							}
						?>
					</ul>
				</div>
			</ul>
		</div>
		<div id="block-info">
			<p id="count-style">Всего товаров - <strong><?php echo $all_count_result; ?></strong></p>
			<p align="right" id="add-style"><a href="add_product.php">Добавить товар</a></p>
		</div>
		<ul id="block-tovar">
			<?php 
				$num = 9;

				$page = (int)$_GET['page'];
				$count = mysql_query("SELECT COUNT(*) FROM table_products $cat",$link);
				$temp = mysql_fetch_array($count);
				$post = $temp[0];
				//поиск общего числа страниц
				$total = (($post - 1) / $num) + 1;
				$total = intval($total);
				//определение начала сообщений для текущей страницы
				$page = intval($page);
				//если значение $page меньше единицы или отрицательно
				//переходим на первую страницу
				//а если слишком больше, то на последнюю
				if (empty($page) or $page < 0) $page = 1;
				if ($page > $total) $page = $total;
				//вычисляем начиная с какого номера
				//следует выводить сообщения
				$start = $page * $num - $num;

				if ($temp[0] > 0) 
				{
				$result = mysql_query("SELECT * FROM table_products $cat ORDER BY product_id DESC LIMIT $start, $num",$link);

				if (mysql_num_rows($result) > 0)
				{
					$row = mysql_fetch_array($result);
					do
					{
						if (strlen($row["image"]) > 0 && file_exists("../uploads_images/".$row.["image"]))
						{
							$img_path = "../uploads_images/".$row["image"];
							$max_width = 160;
							$max_height = 160;
							list($width, $height) = getimagesize($img_path);
							$ratioh = $max_height/$height;
							$ratiow = $max_width/$width;
							$ratio = min($ratioh, $ratiow);
							$width = intval($ratio*$width);
							$height = intval($ratio*$height);
						}else
						{
							$img_path = "../uploads_images/no-image.png";
							$width = 160;
							$height = 160;
						}

						echo' 
						<li>
							<p>'.$row["title"].'</p>
							<center>
								<img src="'.$img_path.'" width="'.$width.'" height="'.$height.'">
							</center>
							<p align="center" class="link-action">
							<a class="green" href="edit_product.php?id='.$row["product_id"].'">Изменить</a> | <a rel="tovar.php?'.$url.'id='.$row["product_id"].'&action="delete" class="delete">Удалить</a>
							<p/>
						</li>
						';
						}	while ($row = mysql_fetch_array($result));

						echo '
							</ul>
						';
					}
				}
				if ($page != 1) $pervpage = '<li><a class="pstr-prev" href="tovar.php?'.$url.'page='. ($page - 1) .'">Назад</a></li>';
				if ($page != $total) $nextpage = '<li><a class="pstr-next" href="tovar.php?'.$url.'page='. ($page + 1) .'">Вперед</a></li>';


				if ($page - 5 > 0) $page5left = '<li><a href=tovar.php?'.$url.'page='.($page - 5).'>'.$page.'</a></li>';
				if ($page - 4 > 0) $page4left = '<li><a href=tovar.php?'.$url.'page='.($page - 4).'>'.$page.'</a></li>';
				if ($page - 3 > 0) $page3left = '<li><a href=tovar.php?'.$url.'page='.($page - 3).'>'.$page.'</a></li>';
				if ($page - 2 > 0) $page2left = '<li><a href=tovar.php?'.$url.'page='.($page - 2).'>'.$page.'</a></li>';
				if ($page - 1 > 0) $page1left = '<li><a href=tovar.php?'.$url.'page='.($page - 1).'>'.$page.'</a></li>';



				if ($page + 5 <= 0) $page5left = '<li><a href=tovar.php?'.$url.'page='.($page + 5).'>'.$page.'</a></li>';
				if ($page + 4 <= 0) $page4left = '<li><a href=tovar.php?'.$url.'page='.($page + 4).'>'.$page.'</a></li>';
				if ($page + 3 <= 0) $page3left = '<li><a href=tovar.php?'.$url.'page='.($page + 3).'>'.$page.'</a></li>';
				if ($page + 2 <= 0) $page2left = '<li><a href=tovar.php?'.$url.'page='.($page + 2).'>'.$page.'</a></li>';
				if ($page + 1 <= 0) $page1left = '<li><a href=tovar.php?'.$url.'page='.($page + 1).'>'.$page.'</a></li>';

				if($page + 5 < $total)
				{
					$strtotal = '<li><p class="nav-point">...</p></li><li><a href="tovar.php?'.$url.'page='.$total.'"></a></li>';
				}
				else {
					$strtotal = "";
				}
			?>
			<div id="footerfix"></div>
			<?php 
				if ($total > 1)
				{
					echo '
						<center>
							<div class="pstrnav">
								<ul>
								';
								echo $pervpage.$page5left.$page4left.$page3left.$page2left.$page1left."<li><a class='pstr-active'></a></li>";
								echo '
								</ul>
							</div>
						</center>
					';
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