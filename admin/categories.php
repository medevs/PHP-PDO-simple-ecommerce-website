<?php

	/*
	================================================
	== Category Page 
	================================================
	*/
	ob_start(); // Output Buffering Start

	session_start();

	$pageTitle= 'categories';

		if (isset($_SESSION['Username'])) {

			include 'init.php';

			$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

		
			if ($do == 'Manage') { 

				$sort ='asc';

				$sort_array = array('asc', 'desc');

				if(isset($_GET['sort']) && in_array($_GET['sort'], $sort_array)) {

					$sort = $_GET['sort'];

				}

				$stmt2 = $con->prepare("SELECT * FROM categories WHERE parent = 0 ORDER BY Ordering $sort");

				$stmt2->execute();

				$cats = $stmt2->fetchAll(); 
				if(! empty($cats)) {

					?>

					<br><br>
					<div class="container categories">
						<div class="panel panel-default">
							<div class="panel panel-heading text-center">
								<i class="fa fa-edit"></i> Manage Categories
								
							</div>
							<div class="panel-body">
								<?php

									foreach($cats as $cat) {
										echo "<div class='cat'>";
											echo "<div class='hidden-buttons pull-right'>";
												echo "<a href='categories.php?do=Edit&catid=" .$cat['ID'] . "' class='btn btn-xs btn-primary'><i class='fa fa-edit'></i> Edit</a>";
												echo "<a href='categories.php?do=Delete&catid=" .$cat['ID'] . "' class=' confirm btn btn-xs btn-danger'><i class='fa fa-close'></i> Delete</a>";
											echo "</div>";
											echo "<h3>" . $cat['Name'] . "</h3>";
											echo "<div class='full-view'>";
												
												if($cat['Visibility'] == 1) { echo "<span class='visibility'><i class='fa fa-eye'></i>Hidden</span>";}
												if($cat['Allow_Comment'] == 1) { echo "<span class='commenting'><i class='fa fa-close'></i>Comment Disabled</span>";}
												if($cat['Allow_Ads'] == 1) { echo "<span class='advertises'><i class='fa fa-close'></i>Ads Disabled</span>";}
											echo "</div>";

											// Get Child Categories
											$childCats = getAllFrom("*", "categories", "where parent = {$cat['ID']}", "", "ID", "ASC");
											if (! empty($childCats)) {
												echo "<ul class='list-unstyled child-cats'>";
												foreach ($childCats as $c) {
													echo "<li class='child-link'>
															<a href='categories.php?do=Edit&catid=" .$c['ID'] . "'>" .$c['Name'] . "</a>
															<a href='categories.php?do=Delete&catid=" .$c['ID'] . "' class='show-delete confirm'> Delete</a>
														</li>";
												} 
												echo "</ul>";
											}											
										echo "</div>"; 	
										echo "<hr>";

									}
								?>	
							</div>
						</div>
						<a class="add-category btn btn-primary"href="categories.php?do=Add"><i class="fa fa-plus"></i> Add New Category</a>
					</div>

					<?php
					 
				} else {

					echo '<div class="container">';
						echo"<div class='nice-message'>There's No Categories to show</div>";
						echo'<a class="add-category btn btn-primary"href="categories.php?do=Add"><i class="fa fa-plus"></i> Add New Category</a>';				
					echo "</div>";	
				} 

			?>

			<?php

			} elseif ($do == 'Add') {

				 ?>

				 <br><br><br>

					<div class="create-ad block">
			<div class="container">
				<div class="panel panel-primary">
					<div class="panel-heading text-center">Add New Category</div>
					<div class="panel-body">
						 <div class="row">
				 	<div class="col-md-12">

						<form class="from-horizontal" action="?do=Insert" method="POST">
							<!-- Start Name Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Name</label>
								<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
									<input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder="Name Of The Ctegory">
								</div>
							</div>
							</div><br>
							<!-- End Name Field -->

							<!-- Start Description Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Description</label>
								<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
									<input type="text" name="description" class=" form-control" placeholder="Describe The Ctegory">
								</div>
							</div>
							</div><br>
							<!-- End Description Field -->

							<!-- Start Ordering Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Ordering</label>
								<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
									<input type="text" name="ordering" class="form-control" placeholder="Number To Arrange The Categories">
								</div>
							</div>
							</div><br>
							<!-- End Ordering Field -->

							<!-- Start Category Type --> 
							<div class="row">
								<div class="form-group form-group-sm">
								<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Parent?</label>
								<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
									<select name="parent">
										<option value="0">None</option>
										<?php 
											$allCats = getAllFrom("*", "categories", "WHERE parent = 0", "", "ID", "ASC");
											foreach($allCats as $cat) {
												echo "<option value='" . $cat['ID'] . "'>" .$cat['Name'] . "</option>";
											}
										?>
									</select>
								</div>
							</div>
							</div><br>
							<!-- End Category Type --> 

							<!-- Start Visibility Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Visibile</label>
								<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
									<div>
										<input id="vis-yes" type="radio" name="visibility" value="0" checked>
										<label for="vis-yes">Yes</label>
									</div>
									<div>
										<input id="vis-no" type="radio" name="visibility" value="1">
										<label for="vis-no">No</label>
									</div>
								</div>
							</div>
							</div><br>
							<!-- End Visibility Field -->

							<!-- Start Commenting Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Allow Commenting</label>
								<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
									<div>
										<input id="com-yes" type="radio" name="commenting" value="0" checked>
										<label for="com-yes">Yes</label>
									</div>
									<div>
										<input id="com-no" type="radio" name="commenting" value="1">
										<label for="com-no">No</label>
									</div>
								</div>
							</div>
							</div><br>
							<!-- End Commenting Field -->

							<!-- Start Ads Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Allow Ads</label>
								<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
									<div>
										<input id="ads-yes" type="radio" name="ads" value="0" checked>
										<label for="ads-yes">Yes</label>
									</div>
									<div>
										<input id="ads-no" type="radio" name="ads" value="1">
										<label for="ads-no">No</label>
									</div>
								</div>
							</div>
							</div><br>
							<!-- End Ads Field -->							


							<!-- Start Submit Field -->
							<div class="row">
								<div class="form-group form-group-sm">
								<div class="col-sm-offset-2 col-sm-10">
									<input type="submit" value="Add Category" class="btn btn-primary btn-sm">
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

				if ($_SERVER['REQUEST_METHOD'] == 'POST') {

					echo "<h1 class='text-center'>Insert Category</h1>";
					echo "<div class='container'>";

					// Get Variables Form The Form 
					$name 		= $_POST['name'];
					$desc 		= $_POST['description'];
					$parent 	= $_POST['parent'];
					$order 		= $_POST['ordering'];
					$visible 	= $_POST['visibility'];
					$comment 	= $_POST['commenting'];
					$ads 		= $_POST['ads'];


						// Check If Category Exist in Database

						$check =  checkItem("Name", "categories", $name);

						if ($check == 1) {

							$theMsg = '<div class="alert alert-danger">Sorry This Category is Exist</div>';

							redirectHome($theMsg, 'back');

						} else {

							// Inesrt Categories Info In The Database

							$stmt = $con->prepare("INSERT INTO 

							categories(Name, Description, parent, Ordering, Visibility, Allow_Comment, Allow_Ads)

							VALUES(:zname, :zdesc, :zparent, :zorder, :zvisible, :zcomment, :zads)");
	  
							$stmt->execute(array(

								'zname' 	=> $name,    
								'zdesc' 	=> $desc,
								'zparent' 	=> $parent,
								'zorder'	=> $order,
								'zvisible' 	=> $visible,
								'zcomment' 	=> $comment,
								'zads' 		=> $ads
							));		

							// Echo Success Message  
							$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . 'Record  Inserted</div>';

							redirectHome($theMsg, 'back');

						}

	 
				} else {

					echo "<div class='container'>";

					$theMsg =  '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

					redirectHome($theMsg, 'back');

					echo "</div>";
				}

				echo "</div>";


	  		} elseif ($do == 'Edit') {

			// Chek If Get Request catid Is Numiric & Get The Integer Value Of It 
			$catid =  isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

			// Select All Data Depend On This ID
			$stmt = $con->prepare("SELECT * FROM categories WHERE ID = ?");

			// Execute Query 
			$stmt->execute(array($catid));

			// Fetch The Data
			$cat = $stmt->fetch();

			// The Row Count
			$count = $stmt->rowCount();

			// If There's Such ID Show The Form
			if ($stmt->rowCount() > 0) { ?>

				<br><br><br>

				<div class="create-ad block">
			<div class="container">
				<div class="panel panel-primary">
					<div class="panel-heading text-center">Edit Category</div>
					<div class="panel-body">
						 <div class="row">
				 	<div class="col-md-12">
					<form class="from-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="catid" value="<?php echo $catid ?>">

						<!-- Start Name Field -->
						<div class="row">
							<div class="form-group form-group-sm">
							<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Name</label>
							<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
								<input type="text" name="name" class="form-control" required="required" placeholder="Name Of The Ctegory" value="<?php echo $cat['Name'];?>">
							</div>
						</div>
						</div><br>
						<!-- End Name Field -->

						<!-- Start Description Field -->
						<div class="row">
							<div class="form-group form-group-sm">
							<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Description</label>
							<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
								<input type="text" name="description" class=" form-control" placeholder="Describe The Ctegory" value="<?php echo $cat['Description'];?>">
							</div>
						</div>
						</div><br>
						<!-- End Description Field -->

						<!-- Start Ordering Field -->
						<div class="row">
							<div class="form-group form-group-sm">
							<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Ordering</label>
							<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
								<input type="text" name="ordering" class="form-control" placeholder="Number To Arrange The Categories" value="<?php echo $cat['Ordering'];?>">
							</div>
						</div>
						</div><br>
						<!-- End Ordering Field -->

						<!-- Start Category Type --> 
						<div class="row">
							<div class="form-group form-group-sm">
							<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Parent?</label>
							<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
								<select name="parent">
									<option value="0">None</option>
									<?php 
										$allCats = getAllFrom("*", "categories", "WHERE parent = 0", "", "ID", "ASC");
										foreach($allCats as $c) {
											echo "<option value='" . $c['ID'] . "'";
											if ($cat['parent'] == $c['ID']) { echo 'selected'; }
											echo ">" .$c['Name'] . "</option>";
										}
									?>
								</select>
							</div>
						</div>
						</div><br>
						<!-- End Category Type -->						

						<!-- Start Visibility Field -->
						<div class="row">
							<div class="form-group form-group-sm">
							<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Visibile</label>
							<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
								<div>
									<input id="vis-yes" type="radio" name="visibility" value="0" <?php if($cat['Visibility'] == 0) { echo 'checked'; } ?>>
									<label for="vis-yes">Yes</label>
								</div>
								<div>
									<input id="vis-no" type="radio" name="visibility" value="1" <?php if($cat['Visibility'] == 1) { echo 'checked'; } ?>>
									<label for="vis-no">No</label>
								</div>
							</div>
						</div>
						</div><br>
						<!-- End Visibility Field -->

						<!-- Start Commenting Field -->
						<div class="row">
							<div class="form-group form-group-sm">
							<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Allow Commenting</label>
							<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
								<div>
									<input id="com-yes" type="radio" name="commenting" value="0" <?php if($cat['Allow_Comment'] == 0) { echo 'checked'; } ?>>
									<label for="com-yes">Yes</label>
								</div>
								<div>
									<input id="com-no" type="radio" name="commenting" value="1" <?php if($cat['Allow_Comment'] == 1) { echo 'checked'; } ?>>
									<label for="com-no">No</label>
								</div>
							</div>
						</div>
						</div><br>
						<!-- End Commenting Field -->

						<!-- Start Ads Field -->
						<div class="row">
							<div class="form-group form-group-sm">
							<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Allow Ads</label>
							<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
								<div>
									<input id="ads-yes" type="radio" name="ads" value="0" <?php if($cat['Allow_Ads'] == 0) { echo 'checked'; } ?> >
									<label for="ads-yes">Yes</label>
								</div>
								<div>
									<input id="ads-no" type="radio" name="ads" value="1" <?php if($cat['Allow_Ads'] == 1) { echo 'checked'; } ?> >
									<label for="ads-no">No</label>
								</div>
							</div>
						</div>
						</div><br>
						<!-- End Ads Field -->							


						<!-- Start Submit Field -->
						<div class="row">
							<div class="form-group form-group-sm">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Save" class="btn btn-primary btn-sm">
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

			// If There's No Such ID Show Error Message 
			} else {

				echo "<div class='container'>";

				$theMsg = '<div class="alert alert-danger">There No Such ID</div>';

				redirectHome($theMsg, 'back');

				echo "</div>";

			}	  			

			} elseif ($do == 'Update') {

			echo "<h1 class='text-center'>Update Category</h1>";
			echo "<div class='container'>";


			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				// Get Variables Form The Form 
				$id 		= $_POST['catid'];
				$name 		= $_POST['name'];
				$desc 		= $_POST['description'];
				$order 		= $_POST['ordering'];
				$parent 	= $_POST['parent'];
				$visible 	= $_POST['visibility'];
				$comment 	= $_POST['commenting'];
				$ads 		= $_POST['ads']; 

					// Update The Database With This Info

				$stmt = $con->prepare("UPDATE 
											categories 
										SET 
											Name = ?, 
											Description = ?, 
											Ordering = ?,
											parent = ?, 
											Visibility = ?,
											Allow_Comment = ?, 
											Allow_Ads = ? 

										WHERE
											 ID = ?");
				$stmt->execute(array($name, $desc, $order, $parent, $visible, $comment, $ads, $id));

				// Echo Success Message 
				$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . 'Record  Updated</div>';

				redirectHome($theMsg, 'back');
 
				
			} else {

				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

				redirectHome($theMsg);
			}

				echo "</div>";			 

			} elseif ($do == 'Delete') { 


			echo "<h1 class='text-center'>Delete Category</h1>";
			echo "<div class='container'>";			

				// Chek If Get Request Catid Is Numiric & Get The Integer Value Of It 
				$catid =  isset($_GET['catid']) && is_numeric($_GET['catid']) ? intval($_GET['catid']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('ID', 'categories', $catid);

				// If There's Such ID Show The Form
				if ($check > 0) { 

					$stmt = $con->prepare("DELETE FROM categories WHERE ID = :zid");

					$stmt->bindParam(":zid", $catid);

					$stmt->execute();

					$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . 'Record  Delete</div>';

					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">This Id Is Not Exist</div>';

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

						$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . 'Record  Updated</div>';

						redirectHome($theMsg);

					} else {

						$theMsg = '<div class="alert alert-danger">This Id Is Not Exist</div>';

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