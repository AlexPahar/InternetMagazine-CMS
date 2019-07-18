<?php 
	session_start();

	if ($_SESSION['auth_admin'] == "yes_auth") {

		define('myeshop', true);

		if (isset($_GET["logout"]))
		{
			unset($_SESSION['auth_admin']);
			header("Location: login.php");
		}
	$_SESSION['urlpage'] = "<a href='index.php'>Главная</a> / <a href='clients.php'>Клиенты</a>";
	include("include/db_connect.php");
	//include("include/functions.php");

	//$id = $clear_string($_GET["id"]);
	//$action = $_GET["action"];
	//if (isset($action)) 
	//{
	//	switch ($action) {
	//		case 'delete':
	//			$delete = mysql_query("DELETE FROM reg_user WHERE id = '$id'", $link);
	//		break;
	//	}
	//}


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
	<title>Панель управления - Клиенты</title>
</head>
<body>
	<div id="block-body">
		<?php
			include('include/block-header.php');
			$all_client = mysql_query("SELECT * FROM reg_user" , $link);
			$result_count = mysql_num_rows($all_client);
		?>
	<div id="block-content">
		<div id="block-parametrs">
			<p id="title-page">Клиенты - <strong><?php echo $result_count;?> </strong></p>
		</div>

		<?php 
				$num = 10;

				$page = (int)$_GET['page'];
				$page = mysql_real_escape_string($page);
				$count = mysql_query("SELECT COUNT(*) FROM reg_user",$link);
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

				{
				$result = mysql_query("SELECT * FROM reg_user $cat ORDER BY id DESC LIMIT $start, $num",$link);

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
						<div class="block-clients">
							<p class="client-datetime">'.$row["datetime"].'</p>
							<p class="client-email"><strong>'.$row["email"].'</strong></p>
							<p class="client-links"><a class="delete" rel="clients.php?id='.$row["id"].'&action=delete">Удалить</a></p>

							<ul>
							<li><strong>E-Mail</strong> - '.$row["email"].'</li>
							<li><strong>ФИО</strong> - '.$row["surname"].' '.$row["name"].' '.$row["patronymic"].'</li>
							<li><strong>Адрес</strong> - '.$row["address"].'</li>
							<li><strong>Телефон</strong> - '.$row["phone"].'</li>
							<li><strong>IP</strong> - '.$row["ip"].'</li>
							<li><strong>Дата регистрации</strong> - '.$row["datetime"].'</li>
							</ul>
						</div>
						';
						}	while ($row = mysql_fetch_array($result));
					}
				}
				if ($page != 1) $pervpage = '<li><span><a class="pstr-prev" href="clients.php?page='. ($page - 1) .'">Назад</a></span></li>';
				if ($page != $total) $nextpage = '<li><a class="pstr-next" href="clients.php?page='. ($page + 1) .'">Вперед</a></li>';


				if ($page - 5 > 0) $page5left = '<li><a href=clients.php?page='.($page - 5).'>'.($page - 5).'</a></li>';
				if ($page - 4 > 0) $page4left = '<li><a href=clients.php?page='.($page - 4).'>'.($page - 4).'</a></li>';
				if ($page - 3 > 0) $page3left = '<li><a href=clients.php?page='.($page - 3).'>'.($page - 3).'</a></li>';
				if ($page - 2 > 0) $page2left = '<li><a href=clients.php?page='.($page - 2).'>'.($page - 2).'</a></li>';
				if ($page - 1 > 0) $page1left = '<li><a href=clients.php?page='.($page - 1).'>'.($page - 1).'</a></li>';



				if ($page + 5 <= $total) $page5left = '<li><a href=clients.php?page='.($page + 5).'>'.($page - 5).'</a></li>';
				if ($page + 4 <= $total) $page4left = '<li><a href=clients.php?page='.($page + 4).'>'.($page - 4).'</a></li>';
				if ($page + 3 <= $total) $page3left = '<li><a href=clients.php?page='.($page + 3).'>'.($page - 3).'</a></li>';
				if ($page + 2 <= $total) $page2left = '<li><a href=clients.php?page='.($page + 2).'>'.($page - 2).'</a></li>';
				if ($page + 1 <= $total) $page1left = '<li><a href=clients.php?page='.($page + 1).'>'.($page - 1).'</a></li>';

				if($page + 5 < $total)
				{
					$strtotal = '<li>...<a href="clients.php?page='.$total.'">'.$total.'</a></li>';
				}
				else {
					$strtotal = "";
				}
				if ($total > 1)
				{
					echo '
						<div id="block-pstrnav">
							<ul id="pstnav">
							'.$pervpage.$page5left.$page4left.$page3left.$page2left.$page1left.'<li><b>'.page.'</b></li>'.$nextpage.$page1right.$page2right.$page3right.$page4right.$page5right.';
							</ul>
						</div>
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