<?php 
	session_start();
	include 'init.php'; 

	$sort ='asc';

	$sort_array = array('asc', 'desc');

	if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {

		$sort = $_GET['sort'];

	}

	$stmt2 = $con->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY Ordering $sort");

	$stmt2->execute();

	$cats = $stmt2->fetchAll();


?>
<br><br><br>
<div class="container">
	<div class="row">
		<div class="col-md-3 col-md-4">
			<ul id="sideManu" class="nav nav-tabs nav-stacked">
			<li class="list-group-item text-center active lead">						
			    Categories
		    </li>

			<?php
				foreach($cats as $cat) {
					echo '<li class="subMenu open"> <a>'. $cat['Name'] .'<span class="glyphicon glyphicon-triangle-bottom pull-right"></span></a> ';

					// Get Child Categories
					$childCats = getAllFrom("*", "categories", "where parent = {$cat['ID']}", "", "ID", "ASC");
					if (! empty($childCats)) {

						echo "<ul>";
							foreach ($childCats as $c) {
								echo "<li class='child-link'>
										<a href='categories.php?pageid=" .$c['ID'] . "'><i class='icon-chevron-right'></i>" .$c['Name'] . "</a>
									</li>";
							} 
						echo "</ul>";
					}
					echo '</li>';										
				}
			?>
			</ul>
		</div>
		<div class="col-md-9 col-sm-8">
			<div class="row">
				<?php 
					// $category =  isset($_GET['pageid']) && is_numeric($_GET['pageid']) ? intval($_GET['pageid']) : 0;
					if (isset($_GET['pageid']) && is_numeric($_GET['pageid'])) {
						$category = intval($_GET['pageid']);
						$allItems = getAllFrom("*", "items", "where Cat_ID = {$category}", "AND Approve = 1", "Item_ID");
						foreach ($allItems as $item) {
							echo '<div class="col-sm-6 col-md-4">';
								echo '<div class="thumbnail item-box">';
									echo '<span class="price-tag">$' . $item['Price'] . '</span>';
									echo "<img class='img-responsive product-img' src='uploads/product_img/" . $item['avatar'] .  "' alt='' />";
									echo '<div class="caption">';
										echo '<h3><a href="items.php?itemid=' . $item['Item_ID'] . '">' . $item['Name'] . '</a></h3>';
										echo '<p>' . substr($item['Description'], 0, 55) . '...</p>';
										echo '<div class="date">' . $item['Add_Date'] . '</div>';
									echo '</div>';
								echo '</div>';
							echo '</div>';
						}
					} else {
						echo "<di class='alert alert-danger'>You Must Add Page ID</div>";
					}
				?>
			</div>
		</div>
	</div>
	
</div>

<?php include $tpl . 'footer.php'; ?>		
