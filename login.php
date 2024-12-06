<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 

if(isset($_SESSION['applicantID'])) {
  header("Location: index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Grisola's Law Firm Application</title>
	<link rel="stylesheet" href="style.css">
</head>
<body>
	
	<?php  
	if (isset($_SESSION['message']) && isset($_SESSION['status'])) {

		if ($_SESSION['status'] == "200") {
			echo "<h1 style='color: green;'>{$_SESSION['message']}</h1>";
		}

		else {
			echo "<h1 style='color: red;'>{$_SESSION['message']}</h1>";	
		}

	}
	unset($_SESSION['message']);
	unset($_SESSION['status']);
	?>
	
	<h1>Login Now!</h1>
	<form action="core/handleForms.php" method="POST">
		<p>
			<label for="username">Username</label>
			<input type="text" name="username">
		</p>
		<p>
			<label for="user_password">Password</label>
			<input type="password" name="user_password"> <br><br>
			<input type="submit" name="loginUserBtn">
		</p>
	</form>
	<p>Want to be part of our Team? You may register <a href="register.php">here</a></p>
</body>
</html>