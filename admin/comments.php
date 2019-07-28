<?php

/*
================================================
= Manage Comments Page
= You Can Edit | Delete | Approve Comments From Here 
================================================
*/

session_start();

$pageTitle= 'Comments';

	if (isset($_SESSION['Username'])) {

		include 'init.php';

		$do = isset($_GET['do']) ? $_GET['do'] : 'Manage';

			// Start Manage Page 

		if ($do == 'Manage') { // Manage MEmbers Page 

			// Select All Users Except Admin

			$stmt = $con->prepare("SELECT 
											comments.*, items.Name AS Item_Name, users.username AS Member 
										FROM 
											comments
										INNER join
											items
										ON 
											items.Item_ID = comments.item_id
										INNER JOIN 
											users
										ON
											users.UserID = comments.user_id
										ORDER BY 
											c_id DESC");
			// Execute The Statement

			$stmt->execute();

			// Assing To Variable

			$comments = $stmt->fetchAll();
			if(! empty($comments)) { 

		?>

		<br><br>
			<div class="container ">
				<div class="panel panel-default">

					<div class="panel panel-heading text-center">
						<i class="fa fa-edit"></i> Manage Comments
					</div>
					<div class="panel-body">

					<div class="">
				<div class="table-responsive">
					<table class="main-table text-center table table-bordered">
						<tr>
							<td>ID</td>
							<td>Comment</td>
							<td>Item Name</td>
							<td>User Name</td>
							<td>Added Date</td>
							<td>Control</td>
						</tr>

						<?php 

							foreach($comments as $comment) {
								echo "<tr>";
									echo "<td>" .$comment['c_id'] . "</td>";
									echo "<td>" .$comment['comment'] . "</td>";
									echo "<td>" .$comment['Item_Name'] . "</td>";
									echo "<td>" .$comment['Member'] . "</td>";
									echo "<td>" .$comment['comment_date'] . "</td>";
									echo "<td>
										<a href='comments.php?do=Edit&comid=" .$comment['c_id'] . "' 
										class='btn btn-success'><i class='fa fa-edit'></i>Edit</a>	
										<a href='comments.php?do=Delete&comid=" .$comment['c_id'] . "' 
										class='btn btn-danger confirm'><i class='fa fa-close'></i>Delete</a>";	
								 	
								 	if ($comment['status'] == 0){

										echo "<a href='comments.php?do=Approve&comid=" .$comment['c_id'] . "' 
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
			</div>
			</div>
			</div>
			<br><br><br>
			<?php } else {

				echo '<div class="container">';
					echo"<div class='nice-message'>There's No Comments to show</div>";					
				echo "</div>";	
			} ?>
	<?php  


  		} elseif ($do == 'Edit') { // Edit Page 

			// Chek If Get Request comid Is Numiric & Get The Integer Value Of It 
			$comid =  isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

			// Select All Data Depend On This ID
			$stmt = $con->prepare("SELECT * FROM comments WHERE c_id = ?");

			// Execute Query 
			$stmt->execute(array($comid));

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
					<div class="panel-heading text-center">Edit Comment</div>
					<div class="panel-body">
						 <div class="row">
				 	<div class="col-md-12">
					<form class="from-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="comid" value="<?php echo $comid ?>">
						<!-- Start comment Field -->
						<div class="row">
							<div class="form-group form-group-sm">
							<label class="col-xs-12 col-sm-2 col-md-2 col-sm-2 control-label">Comment</label>
							<div class="col-xs-12 col-sm-6 col-md-4 col-sm-4">
								<textarea class="form-control" name="comment"><?php echo $row['comment'] ?></textarea>
							</div>
						</div>
						</div><br>
						<!-- End comments Field -->

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

			echo "<h3 class='text-center'>Update Comment</h3>";

			echo "<div class='container'>";


			if ($_SERVER['REQUEST_METHOD'] == 'POST') {

				// Get Variables Form The Form 
				$comid 	= $_POST['comid'];
				$comment = $_POST['comment'];

						// Update The Database With This Info

				$stmt = $con->prepare("UPDATE comments SET comment = ? WHERE c_id = ?");
				$stmt->execute(array($comment, $comid));

				// Echo Success Message 
				$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . 'Record  Updated</div>';

				redirectHome($theMsg, 'back');
				
			} else {

				$theMsg = '<div class="alert alert-danger">Sorry You Cant Browse This Page Directly</div>';

				redirectHome($theMsg);
			}

				echo "</div>";

		} elseif ($do == 'Delete') { // Delet  Page 

			echo "<h3 class='text-center'>Delete Comment</h3>";
			echo "<div class='container'>";			

				// Chek If Get Request comid Is Numiric & Get The Integer Value Of It 
				$comid =  isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('c_id', 'comments', $comid);

				// If There's Such ID Show The Form
				if ($check > 0) { 

					$stmt = $con->prepare("DELETE FROM comments WHERE c_id = :zid");

					$stmt->bindParam(":zid", $comid);

					$stmt->execute();

					$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . 'Record  Delete</div>';

					redirectHome($theMsg, 'back');

				} else {

					$theMsg = '<div class="alert alert-danger">This Id Is Not Exist</div>';

					redirectHome($theMsg);
				}


					echo "</div>";

		} elseif ($do == 'Approve') {

			echo "<h3 class='text-center'>Approve Comment</h3>";
			echo "<div class='container'>";			

				// Chek If Get Request comid Is Numiric & Get The Integer Value Of It 
				$comid =  isset($_GET['comid']) && is_numeric($_GET['comid']) ? intval($_GET['comid']) : 0;

				// Select All Data Depend On This ID

				$check = checkItem('c_id', 'comments', $comid);

				// If There's Such ID Show The Form
				if ($check > 0) { 

					$stmt = $con->prepare("UPDATE comments SET status = 1 WHERE c_id= ?");

					$stmt->execute(array($comid));

					$theMsg = "<div class='alert alert-success'>".$stmt->rowCount() . 'Record  Approved</div>';

					redirectHome($theMsg, 'back');

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