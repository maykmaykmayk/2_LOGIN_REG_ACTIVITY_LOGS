<?php  
require_once 'core/models.php'; 
require_once 'core/handleForms.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Lawyer Registration Form</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
	<h1>Register here to be a part of our team!</h1>

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
	<form action="core/handleForms.php" method="POST">
		<p>
			<label for="username">Username</label>
			<input type="text" name="username">
		</p>
		<p>
			<label for="first_name">First Name</label>
			<input type="text" name="first_name">
		</p>
		<p>
			<label for="last_name">Last Name</label>
			<input type="text" name="last_name">
		</p>
		<p>
			<label for="user_password">Password</label>
			<input type="password" name="user_password">
		</p>
		<p>
			<label for="username">Confirm Password</label>
			<input type="password" name="confirm_password">
		</p>
        <p><input type="submit" name="insertNewUserBtn"></p>
	</form>
    <input type="submit" value="Cancel" onclick="window.location.href='login.php'">
</body>
</html>