<?php

	/*
	================================================
	== Items Page 
	================================================
	*/
	ob_start(); // Output Buffering Start

	session_start();

	$pageTitle= 'Items';

		if (isset($_SESSION['Username'])) {

			include 'init.php';

			$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';
		
			if ($do == 'Manage') { 


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
									ORDER BY
										Item_ID DESC");
			// Execute The Statement

			$stmt->execute();

			// Assing To Variable

				$items = $stmt->fetchAll();

				if(! empty($items)) {

			?>

				<br><br>
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

			} elseif ($do == 'Add') { ?>

					<br><br><br>

				<div class="create-ad block">
			<div class="container">
				<div class="panel panel-primary">
					<div class="panel-heading text-center">Add New Product</div>
					<div class="panel-body">
						 <div class="row">
				 	<div class="col-md-12">
						<form class="from-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
							<!-- Start Name Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Name</label>
								<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
									<input type="text" name="name" class="form-control" required="required"  placeholder="Name Of The Item">
								</div>
							</div>
							</div><br>
							<!-- End Name Field -->
							<!-- Start Description Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Description</label>
								<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
									<input type="text" name="description" class="form-control" required="required"  placeholder="Description Of The Item">
								</div>
							</div>
							</div><br>
							<!-- End Description Field -->
							<!-- Start Price Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Price</label>
								<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
									<input type="text" name="price" class="form-control" required="required"  placeholder="Price Of The Item">
								</div>
							</div>
							</div><br>
							<!-- End Price Field -->
							<!-- Start Quantity Field -->
							<div class="row">
								<div class="form-group form-group-sm">
									<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Quantity</label>
									<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
										<input 
											   type="text" 
										       name="quantity" 
										       class="form-control live" 
										       placeholder="Quantity Of The Product" 
										       required="required">
									</div>
								</div>
							</div><br>
							<!-- End Quantity Field -->
							<!-- Start Country Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Country</label>
								<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
									<input type="text" name="country" class="form-control" required="required"  placeholder="Country Of Made">
								</div>
							</div>
							</div><br>
							<!-- End Country Field -->
							<!-- Start Status Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Status</label>
								<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
									<select name="status">
										<option value="0">...</option>
										<option value="1">New</option>
										<option value="2">Like New</option>
										<option value="3">Used</option>
										<option value="4">Very Old</option>
									</select>
								</div>
							</div>
							</div><br>
							<!-- End Status Field -->
							<!-- Start Members Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Member</label>
								<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
									<select name="member">
										<option value="0">...</option>
										<?php 
											$allMembers = getAllFrom("*", "users", "", "", "UserID");
											foreach ($allMembers as $user) {
												echo "<option value='" . $user['UserID'] . "'>" . $user['Username'] . "</option>";
											}

										?>
									</select>
								</div>
							</div>
							</div><br>
							<!-- End Membres Field -->
							<!-- Start Categories Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Category</label>
								<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
									<select name="category">
										<option value="0">...</option>
										<?php 
											$allCats = getAllFrom("*", "categories", "where parent = 0", "", "ID");
											foreach ($allCats as $cat) {
												echo "<option disabled value='" . $cat['ID'] . "'>" . $cat['Name'] . "</option>";
												$childCats = getAllFrom("*", "categories", "where parent = {$cat['ID']}", "", "ID");
												foreach ($childCats as $child) {
													echo "<option value='" . $child['ID'] . "'>--- " . $child['Name'] . "</option>";
												}
											}

										?>
									</select>
								</div>
							</div>
							</div><br>
							<!-- End Categories Field -->

							<!-- Start Image Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Product Image</label>
								<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
									<input type="file" name="avatar" class="btn btn-default btn-sm" required="required" >
								</div>
							</div> 
							</div><br>
							<!-- End Image Field -->

							<!-- Start Tags Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Tags</label>
								<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
									<input type="text" name="tags" class="form-control"   placeholder="Separate Tags With Comma (,)">
								</div>
							</div>
							</div><br>
							<!-- End Tags Field -->							
							<!-- Start Submit Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<div class="col-sm-offset-2 col-sm-10">
									<input type="submit" value="Add Item" class="btn btn-primary btn-sm">
								</div>
							</div>
							</div>
							<!-- End Submit Field -->

						</form>
					</div>
					</div>
						</div>
				 	</div>
				 </div>
				</div>

				<?php

	  		} elseif ($do == 'Insert') {

	  			// Insert Member Page


			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				echo "<h1 class='text-center'>Insert Items</h1>";
				echo "<div class='container'>";

				// Upload Variables

				$avatarName = $_FILES['avatar']['name'];
				$avatarSize = $_FILES['avatar']['size'];
				$avatarTmp 	= $_FILES['avatar']['tmp_name'];
				$avatarType = $_FILES['avatar']['type']; 

				// List Of Allowed File Typed To Upload 

				$avatarAllowedExtension = array("jpeg", "jpg", "png", "gif");

				// Get Avatar Extension 

				$explode = explode('.', $avatarName);

				$avatarExtension = strtolower(end($explode));

				// Get Variables Form The Form 
				$name 		= $_POST['name'];
				$desc 		= $_POST['description'];
				$price 		= $_POST['price'];
				$quantity 	= $_POST['quantity'];
				$country 	= $_POST['country'];
				$status 	= $_POST['status'];
			 	$member 	= $_POST['member'];
				$cat 		= $_POST['category'];
				$tags 		= $_POST['tags'];

				// Validate The Form

					$formErrors = array();

					if (empty($name)) {

						$formErrors[] = "Name Can't Be <strong>Empty</strong>";
					}

					if (empty($desc)) {

						$formErrors[] = "Description Can't Be <strong>Empty</strong>";
					}

					if (empty($price)) {

						$formErrors[] = "Price Can't Be <strong>Empty</strong>";

					}

					if (empty($quantity)) {

						$formErrors[] = 'Quantity Must Be Not Empty';
					}

					if (empty($country)) {

						$formErrors[] = "Country Can't Be <strong>Empty</strong>";

					}					

					if ($status == 0) {

						$formErrors[] = "You Must Chose the <strong>Status</strong>";

					}

					if ($member == 0) {

						$formErrors[] = "You Must Chose the <strong>Memer</strong>";

					}

					if ($cat == 0) {

						$formErrors[] = "You Must Chose the <strong>Category</strong>";

					}

					if (! empty($avatarName) && ! in_array($avatarExtension, $avatarAllowedExtension)) {
						
						$formErrors[] = 'This Extension Is Not <strong>Allowed</strong>';

					}

					if (empty($avatarName)) {
						
						$formErrors[] = 'Avatar Is <strong>Required</strong>';

					}

					if ($avatarSize > 4194304) {
						
						$formErrors[] = "Avatar Cant't Be Larger Than <strong>4MB</strong>";

					}

				//	Loop Into Errors Array And Echo It
					foreach($formErrors as $error) {

						echo '<div class="alert alert-danger">' . $error . '</div>'; 
					}

				// Check If Ther's No Error Proced The Update Operation

					if (empty($formErrors)) {

							// Inesrt Userinfo In The Database

							$avatar = rand(0, 10000) . '_' .$avatarName;

							move_uploaded_file($avatarTmp, "../uploads/product_img/" . $avatar);

							$stmt = $con->prepare("INSERT INTO 
													items(Name, Description, Price, Quantity, Add_Date, Country_Made, Status, Cat_ID, avatar, Member_ID, tags)
												VALUES(:zname,:zdesc, :zprice, :zquantity :zcountry, :zstatus, now(), :zcat, :zavatar, :zmember, :ztags)");
      
							$stmt->execute(array(

								'zname' 	=> $name,
								'zdesc' 	=> $desc,
								'zprice' 	=> $price,
								'zquantity' => $quantity,
								'zcountry' 	=> $country,
								'zstatus' 	=> $status,
								'zcat' 		=> $cat,
								'zavatar' 	=> $avatar,
								'zmember' 	=> $member,								
								'ztags' 	=> $tags
							));		

							// Echo Success Message  
							$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . ' Product  Inserted</div>';

							redirectHome($theMsg, 'back');


					}
 
			} else {

				echo "<div class='container'>";

				$theMsg =  '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

				redirectHome($theMsg);

				echo "</div>";
			}

			echo "</div>";


	  		} elseif ($do == 'Edit') {

			// Chek If Get Request item Is Numiric & Get The Integer Value Of It 
			$itemid =  isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

			// Select All Data Depend On This ID
			$stmt = $con->prepare("SELECT * FROM items WHERE Item_ID = ?");

			// Execute Query 
			$stmt->execute(array($itemid));

			// Fetch The Data
			$item = $stmt->fetch();

			// The Row Count
			$count = $stmt->rowCount();

			// If There's Such ID Show The Form
			if ($stmt->rowCount() > 0) { ?>

					<br><br><br>

				<div class="create-ad block">
			<div class="container">
				<div class="panel panel-primary">
					<div class="panel-heading text-center">Edit Product</div>
					<div class="panel-body">
						 <div class="row">
				 	<div class="col-md-12">
						<form class="from-horizontal" action="?do=Update" method="POST">
							<input type="hidden" name="itemid" value="<?php echo $itemid ?>">
							<!-- Start Name Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Name</label>
								<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
									<input type="text" name="name" class="form-control" required="required"  placeholder="Name Of The Item" value="<?php echo $item['Name'] ?>">
								</div>
							</div>
							</div><br>
							<!-- End Name Field -->
							<!-- Start Description Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Description</label>
								<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
									<input type="text" name="description" class="form-control" required="required"  placeholder="Description Of The Item" value="<?php echo $item['Description'] ?>">
								</div>
							</div>
							</div><br>
							<!-- End Description Field -->
							<!-- Start Price Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Price</label>
								<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
									<input type="text" name="price" class="form-control" required="required"  placeholder="Price Of The Item" value="<?php echo $item['Price'] ?>">
								</div>
							</div>
							</div><br>
							<!-- End Price Field -->
							<!-- Start Country Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Country</label>
								<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
									<input type="text" name="country" class="form-control" required="required"  placeholder="Country Of Made" value="<?php echo $item['Country_Made'] ?>">
								</div>
							</div>
							</div><br>
							<!-- End Country Field -->
							<!-- Start Status Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Status</label>
								<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
									<select class="form-control"name="status">
										<option value="1" <?php if ($item['Status'] ==1) { echo 'selected'; } ?>>New</option>
										<option value="2" <?php if ($item['Status'] ==2) { echo 'selected'; } ?>>Like New</option>
										<option value="3" <?php if ($item['Status'] ==3) { echo 'selected'; } ?>>Used</option>
										<option value="4" <?php if ($item['Status'] ==4) { echo 'selected'; } ?>>Very Old</option>
									</select>
								</div>
							</div>
							</div><br>
							<!-- End Status Field -->
							<!-- Start Members Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Member</label>
								<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
									<select class="form-control"name="member">
										<option value="0">...</option>
										<?php 
											$stmt = $con->prepare("SELECT * FROM users");
											$stmt->execute(); 
											$users = $stmt->fetchAll();
											foreach ($users as $user) {
												echo "<option value='" . $user['UserID'] . "'"; 
												if ($item['Member_ID'] == $user['UserID']) { echo 'selected'; } 
												echo ">" . $user['Username'] . "</option>";
											}

										?>
									</select>
								</div>
							</div>
							</div><br>
							<!-- End Membres Field -->
							<!-- Start Categories Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Category</label>
								<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
									<select class="form-control"name="category">
										<option value="0">...</option>
										<?php 
											$stmt2 = $con->prepare("SELECT * FROM Categories where parent = 0");
											$stmt2->execute();
											$cats = $stmt2->fetchAll();
											foreach ($cats as $cat) {
												echo "<option disabled value='" . $cat['ID'] . "'";
												if ($item['Cat_ID'] == $cat['ID']) { echo 'selected'; }
												echo ">" . $cat['Name'] . "</option>";

												$childCats = getAllFrom("*", "categories", "where parent = {$cat['ID']}", "", "ID");
												foreach ($childCats as $child) {
													echo "<option value='" . $child['ID'] . "'--- ";
													if ($child['ID'] == $child['ID']) { echo 'selected'; }
													echo ">" . $child['Name'] . "</option>";
												}
											}

										?>
									</select>
								</div>
							</div>
							</div><br>
							<!-- End Categories Field -->
							<!-- Start Tags Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Tags</label>
								<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
									<input type="text" name="tags" class="form-control"   placeholder="Separate Tags With Comma (,)" value="<?php echo $item['tags'] ?>">
								</div>
							</div>
							</div><br>
							<!-- End Tags Field -->								
							<!-- Start Submit Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<div class="col-sm-offset-2 col-sm-10">
									<input type="submit" value="Save Item" class="btn btn-primary btn-sm">
								</div>
							</div>
							</div>
							<!-- End Submit Field -->

						</form>

						</div>
					</div>
						</div>
				 	</div>
				 </div>
				</div>
		<?php				

			// Select All Users Except Admin

			$stmt = $con->prepare("SELECT 
											comments.*, users.username AS Member 
										FROM 
											comments
										INNER JOIN 
											users
										ON
											users.UserID = comments.user_id
										WHERE item_id = ?");
			// Execute The Statement

			$stmt->execute(array($itemid));

			// Assing To Variable

			$rows = $stmt->fetchAll();

			if (! empty($row)) {

		?>

			<h1 class="text-center">Manager [ <?php echo $item['Name'] ?> ] Comments</h1>
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>Comment</td>
							<td>User Name</td>
							<td>Added Date</td>
							<td>Control</td>
						</tr>

						<?php 

							foreach($rows as $row) {
								echo "<tr>";
									echo "<td>" .$row['comment'] . "</td>";
									echo "<td>" .$row['Member'] . "</td>";
									echo "<td>" .$row['comment_date'] . "</td>";
									echo "<td>
										<a href='comments.php?do=Edit&comid=" .$row['c_id'] . "' 
										class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>	
										<a href='comments.php?do=Delete&comid=" .$row['c_id'] . "' 
										class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";	
								 	
								 	if ($row['status'] == 0){

										echo "<a href='comments.php?do=Approve&comid=" .$row['c_id'] . "' 
										class='btn btn-info activate'><i 
										class='fa fa-check'></i> Approve</a>";	
								 	}

								 	echo "</td>";
								echo "</tr>";
							}
						?>	
						<tr>				
					</table>
				</div>

			<?php }  ?>

			</div>

		<?php

			// If There's No Such ID Show Error Message 
			} else {

				echo "<div class='container>";

				$theMsg = '<div class="alert alert-danger">There No Product</div>';

				redirectHome($theMsg);

				echo "</div>";


			}	  			

			} elseif ($do == 'Update') { 

			echo "<h3 class='text-center'>Update Procuct</h3>";

			echo "<div class='container'>";


			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				// Get Variables Form The Form 
				$id 		= $_POST['itemid'];
				$name 		= $_POST['name'];
				$desc 		= $_POST['description'];  
				$price 		= $_POST['price'];
				$country 	= $_POST['country'];
				$status 	= $_POST['status'];
				$member 	= $_POST['member'];
				$cat 		= $_POST['category'];
				$tags 		= $_POST['tags'];

				// Validate The Form

					$formErrors = array();

					if (empty($name)) {

						$formErrors[] = "Name Can't Be <strong>Empty</strong>";
					}

					if (empty($desc)) {

						$formErrors[] = "Description Can't Be <strong>Empty</strong>";
					}

					if (empty($price)) {

						$formErrors[] = "Price Can't Be <strong>Empty</strong>";

					}

					if (empty($country)) {

						$formErrors[] = "Country Can't Be <strong>Empty</strong>";

					}					

					if ($status == 0) {

						$formErrors[] = 'You Must Chose the <strong>Status</strong>';

					}

					if ($member == 0) {

						$formErrors[] = 'You Must Chose the <strong>Memer</strong>';

					}

					if ($cat == 0) {

						$formErrors[] = 'You Must Chose the <strong>Category</strong>';

					}
				//	Loop Into Errors Array And Echo It
					foreach($formErrors as $error) {

						echo '<div class="alert alert-danger">' . $error . '</div>'; 
					}

				// Check If Ther's No Error Proced The Update Operation

					if (empty($formErrors)) {

						// Update The Database With This Info

				$stmt = $con->prepare("UPDATE 
											items 
										SET 
											Name = ?, 
											Description = ?, 
											Price = ?, 
											Country_Made = ?, 
											Status = ? ,
											Cat_ID = ? ,
											Member_ID = ? ,
											tags = ?
										WHERE 
											Item_ID = ?");
				$stmt->execute(array($name, $desc, $price, $country, $status, $cat, $member, $tags, $id));

				// Echo Success Message 
				$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . ' Product Updated</div>';

				redirectHome($theMsg, 'back');

					}
 
				
			} else {

				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

				redirectHome($theMsg);
			}

				echo "</div>";				

			} elseif ($do == 'Delete') { 

							echo "<h3 class='text-center'>Delete Product</h3>";
			echo "<div class='container'>";			

				// Chek If Get Request Item ID Is Numiric & Get The Integer Value Of It 
				$itemid =  isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('Item_ID', 'items', $itemid);

				// If There's Such ID Show The Form
				if ($check > 0) { 

					$stmt = $con->prepare("DELETE FROM items WHERE Item_ID = :zid");

					$stmt->bindParam(":zid", $itemid);

					$stmt->execute();

					$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . 'Record  Delete</div>';

					redirectHome($theMsg, 'back');
 
				} else {

					$theMsg = '<div class="alert alert-danger">This Product Is Not Exist</div>';

					redirectHome($theMsg);
				}


					echo "</div>";

		} elseif ($do == 'Activate') { 

			echo "<h1 class='text-center'>Activate Member</h1>";
			echo "<div class='container'>";			

				// Chek If Get Request userid Is Numiric & Get The Integer Value Of It 
				$userid =  isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('userid', 'users', $userid);

				// If There's Such ID Show The Form
				if ($check > 0) { 

					$stmt = $con->prepare("UPDATE users SET RegStatus = 1 WHERE UserID= ?");

					$stmt->execute(array($userid));

					$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . ' Product  Updated</div>';

					redirectHome($theMsg);

				} else {

					$theMsg = '<div class="alert alert-danger">This Product Is Not Exist</div>';

					redirectHome($theMsg);
				}


					echo "</div>";

			} elseif ($do == 'Approve') {

				echo "<h3 class='text-center'>Approve Product</h3>";
				echo "<div class='container'>";			

				// Chek If Get Request Item ID Is Numiric & Get The Integer Value Of It 
				$itemid =  isset($_GET['itemid']) && is_numeric($_GET['itemid']) ? intval($_GET['itemid']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('Item_ID', 'items', $itemid);

				// If There's Such ID Show The Form
				if ($check > 0) { 

					$stmt = $con->prepare("UPDATE items SET Approve = 1 WHERE Item_ID = ?");

					$stmt->execute(array($itemid));

					$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . ' Product  Updated</div>';

					redirectHome($theMsg ,'back');

				} else {

					$theMsg = '<div class="alert alert-danger">This Product Is Not Exist</div>';

					redirectHome($theMsg);
				}


					echo "</div>";			


				
			}
	   
			include $tpl . 'footer.php';

		} else {

			header('Location: index.php');
			
			exit(); 
		}

		ob_end_flush();  // Relase The output

?>	