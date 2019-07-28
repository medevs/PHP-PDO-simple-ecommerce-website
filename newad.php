<?php 
	ob_start();
	session_start();
	$pageTitle = 'Create New Product';
	include 'init.php'; 
	if(isset($_SESSION['user'])) { 

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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

			$formErrors = array();

			$name 		= filter_var($_POST['name'], FILTER_SANITIZE_STRING);
			$desc 		= filter_var($_POST['description'], FILTER_SANITIZE_STRING);
			$price 		= filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_INT);
			$quantity 	= filter_var($_POST['quantity'], FILTER_SANITIZE_NUMBER_INT);
			$country 	= filter_var($_POST['country'], FILTER_SANITIZE_STRING);
			$status 	= filter_var($_POST['status'], FILTER_SANITIZE_NUMBER_INT);
			$category 	= filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
			$tags 		= filter_var($_POST['tags'], FILTER_SANITIZE_STRING);

			if (strlen($name) < 4) {

				$formErrors[] = 'Product Title Must Be At Least 4 Caracters';
			}

			if (strlen($desc) < 10) {

				$formErrors[] = 'Product Description Must Be At Least 10 Caracters';
			}

			if (strlen($country) < 2) {

				$formErrors[] = 'Product Country Must Be At Least 2 Caracters';
			}

			if (empty($price)) {

				$formErrors[] = 'Product Price Must Be Not Empty';
			}

			if (empty($quantity)) {

				$formErrors[] = 'Quantity Must Be Not Empty';
			}

			if (empty($status)) {

				$formErrors[] = 'Product Status Must Be Not Empty';
			}

			if (empty($category)) {

				$formErrors[] = 'Product Category Must Be Not Empty';
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

			// Check If Ther's No Error Proced The Update Operation

			if (empty($formErrors)) {

					// Inesrt Userinfo In The Database

				$avatar = rand(0, 10000) . '_' .$avatarName;

				move_uploaded_file($avatarTmp, "uploads/product_img/" . $avatar);

					$stmt = $con->prepare("INSERT INTO 
											items(Name, Description, Price, Quantity, Country_Made, Status, Add_Date, Cat_ID, avatar, Member_ID, tags)
										VALUES(:zname,:zdesc, :zprice, :zquantity, :zcountry, :zstatus, now(), :zcat, :zavatar, :zmember, :ztags)");

					$stmt->execute(array(

						'zname' 	=> $name,
						'zdesc' 	=> $desc,
						'zprice' 	=> $price,
						'zquantity' => $quantity,
						'zcountry' 	=> $country,
						'zstatus' 	=> $status,
						'zcat' 		=> $category,
						'zavatar' 	=> $avatar,
						'zmember' 	=> $_SESSION['uid'],
						'ztags' 	=> $tags
					));		 

					// Echo Success Message  
					
					if ($stmt) {

						$succesMsg = 'Product Has Been Added';

					}


			}			
		}
		
?>
<br><br><br>
<div class="create-ad block">
	<div class="container">
		<div class="panel panel-primary">
			<div class="panel-heading text-center"><?php echo $pageTitle ?></div>
			<div class="panel-body">
				 <div class="row">
				 	<div class="col-md-8">
						<form class="from-horizontal main-form" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST" enctype="multipart/form-data">
							<!-- Start Name Field -->
							<div class="row">
								<div class="form-group form-group-sm">
									<label class="col-xs-12 col-sm-3 col-md-2 col-sm-3 control-label">Name</label>
									<div class="col-xs-12 col-sm-6 col-md-9 col-sm-9">
										<input 
											   pattern=".{4,}"
											   title="This Field Require At Least 4 Characters" 	
											   type="text" 
										       name="name" 
										       class="form-control live" 
										       placeholder="Name Of The Product" 
										       data-class=".live-title"
										       required="required">
									</div>
								</div>
							</div><br>
							<!-- End Name Field -->
							<!-- Start Description Field -->
							<div class="row">
								<div class="form-group form-group-sm">
									<label class="col-xs-12 col-sm-3 col-md-2 col-sm-3 control-label">Description</label>
									<div class="col-xs-12 col-sm-6 col-md-9 col-sm-9">
										<input 
											   pattern=".{10,}"
											   title="This Field Require At Least 10 Characters"	
											   type="text" 
											   name="description" 
											   class="form-control live" 
											   placeholder="Description Of The Product" 
											   data-class=".live-desc"
											   required="required">
									</div>
								</div>
							</div><br>
							<!-- End Description Field -->
							<!-- Start Price Field -->
							<div class="row">
								<div class="form-group form-group-sm">
									<label class="col-xs-12 col-sm-3 col-md-2 col-sm-3 control-label">Price</label>
									<div class="col-xs-12 col-sm-6 col-md-9 col-sm-9">
										<input 
											   type="text" 
										       name="price" 
										       class="form-control live" 
										       placeholder="Price Of The Product" 
										       data-class=".live-price"
										       required="required">
									</div>
								</div>
							</div><br>
							<!-- End Price Field -->
							<!-- Start Quantity Field -->
							<div class="row">
								<div class="form-group form-group-sm">
									<label class="col-xs-12 col-sm-3 col-md-2 col-sm-3 control-label">Quantity</label>
									<div class="col-xs-12 col-sm-6 col-md-9 col-sm-9">
										<input 
											   type="text" 
										       name="quantity" 
										       class="form-control live" 
										       placeholder="Quantity Of The Product" 
										       data-class=".live-quantity"
										       required="required">
									</div>
								</div>
							</div><br>
							<!-- End Quantity Field -->
							<!-- Start Country Field -->
							<div class="row">
								<div class="form-group form-group-sm">
									<label class="col-xs-12 col-sm-3 col-md-2 col-sm-3 control-label">Country</label>
									<div class="col-xs-12 col-sm-6 col-md-9 col-sm-9">
										<input 
											   type="text" 
										       name="country" 
										       class="form-control" 
										       placeholder="Country Of Made"
										       required="required">
									</div>
								</div>
							</div><br>
							<!-- End Country Field -->
							<!-- Start Status Field -->
							<div class="row">
								<div class="form-group form-group-sm">
									<label class="col-xs-12 col-sm-3 col-md-2 col-sm-3 control-label">Status</label>
									<div class="col-xs-12 col-sm-6 col-md-9 col-sm-9">
										<select name="status" required="required">
											<option value="">...</option>
											<option value="1">New</option>
											<option value="2">Like New</option>
											<option value="3">Used</option>
											<option value="4">Very Old</option>
										</select>
									</div>
								</div>
							</div><br>
							<!-- End Status Field -->
							<!-- Start Categories Field -->
							<div class="row">
								<div class="form-group form-group-sm">
									<label class="col-xs-12 col-sm-3 col-md-2 col-sm-3 control-label">Category</label>
									<div class="col-xs-12 col-sm-6 col-md-9 col-sm-9">
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
								<label class="col-xs-12 col-sm-3 col-md-2 col-sm-3 control-label">Product Image</label>
								<div class="col-xs-12 col-sm-6 col-md-9 col-sm-9">
									<input type="file"  name="avatar" class="btn btn-default" required="required" >
								</div>
							</div> 
							</div><br>
							<!-- End Image Field -->
							<!-- Start Tags Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<label class="col-xs-12 col-sm-3 col-md-2 col-sm-3 control-label">Tags</label>
								<div class="col-xs-12 col-sm-6 col-md-9 col-sm-9">
									<input type="text" name="tags" class="form-control"   placeholder="Separate Tags With Comma (,)">
								</div>
							</div>
							</div><br>
							<!-- End Tags Field -->								
							<!-- Start Submit Field -->
							<div class="row">
								<div class="form-group form-group-sm">
									<div class="col-sm-offset-2 col-sm-10">
										<input type="submit" value="Add Product" class="btn btn-primary btn-sm">
									</div>
								</div>
							</div>
							<!-- End Submit Field -->

						</form>				 		
				 	</div>
				 	<!-- <div class="col-md-4">
				 		<div class="thumbnail Product-box live-preview">
							<span class="price-tag">
								$<span class="live-price"></span>
							</span>
							<img class="img-responsive" src="img.jpg" alt="" >
							<div class="caption">
								<h3 class="live-title">Title</h3>
								<p class="live-desc">Description</p>
							</div>
						</div>
				 	</div> -->
				 </div> 
				 <!-- Start Loopiong Through Errors -->
				 <?php 
				 	if (! empty($formErrors)) {

				 		foreach ($formErrors as $error) {

				 			echo '<div class="alert alert-danger">' . $error . '</div>';
				 		}
				 	}
					if (isset($succesMsg)) {
						echo '<div class="alert alert-success">' . $succesMsg . '</div>';
					}				 	
				 ?>
				 <!-- End Loopiong Through Errors -->

			</div>
		</div>
	</div>
</div>
<?php
	}else {
		header('location: login.php');
		exit();
	}
	include $tpl . 'footer.php';
	ob_end_flush();
?>		
