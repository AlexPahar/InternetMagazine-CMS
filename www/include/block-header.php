<div id="block-header">
	<div id="header-top-block">
		<ul id="header-top-menu">
			<li><a href="o-nas.php">О нас</a></li>
			<li><a href="shops.php">Магазины</a></li>
			<li><a href="contacts.php">Контакты</a></li>
		</ul>

<?php

if ($_SESSION['auth'] == true)
{
 
 echo '<p id="auth-user-info" align="right"><img src="images/user.png" />Здравствуйте, '.$_SESSION['auth_name'].'!</p>';   
    
}else{
 
  echo '<p id="reg-auth-title" align="right"><a class="top-auth">Вход</a><a href="registration.php">Регистрация</a></p>';   
    
}
	
?>
		

<div id="block-top-auth">

<div class="corner"></div>

<form method="post">


<ul id="input-email-pass">

<h3>Вход</h3>

<p id="message-auth">Неверный логин (и)или пароль!</p>

<li><center><input type="text" id="auth_login" placeholder="Логин или E-mail" /></center></li>
<li><center><input type="password" id="auth_pass" placeholder="Пароль" /><span id="button-pass-show-hide" class="pass-show"></span></center></li>

<ul id="list-auth">
<li><input type="checkbox" name="rememberme" id="rememberme" /><label for="rememberme">Запомнить меня</label></li>
<li><a id="remindpass" href="#">Забыли пароль?</a></li>
</ul>


<p align="right" id="button-auth" ><a>Вход</a></p>
<p align="right" class="auth-loading"><img src="images/loading.gif" /></p>

</ul>
</form>


<div id="block-remind">
<h3><br /> Пароль</h3>
<p id="message-remind" class="message-remind-success" ></p>
<center><input type="text" id="remind-email" placeholder="Âàø E-mail" /></center>
<p align="right" id="button-remind" ><a>Пароль</a></p>
<p align="right" class="auth-loading" ><img src="images/loading.gif" /></p>
<p id="prev-auth">Пароль</p>
</div>



</div>

	</div>
	<div id="top-line"></div>

	<div id="block-user" >
		<div class="corner2"></div>
		<ul>
			<li><img src="images/user_info.png" /><a href="profile.php">Профиль</a></li>
			<li><img src="images/logout.png" /><a id="logout" >Выход</a></li>
		</ul>
	</div>

	<img id="img-logo" src="images/test-logo.png">
	<div id="personal-info">
		<p id="title-one" align="right">Звоните!</p>
		<h3 align="right">8 961 234 11 24</h3>
		<img id="phone-icon" src="images/phone.png">

		<p id="title-one" align="right">Режим работы:</p>
		<p align="right">Будние дни: с 9:00 до 00:00</p>
		<p align="right">Суббота,воскресенье: с 9:00 до 02:00</p>
		<img id="time" src="images/time.png">
	</div>
	<div id="block-search">
		<form method="GET" action="search.php?q=">
			<input type="text" id="input-search" name="q" placeholder="Поиск товаров...">
			<input type="submit" id="button-search" value="Поиск">		
		</form>
	</div>
</div>
<div id="top-menu">
	<ul>
		<li><img src="images/shop.png"><a href="index.php">Главная</a></li>
		<li><img src="images/new.png"><a href="new.php">Новинки</a></li>
		<li><img src="images/lider.png"><a href="lider.php">Лидеры продаж</a></li>
		<li><img src="images/sale.png"><a href="sale.php">Распродажа</a></li>
	</ul>
	<p align="right" id="cart-block"><img src="images/cart.png" id="cart-img"><a href="cart.php?action=onclick">Корзина</a></p>
</div>

	<div id="top-line"></div>