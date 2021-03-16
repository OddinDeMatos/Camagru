<?php
require 'dataco.php';
$errors = [];

if (isset($_POST['submit']))
{
	if ($_POST['submit'] == "Log in")
	{
		if (!isset($_POST['username'], $_POST['password']))
			exit('Both username and password are required!');
		$username = $_POST['username'];
		$password = hash('sha256', $_POST['password']);
		$result = $con->prepare("SELECT * FROM users WHERE `username`=? AND `password`=?");
		$user = $result->fetch();
		session_start();
	}
}
?>

<form action="action_page.php" method="post">
	<div class="container">
		<label for="uname"><b>Username</b></label>
		<input type="text" placeholder="Enter Username" name="uname" required>

		<label for="psw"><b>Password</b></label>
		<input type="password" placeholder="Enter Password" name="psw" required>

		<button type="submit">Login</button>
	</div>

</form>