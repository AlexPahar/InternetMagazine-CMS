<?php 
	session_start();

	if ($_SESSION['auth_admin'] == "yes_auth") {

		define('myeshop', true);

		if (isset($_GET["logout"]))
		{
			unset($_SESSION['auth_admin']);
			header("Location: login.php");
		}
	$_SESSION['urlpage'] = "<a href='index.php'>Главная</a>";
	include("include/db_connect.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<link href="css/style.css" rel="stylesheet" type="text/css">
	<title>Панель управления</title>
</head>
<body>
	<div id="block-body">
		<?php
			include('include/block-header.php');
    
		 $query1 = mysql_query("SELECT * FROM orders",$link);
		 $result1 = mysql_num_rows($query1);
		 $query2 = mysql_query("SELECT * FROM table_products",$link);
		 $result2 = mysql_num_rows($query2);   
		 $query4 = mysql_query("SELECT * FROM reg_user",$link);
		 $result4 = mysql_num_rows($query4);
		?>
	<div id="block-content">
		<div id="block-parametrs">
			<p id="title-page">Общая статистика</p>
		</div>
		<ul id="general-statistics">
<li><p>Всего заказов - <span><?php echo $result1; ?></span></p></li>
<li><p>Товары - <span><?php echo $result2; ?></span></p></li>
<li><p>Клиенты - <span><?php echo $result4; ?></span></p></li>
</ul>

<h3 id="title-statistics">Статистика продаж</h3>

<TABLE align="center" CELLPADDING="10" WIDTH="100%">
<TR>
<TH>Дата</TH>
<TH>Товар</TH>
<TH>Цена</TH>
<TH>Статус</TH>
</TR>


<?php

$result = mysql_query("SELECT * FROM orders,buy_products WHERE orders.order_pay='accepted' AND orders.order_id=buy_products.buy_id_order",$link);
 
$row = mysql_fetch_array($result);
do
{

 $result2 = mysql_query("SELECT * FROM table_products WHERE product_id='{$row["buy_id_product"]}'",$link);   
  if (mysql_num_rows($result2) > 0)
{
 $row2 = mysql_fetch_array($result2);
}
    
$statuspay = "";
if ($row["order_pay"] == "accepted") $statuspay = "Оплачено";

echo '
 <TR>
<TD  align="CENTER" >'.$row["order_datetime"].'</TD>
<TD  align="CENTER" >'.$row2["title"].'</TD>
<TD  align="CENTER" >'.$row2["price"].'</TD>
<TD  align="CENTER" >'.$statuspay.'</TD>
</TR>
';

	}
     while ($row = mysql_fetch_array($result));
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