<div id="block-parametr">
	<p class="header-title">Поиск по параметрам</p>
	<p class="title-filter">Стоимость</p>
	<form action="search-filter.php" method="GET">
		<div id="block-input-price">
			<ul>
				<li><p>от</p></li>
				<li><input type="text" id="start-price" name="start_price" value="50"></li>
				<li><p>до</p></li>
				<li><input type="text" id="end-price" name="end_price" value="5000"></li>
				<li><p>руб.</p></li>
			</ul>
		</div>
		<div id="blocktreckbar"></div>
		<p class="title-filter">Производители</p>
		<ul class="checkbox-brand">
			<li><input type="checkbox" id="checkbrand1"><label for="checkbrand1">Волчиха</label></li>
			<li><input type="checkbox" id="checkbrand2"><label for="checkbrand2">Барнаул</label></li>
			<li><input type="checkbox" id="checkbrand3"><label for="checkbrand3">Москва</label></li>
		</ul>
		<center><input type="submit" name="submit" id="button-param-search" value="Найти"></center>
	</form>
</div>