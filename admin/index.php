
<?php 
	session_start();
	$noNavbar ='';
	$pageTitle = 'Login';
	
	if (isset($_SESSION['Username'])) {
		header('Location: dashboard.php'); // Redirect 
	}
	include 'init.php'; 

	// Check If User Coming Form HTTP Post Request

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {

		$Username = $_POST['user'];
		$Password = $_POST['pass'];
		$hashedPass = sha1($Password);


		//  Check If The User Exit In Database

		$stmt = $con->prepare("SELECT 
									UserID, Username, Password 
								FROM 
									users 
								WHERE 
									Username = ? 
								AND 
									Password = ?
								AND
									GroupID = 1
								LIMIT 1");
		$stmt->execute(array($Username, $hashedPass));
		$row = $stmt->fetch();
		$count = $stmt->rowCount();

		//  If Count > 0 This Mean The Database Contain Record About This User name 

		if ($count > 0) {
			$_SESSION['Username'] = $Username; // Register Session Name
			$_SESSION['ID'] = $row['UserID']; // Register Session ID
			header('Location: dashboard.php'); // Redirect To Dashboard Page
			exit();
		}

	}
?>
	
	<form class="login" action="<?php echo $_SERVER['PHP_SELF'] ?>" method="POST">

		<img src="../layout/images/logo/logo3.png" alt="">
		<input class="form-control " type="text" name="user" placeholder="Username" autocomplete="off">
		<input class="form-control " type="password" name="pass" placeholder="Password" autocomplete="new-password">
		<input class="btn btn-primary btn-block" type="submit" value="login">
	</form>

<?php include $tpl . 'footer.php'; ?>		
