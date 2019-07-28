<?php 
	ob_start();
	session_start();
	$pageTitle = 'Show Products';
	include 'init.php'; 

	// Chek If Get Request item Is Numiric & Get The Integer Value Of It 
	$itemid =  isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

	// Select All Data Depend On This ID
	$stmt = $con->prepare("SELECT 
								items.*, 
								categories.Name AS category_name,
								users.Username
						   FROM 
						   		items
						   INNER JOIN 
						   		categories
						   	ON 
						   		categories.ID = items.Cat_ID 
						   	INNER JOIN 
						   		users 
						   	ON    
						   		users.UserID = items.Member_ID		
						   WHERE 
						   		Item_ID = ?
						   AND
						   		Approve = 1");

	// Execute Query  
	$stmt->execute(array($itemid));

	$count = $stmt->rowCount();

	if ($count > 0) {
 
	// Fetch The Data
	$item = $stmt->fetch();	

?>
<br><br><br>
<div class="container">
	<div class="row">
		<div class="col-md-4 col-sm-6 product-img-box">
			<?php
				if (empty($item['avatar'])) {
					echo "No Image";
				} else {
					echo "<img class='img-responsive product-img' src='uploads/product_img/" . $item['avatar'] .  "' alt='' />";
				}
			?>
		</div>
		<div class="col-md-8 col-sm-6 item-info">
			<h2><?php echo $item['Name'] ?></h2>
			<p><?php echo $item['Description'] ?></p>
			<ul class="list-unstyled">
				<li>
					<i class="fa fa-calendar fa-fw"></i>
					<span>Added Date</span> : <?php echo $item['Add_Date'] ?>
				</li>
				<li>
					<i class="fa fa-money fa-fw"></i>
					<span>Price</span> : $<?php echo $item['Price'] ?>
				</li>
				<li>
					<i class="fa fa-count fa-fw"></i>
					<span>Quantity</span> : <?php 
						if ($item['Quantity'] == 0){
							echo 'This Product is not avaliable';
						} else {
							echo $item['Quantity'];
						}
						 
					?>
				</li>
				<li>
					<i class="fa fa-building fa-fw"></i>
					<span>Made In</span> : <?php echo $item['Country_Made'] ?>
				</li>
				<li>
					<i class="fa fa-tags fa-fw"></i>
					<span>Category</span> : <a href="categories.php?pageid=<?php echo $item['Cat_ID'] ?>"><?php echo $item['category_name'] ?></a>
				</li>
				<li>
					<i class="fa fa-user fa-fw"></i>
					<span>Added By</span> : <a href="#"><?php echo $item['Username'] ?></a>
				</li>
						
			</ul>
		</div>
	</div>

	<hr class="custom-hr">
		
</div>

<?php
	} else {
		echo '<div class="container">';
			echo "<div class='alert alert-danger'>There's no Such ID Or This Item Waiting Approval</div>";
		echo '</div>';	
	}
	include $tpl . 'footer.php'; 
	ob_end_flush();
?>		
