<?php
	$db_host			= 'localhost';
	$db_user			= 'admin';
	$db_pass			= '11111';
	$db_database		= 'db_shop';

	$link = mysql_connect ($db_host,$db_user,$db_pass);

	mysql_select_db ($db_database,$link) or die("Нет соединения с Базой Данных" .mysql_error());
	mysql_query("SET names UTF-8");
?>