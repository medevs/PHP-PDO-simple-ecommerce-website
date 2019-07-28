<?php

/*
================================================
= Manage Members Page
= You Can Add | Edit | Delete Members From Here 
================================================
*/

session_start();

$pageTitle= 'Members';

	if (isset($_SESSION['Username'])) {

		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

			// Start Manage Page 

		if ($do == 'Manage') { // Manage MEmbers Page 

			$query = '';

			if (isset($_GET['page']) && $_GET['page'] == 'Pending') {

				$query = 'AND RegStatus = 0';
			}


			// Select All Users Except Admin

			$stmt = $con->prepare("SELECT * FROM users WHERE GroupID != 1 $query ORDER By UserID DESC");
			// Execute The Statement

			$stmt->execute();

			// Assing To Variable

			$rows = $stmt->fetchAll();
			if(! empty($rows)) { 

		?>

		<br><br>
			<div class="container ">
				<div class="panel panel-default">

					<div class="panel panel-heading text-center">
						<i class="fa fa-edit"></i> Manage Members
					</div>
					<div class="panel-body">

					<div class="">
				<div class="table-responsive">
					<table class="main-table manage-members text-center table table-bordered">
						<tr>
							<td>#ID</td>
							<td>Avatar</td>
							<td>Username</td>
							<td>Email</td>
							<td>Full Name</td>
							<td>Registred Date</td>
							<td>Control</td>
						</tr>

						<?php

							foreach($rows as $row) {
								echo "<tr>";
									echo "<td>" .$row['UserID'] . "</td>";
									echo "<td>";
											if (empty($row['avatar'])) {
												echo "No Image";
											} else {
												echo "<img src='../uploads/user_img/" . $row['avatar'] .  "' alt='' />";
											}
									echo "</td>";
									echo "<td>" .$row['Username'] . "</td>";
									echo "<td>" .$row['Email'] . "</td>";
									echo "<td>" .$row['FullName'] . "</td>";
									echo "<td>" .$row['Date'] . "</td>";
									echo "<td>
										<a href='members.php?do=Edit&userid=" .$row['UserID'] . "' class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>	
										<a href='members.php?do=Delete&userid=" .$row['UserID'] . "' class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";	
								 	
								 	if ($row['RegStatus'] == 0){

										echo "<a href='members.php?do=Activate&userid=" .$row['UserID'] . "' 
										class='btn btn-info activate'><i 
										class='fa fa-check'></i> Activate</a>";	
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
				<a href="members.php?do=Add" class="btn btn-primary">
					<i class="fa fa-plus"></i>New Member
				</a>
			</div>
			<br><br><br>
		<?php } else {

			echo '<div class="container">';
				echo"<div class='nice-message'>There's No Members to show</div>";
				echo'<a href="members.php?do=Add" class="btn btn-primary">
						<i class="fa fa-plus"></i>New Member
					</a>';				
			echo "</div>";	
		} ?>
	<?php } elseif ($do == 'Add') { // Add Members Page  ?>


		<br><br><br>

				<div class="create-ad block">
			<div class="container">
				<div class="panel panel-primary">
					<div class="panel-heading text-center">Add New Member</div>
					<div class="panel-body">
						 <div class="row">
				 	<div class="col-md-12">
				<form class="from-horizontal" action="?do=Insert" method="POST" enctype="multipart/form-data">
					<!-- Start Username Field -->
					<div class="row">
						<div class="form-group form-group-sm">
						<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Username</label>
						<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
							<input type="text" name="username" class="form-control" autocomplete="off" required="required" placeholder="Username To Login Into Shop">
						</div>
					</div>
					</div><br>
					<!-- End Username Field -->

					<!-- Start Password Field -->
					<div class="row">
						<div class="form-group form-group-sm">
						<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Password</label>
						<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
							<input type="password" name="password" class="password form-control" autocomplete="off" required="required" placeholder="Password Must Be Hard & Complex">
							<i class="show-pass fa fa-eye fa-x"></i>
						</div>
					</div>
					</div><br>
					<!-- End Password Field -->

					<!-- Start Email Field -->
					<div class="row">
						<div class="form-group form-group-sm">
						<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Email</label>
						<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
							<input type="email" name="email" class="form-control" required="required" placeholder="Email Must Be Valid">
						</div>
					</div>
					</div><br>
					<!-- End Email Field -->

					<!-- Start Full Name Field -->
					<div class="row">
						<div class="form-group form-group-sm">
						<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Full Name</label>
						<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
							<input type="text" name="full" class="form-control" required="required" placeholder="Full Name Appear In Your Profile Page">
						</div>
					</div>
					</div><br>
					<!-- End Full Name Field -->

					<!-- Start Image Field -->
					<div class="row">
						<div class="form-group form-group-sm">
						<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">User Image</label>
						<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
							<input type="file" name="avatar" class="" required="required" >
						</div>
					</div> 
					</div><br>
					<!-- End Image Field -->

					<!-- Start Submit Field -->
					<div class="row">
						<div class="form-group form-group-sm">
						<div class="col-sm-offset-2 col-sm-10">
							<input type="submit" value="Add Member" class="btn btn-primary btn-sm">
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

				echo "<h3 class='text-center'>Insert Member</h3>";
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
				$userid = $_POST['username'];
				$pass 	= $_POST['password'];
				$email 	= $_POST['email'];
				$name 	= $_POST['full'];

				$hashPass = sha1($_POST['password']);

				// Validate The Form

					$formErrors = array();

					if (strlen($userid) < 4) {

						$formErrors[] = 'Username Cant Be Less Than <strong>4 Characters</strong>';
					}

					if (strlen($userid) > 20) {

						$formErrors[] = 'Username Cant Be More Than <strong>20 Characters</strong>';
					}

					if (empty($userid)) {

						$formErrors[] = 'Username Cant Be <strong>Empty</strong>';

					}

					if (empty($pass)) {

						$formErrors[] = 'Password Cant Be <strong>Empty</strong>';

					}					

					if (empty($name)) {

						$formErrors[] = 'Full Name Cant Be <strong>Empty</strong>';


					}

					if (empty($email)) {

						$formErrors[] = 'Email Cant Be <strong>Empty</strong>';
							
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

						$avatar = rand(0, 100000) . '_' .$avatarName;

						move_uploaded_file($avatarTmp, "../uploads/user_img/" . $avatar);

						// Check If User Exist in Database

						$check =  checkItem("Username", "users", $userid);

						if ($check == 1) {

							$theMsg = '<div class="alert alert-danger">Sorry This User is Exist</div>';

							redirectHome($theMsg, 'back');

						} else {

							// Inesrt Userinfo In The Database

							$stmt = $con->prepare("INSERT INTO 
													users(Username, Password, Email, FullName, RegStatus, Date, avatar)
												VALUES(:zuser,:zpass, :zmail, :zname, 1, now(), :zavatar)");
      
							$stmt->execute(array(

								'zuser' 	=> $userid,
								'zpass' 	=> $hashPass,
								'zmail' 	=> $email,
								'zname' 	=> $name,
								'zavatar' 	=> $avatar
							));		

							// Echo Success Message  
							$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . ' User Inserted</div>';

							redirectHome($theMsg, 'back');

						}

					}
 
			} else {

				echo "<div class='container'>";

				$theMsg =  '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

				redirectHome($theMsg, 'back');

				echo "</div>";
			}

			echo "</div>";


  		} elseif ($do == 'Edit') { // Edit Page 

			// Chek If Get Request userid Is Numiric & Get The Integer Value Of It 
			$userid =  isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

			// Select All Data Depend On This ID
			$stmt = $con->prepare("SELECT * FROM users WHERE UserID = ? LIMIT 1");

			// Execute Query 
			$stmt->execute(array($userid));

			// Fetch The Data
			$row = $stmt->fetch();

			// The Row Count
			$count = $stmt->rowCount();

			// If There's Such ID Show The Form
			if ($stmt->rowCount() > 0) { ?>


				<br><br><br>

				<div class="create-ad block">
			<div class="container">
				<div class="panel panel-primary">
					<div class="panel-heading text-center">Edit Member</div>
					<div class="panel-body">
						 <div class="row">
				 	<div class="col-md-12">
					<form class="from-horizontal" action="?do=Update" method="POST" enctype="multipart/form-data">
						<input type="hidden" name="userid" value="<?php echo $userid ?>">
						<!-- Start Username Field -->
						<div class="row">
							<div class="form-group form-group-sm">
							<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Username</label>
							<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
								<input type="text" name="username" class="form-control" value="<?php echo $row['Username'] ?>" autocomplete="off" required="required">
							</div>
						</div>
						</div><br>
						<!-- End Username Field -->

						<!-- Start Password Field -->
						<div class="row">
							<div class="form-group form-group-sm">
							<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Password</label>
							<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
								<input type="hidden" name="oldpassword" value="<?php echo $row['Password'] ?>">
								<input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave Blank If You Dont Want To Change">
							</div>
						</div>
						</div><br>
						<!-- End Password Field -->

						<!-- Start Email Field -->
						<div class="row">
							<div class="form-group form-group-sm">
							<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Email</label>
							<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
								<input type="email" name="email" class="form-control " value="<?php echo $row['Email'] ?>" required="required">
							</div>
						</div>
						</div><br>
						<!-- End Email Field -->

						<!-- Start Full Name Field -->
						<div class="row">
							<div class="form-group form-group-sm">
							<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Full Name</label>
							<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
								<input type="text" name="full" class="form-control" value="<?php echo $row['FullName'] ?>" required="required">
							</div>
						</div>
						</div><br>
						<!-- End Full Name Field -->

						<!-- Start Image Field -->
						<div class="row">
							<div class="form-group form-group-sm">
							<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">User Image</label>
							<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
								<input type="file" name="avatar" class="" value="<?php echo '../uploads/user_img/'. $row['avatar'] ?>" required="required" >
							</div>
						</div> 
						</div><br>
						<!-- End Image Field -->


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

				echo "<div class='container>";

				$theMsg = '<div class="alert alert-danger">There No Such ID</div>';

				redirectHome($theMsg, 'back');

				echo "</div>";


			}
		} elseif($do == 'Update') { // Update Page

			echo "<h3 class='text-center'>Update Member</h3>";

			echo "<div class='container'>";


			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

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
				$id 	= $_POST['userid'];
				$userid = $_POST['username'];
				$email 	= $_POST['email'];
				$name 	= $_POST['full'];
				//$avatar = $_POST['avatar'];

				// Password Trick

				// Condition ? True : False ;

				$pass = empty($_POST['newpassword']) ? $_POST['oldpassword'] : sha1($_POST['newpassword']);

				// Validate The Form

					$formErrors = array();

					if (strlen($userid) < 4) {

						$formErrors[] = 'Username Cant Be Less Than <strong>4 Characters</strong>';
					}

					if (strlen($userid) > 20) {

						$formErrors[] = 'Username Cant Be More Than <strong>20 Characters</strong>';
					}

					if (empty($userid)) {

						$formErrors[] = 'Username Cant Be <strong>Empty</strong>';

					}

					if (empty($name)) {

						$formErrors[] = '<div class="alert alert-danger">Full Name Cant Be <strong>Empty</strong></div>';


					}

					if (empty($email)) {

						$formErrors[] = 'Email Cant Be <strong>Empty</strong>';
							
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

						$avatar = rand(0, 100000) . '_' .$avatarName;

						move_uploaded_file($avatarTmp, "../uploads/user_img/" . $avatar);


						$stmt2=$con->prepare("SELECT 
												* 
												FROM 
													users 
												WHERE 
													Username = ? 
												AND 
													UserID != ?");

						$stmt2->execute(array($userid, $id));

						$count = $stmt2->rowCount();

						if ($count == 1) {

							/*echo '<div class="alert alert-danger">Sorry This User is Exist</div>';*/

							$theMsg = '<div class="alert alert-danger">Sorry This User is Exist</div>';

							redirectHome($theMsg, 'back'); 

						} else {

							  // Update The Database With This Info

							$stmt = $con->prepare("UPDATE users SET Username = ?, Email = ?, FullName = ?, avatar = ?, Password = ? WHERE UserID = ?");
							$stmt->execute(array($userid, $email, $name, $avatar, $pass, $id));

							// Echo Success Message 
							$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . 'Record  Updated</div>';

							redirectHome($theMsg, 'back'); 
						} 

					}
 
				
			} else {

				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

				redirectHome($theMsg);
			}

				echo "</div>";

		} elseif ($do == 'Delete') { // Delet Member Page 

			echo "<h3 class='text-center'>Delete Member</h3>";
			echo "<div class='container'>";			

				// Chek If Get Request userid Is Numiric & Get The Integer Value Of It 
				$userid =  isset($_GET['userid']) && is_numeric($_GET['userid']) ? intval($_GET['userid']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('userid', 'users', $userid);

				// If There's Such ID Show The Form
				if ($check > 0) { 

					$stmt = $con->prepare("DELETE FROM users WHERE UserID = :zuser");

					$stmt->bindParam(":zuser", $userid);

					$stmt->execute();

					$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . 'Record  Delete</div>';

					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">This Id Is Not Exist</div>';

					redirectHome($theMsg);
				}


					echo "</div>";

		} elseif ($do == 'Activate') {

			echo "<h3 class='text-center'>Activate Member</h3>";
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