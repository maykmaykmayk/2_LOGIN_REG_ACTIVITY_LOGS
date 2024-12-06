<h1>Hello theree! Welcome, <span style="color: blue;"><?php echo $_SESSION['username']; ?></span></h1>

<div class="navbar">
	<h3>
		<a href="index.php">Home</a>
		<a href="viewUsers.php">All Users</a>
		<a href="viewLogs.php">Activity Logs</a>
		<a href="core/handleForms.php?logoutUserBtn=1">Logout</a>	
	</h3>	
</div>