<?php 
	defined('myeshop') or die('Доступ запрещен!');
    
     $result1 = mysql_query("SELECT * FROM orders WHERE order_confirmed='no'",$link);
    $count1 = mysql_num_rows($result1);
    
    if ($count1 > 0) { $count_str1 = '<p>+'.$count1.'</p>'; } else { $count_str1 = ''; }
 
?>
<div id="block-header">
	<div id="block-header1">
		<h3>Sweet-CMS - Панель управления</h3>
		<p id="link-nav"><?php echo $_SESSION['urlpage']; ?></p>
	</div>
	<div id="block-header2">
		<p align="right"><a href="add_administrators.php">Администраторы</a> | <a href="?logout">Выход</a></p>
		<p align="right">Вы - <span>Администратор</span></p>
	</div>
</div>

<div id="left-nav">
	<ul>
		<li><a href="orders.php">Заказы</a><?php echo $count_str1; ?></li>
		<li><a href="tovar.php">Товары</a></li>
		<li><a href="category.php">Категории</a></li>
		<li><a href="clients.php">Клиенты</a></li>
		<li><a href="news.php">Новости</a></li>
	</ul>
</div>
