<?php 

	$stmt = $con->prepare("SELECT * from artcles");
	$stmt->execute();
	$items = $stmt->fetchAll();


	?>

			<div class="container ">
				<div class="panel panel-default">

					<div class="panel panel-heading text-center">
						<i class="fa fa-edit"></i> Manage Products
					</div>
					<div class="panel-body">

					<div class="">
						<div class="table-responsive">

							<table class="main-table text-center table table-bordered manage-items">
								<tr>
									<td>#ID</td>
									<td>Image</td>
									<td>Nmae</td>
									<td>Description  </td>
									<td>Price</td>
									<td>Adding Date</td>
									<td>Category</td>
									<td>Username</td>
									<td>Control</td>
								</tr>

								<?php

									foreach($items as $item) {
										echo "<tr>";
											echo "<td>" .$item['Item_ID'] . "</td>";
											echo "<td>";
												if (empty($item['avatar'])) {
													echo "No Image";
												} else {
													echo "<img src='../uploads/product_img/" . $item['avatar'] .  "' alt='' />";
												}
											echo "</td>";
											echo "<td>" .$item['Name'] . "</td>";
											echo "<td>" .$item['Description'] . "</td>";
											echo "<td>" .$item['Price'] . "</td>";
											echo "<td>" .$item['Add_Date'] . "</td>";
											echo "<td>" .$item['category_name'] . "</td>";
											echo "<td>" .$item['Username'] . "</td>";
											echo "<td>
												<a href='items.php?do=Edit&itemid=" . $item['Item_ID'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>	
												<a href='items.php?do=Delete&itemid=" . $item['Item_ID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";	
											 	if ($item['Approve'] == 0){

													echo "<a 
															href='items.php?do=Approve&itemid=" .$item['Item_ID'] . "' 
															class='btn btn-info activate'>
															<i class='fa fa-check'></i> Approve</a>";	
											 	}
										 	echo "</td>";
										echo "</tr>";
									}

								?>					
							</table>
						</div>
						</div>
					</div>
				</div>
						<a href="items.php?do=Add" class="btn btn-sm btn-primary">
							<i class="fa fa-plus"></i> New Product
						</a>
					</div>	
					<br><br><br>
					<?php } else {

						echo '<div class="container">';
							echo"<div class='nice-message'>There's No Product to show</div>";
							echo '<a href="items.php?do=Add" class="btn btn-sm btn-primary">
									<i class="fa fa-plus"></i> New Item
								</a>';					
						echo "</div>";	
					} ?>

			<?php


 ?>