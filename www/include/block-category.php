<div id="block-category">
	<p class="header-title">Категории товаров</p>
	<ul>
		<li><img src="images/meal.png" alt="" class="category-img"><a href="">Напитки</a>
			<ul class="category-section">
				<?php 
					$result = mysql_query("SELECT * FROM category WHERE type='food'",$link);
					if (mysql_num_rows($result) > 0)
					{
					$row = mysql_fetch_array($result);
					do 
					{
						echo '
							<li><a href="viev_cat.php?cat='.strtolower($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a></li>
						';
					}
						while ( $row = mysql_fetch_array($result));
					}
			 	?>
			</ul>
		</li>
		<li><img src="images/napitok.png" alt="" class="category-img"><a href="">Продукты</a>
			<ul class="category-section">
				<?php 
					$result = mysql_query("SELECT * FROM category WHERE type='drink'",$link);
					if (mysql_num_rows($result) > 0)
					{
					$row = mysql_fetch_array($result);
					do 
					{
						echo '
							<li><a href="viev_cat.php?cat='.strtolower($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a></li>
						';
					}
						while ( $row = mysql_fetch_array($result));
					}
			 	?>
			</ul>
		</li>
		<li><img src="images/matches.png" alt="" class="category-img"><a href="">Прочее</a>
			<ul class="category-section">
				<?php 
					$result = mysql_query("SELECT * FROM category WHERE type='prochee'",$link);
					if (mysql_num_rows($result) > 0)
					{
					$row = mysql_fetch_array($result);
					do 
					{
						echo '
							<li><a href="viev_cat.php?cat='.strtolower($row["brand"]).'&type='.$row["type"].'">'.$row["brand"].'</a></li>
						';
					}
						while ( $row = mysql_fetch_array($result));
					}
			 	?>
			</ul>
		</li>
	</ul>
</div>