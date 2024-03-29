<?php 
	define('myeshop', true);
    include("include/db_connect.php"); 
    include("function/functions.php");
    session_start(); 
    include("include/auth_cookie.php");
    $cat = clear_string($_GET["cat"]);
    $type = clear_string($_GET["type"]);

	$sorting = $_GET["sort"];
	switch ($sorting) {
			case 'price-asc':
				$sorting = 'price ASC';
				$sort_name = 'От дешевых к дорогим';
			break;
			case 'price-desc':
				$sorting = 'price DESC';
				$sort_name = 'От дорогих к дешевым';
			break;
			case 'popular':
				$sorting = 'count DESC';
				$sort_name = 'Популярные';
			break;
			case 'news':
				$sorting = 'datetime DESC';
				$sort_name = 'Новинки';
			break;
			case 'brand':
				$sorting = 'brand';
				$sort_name = 'Бренд';
			break;
		
			default:
				$sorting = 'product_id DESC';
				$sort_name = 'Нет сортировки';
			break;
	}
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link href="css/style.css" rel="stylesheet" type="text/css">
    <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
	<script type="text/javascript" src="js/jquery.jcarousel.min.js"></script>
	<script type="text/javascript" src="js/shop-script.js"></script>
	<script type="text/javascript" src="js/jquery.cookie.js"></script>
	<title>Интернет-магазин "Градус"</title>
</head>
<body>
	
<div id="block-body">
	
<?php
	include('include/block-header.php');
?>

<div id="block-right">
	<?php
		include('include/block-category.php');
		include('include/block-parametr.php');
		include('include/block-news.php');
	?>
</div>

<div id="block-content">
	<?php

	
 if (!empty($cat) && !empty($type)) 
 {
  
     $querycat = "AND brand='$cat' AND type_tovara='$type'";
     $catlink = "cat=$cat&"; 
    
 }else
 {
    
    if (!empty($type))
    {
       $querycat = "AND type_tovara='$type'"; 
    }else
    {
       $querycat = ""; 
    }
   
       if (!empty($cat))
    {
       $catlink = "cat=$cat&"; 
    }else
    {
       $catlink = ""; 
    } 
    
      
 }  

	$num = 6; // Çäåñü óêàçûâàåì ñêîëüêî õîòèì âûâîäèòü òîâàðîâ.
    $page = (int)$_GET['page'];              
    
	$count = mysql_query("SELECT COUNT(*) FROM table_products WHERE visible = '1' $querycat",$link);
    $temp = mysql_fetch_array($count);

	If ($temp[0] > 0)
	{  
	$tempcount = $temp[0];

	// Íàõîäèì îáùåå ÷èñëî ñòðàíèö
	$total = (($tempcount - 1) / $num) + 1;
	$total =  intval($total);

	$page = intval($page);

	if(empty($page) or $page < 0) $page = 1;  
       
	if($page > $total) $page = $total;
	 
	// Âû÷èñëÿåì íà÷èíàÿ ñ êàêîãî íîìåðà
    // ñëåäóåò âûâîäèòü òîâàðû 
	$start = $page * $num - $num;

	$qury_start_num = " LIMIT $start, $num"; 
	}    
    
    
  $result = mysql_query("SELECT * FROM table_products WHERE visible='1' $querycat ORDER BY $sorting $qury_start_num",$link);  

if (mysql_num_rows($result) > 0)
{
 $row = mysql_fetch_array($result); 
 
 echo '
 <div id="block-sorting">
<p id="nav-breadcrumbs"><a href="index.php" >Ãëàâíàÿ ñòðàíèöà</a> \ <span>Âñå òîâàðû</span></p>
<ul id="options-list">
<li>Âèä: </li>
<li><img id="style-grid" src="/images/icon-grid.png" /></li>
<li><img id="style-list" src="/images/icon-list.png" /></li>
<li>Ñîðòèðîâàòü:</li>
<li><a id="select-sort">'.$sort_name.'</a>
<ul id="sorting-list">
<li><a href="view_cat.php?'.$catlink.'type='.$type.'&sort=price-asc" >Îò äåøåâûõ ê äîðîãèì</a></li>
<li><a href="view_cat.php?'.$catlink.'type='.$type.'&sort=price-desc" >Îò äîðîãèõ ê äåøåâûì</a></li>
<li><a href="view_cat.php?'.$catlink.'type='.$type.'&sort=popular" >Ïîïóëÿðíîå</a></li>
<li><a href="view_cat.php?'.$catlink.'type='.$type.'&sort=news" >Íîâèíêè</a></li>
<li><a href="view_cat.php?'.$catlink.'type='.$type.'&sort=brand" >Îò À äî ß</a></li>
</ul>
</li>
</ul>
</div>

 <ul id="block-tovar-grid" >
 
 ';
 
 
 do
 {

if  ($row["image"] != "" && file_exists("./uploads_images/".$row["image"]))
{
$img_path = './uploads_images/'.$row["image"];
$max_width = 200; 
$max_height = 200; 
 list($width, $height) = getimagesize($img_path); 
$ratioh = $max_height/$height; 
$ratiow = $max_width/$width; 
$ratio = min($ratioh, $ratiow); 
$width = intval($ratio*$width); 
$height = intval($ratio*$height);    
}else
{
$img_path = "/images/no-image.png";
$width = 110;
$height = 200;
} 
  
  echo '
  
  <li>
  <div class="block-images-grid" >
  <img src="'.$img_path.'" width="'.$width.'" height="'.$height.'" />
  </div>
  <p class="style-title-grid" ><a href="" >'.$row["title"].'</a></p>
  <ul class="reviews-and-counts-grid">
  <li><img src="/images/eye-icon.png" /><p>0</p></li>
  <li><img src="/images/comment-icon.png" /><p>0</p></li>
  </ul>
  <a class="add-cart-style-grid" ></a>
  <p class="style-price-grid" ><strong>'.$row["price"].'</strong> ðóá.</p>
  <div class="mini-features" >
  '.$row["mini_features"].'
  </div>
  </li>
  
  ';
  
    
 }
    while ($row = mysql_fetch_array($result));
    


?>
	<div id="block-sorting">
		<p id="nav-breadcrumbs"><a href="index.php">Главная страница</a> / <span>Все товары</span></p>
		<ul id="option-list">
			<li>Вид:</li>
			<li><img id="style-grid" src="images/icon-grid.png" alt=""></li>
			<li><img id="style-list" src="images/icon-list.png" alt=""></li>
			<li>Сортировать:</li>
			<li><a id="select-sort" href=""><?php echo $sort_name ?></a>
				<ul id="sorting-list">
					<li><a href="index.php?sort=price-asc">От дешевых к дорогим</a></li>
					<li><a href="index.php?sort=price-desc">От дорогих к дешевым</a></li>
					<li><a href="index.php?sort=popular">Популярное</a></li>
					<li><a href="index.php?sort=new">Новинки</a></li>
					<li><a href="index.php?sort=brand">От А до Я</a></li>
				</ul>
			</li>
		</ul>
	</div>
	<!--Блочный вывод товаров-->
	<ul id="block-tovar-grid">
	<?php 
		$result = mysql_query("SELECT * FROM table_products WHERE visible='1'ORDER BY $sorting",$link);
		if (mysql_num_rows($result) > 0){
			$row = mysql_fetch_array($result);
			do {

				if ($row["image"] !="" && file_exists("./uploads_images/".$row["image"]))
				{
					$img_path = './uploads_images/'.$row["image"];
					$max_width = 200;
					$max_height = 200;
					list($width, $height) =getimagesize($img_path);
					$ratioh = $max_height/$height;
					$ratiow = $max_width/$width;
					$ratio = min($ratioh, $ratiow);
					$width = intval($ratio*$width);
					$height = intval($ratio*$height);
				}else
				{
					$img_path = "../uploads_images/no-image.png";
					$width = 200;
					$height = 200;
				}

				echo 
				'<li>
					<div class="block-images-grid">
						<img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"/>
					</div>
					<p class="style-title-grid"><a href="">'.$row["title"].'</a></p>
					<ul class="revievs-and-counts-grid">
						<li><img src="images/eye.png"/><p>0</p></li>
						<li><img src="images/comment.png"/><p>0</p></li>
					</ul>
					<a href="" class="add-cart-style-grid">купить</a>
					<p class="style-price-grid"><strong>'.$row["price"].'</strong>руб</p>
					<div class="mini-features">'.$row["mini_features"].'</div>
				</li>';
			}
			while ( $row = mysql_fetch_array($result));
		}
	 ?>
	 </ul>
	<!--Блочный вывод товаров-->

	<!--Строчный вывод товаров-->
	<ul id="block-tovar-list">
	<?php 
		$result = mysql_query("SELECT * FROM table_products WHERE visible='1' ORDER BY $sorting",$link);
		if (mysql_num_rows($result) > 0){
			$row = mysql_fetch_array($result);
			do {

				if ($row["image"] !="" && file_exists("./uploads_images/".$row["image"]))
				{
					$img_path = './uploads_images/'.$row["image"];
					$max_width = 150;
					$max_height = 150;
					list($width, $height) =getimagesize($img_path);
					$ratioh = $max_height/$height;
					$ratiow = $max_width/$width;
					$ratio = min($ratioh, $ratiow);
					$width = intval($ratio*$width);
					$height = intval($ratio*$height);
				}else
				{
					$img_path = "/images/no-image.png";
					$width = 150;
					$height = 150;
				}

				echo 
				'<li>
					<div class="block-images-list">
						<img src="'.$img_path.'" width="'.$width.'" height="'.$height.'"/>
					</div>

					<ul class="revievs-and-counts-list">
						<li><img src="images/eye.png"/><p>0</p></li>
						<li><img src="images/comment.png"/><p>0</p></li>
					</ul>

					<p class="style-title-list"><a href="">'.$row["title"].'</a></p>

					<a href="" class="add-cart-style-list">купить</a>
					<p class="style-price-list"><strong>'.$row["price"].'</strong>руб</p>
					<div class="style-text-list">'.$row["mini_description"].'</div>
				</li>';
			}
			while ( $row = mysql_fetch_array($result));
		}
	 ?>
	 </ul>
	<!--Строчный вывод товаров-->
</div>
<?php
	include('include/block-footer.php');
?>

</div>	

</body>
</html>