<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
<body>
<form action="login.php" method="post">
	<div class="container">
		<label for="uname"><b>Username</b></label>
		<input type="text" placeholder="Enter Username" name="username" required>

		<label for="psw"><b>Password</b></label>
		<input type="password" placeholder="Enter Password" name="password" required>

		<button name="submit" value="login" type="submit">Login</button>
	</div>

</form>
</body>
<?php
require 'config/setup.php';
$errors = [];
if (isset($_SESSION["user"]))
header('location: ../camagru/index.php');
if (isset($_POST['submit']))
{
	echo '1';
	if ($_POST['submit'] == "login")
	{
		echo '2';
		if (!isset($_POST['username'], $_POST['password']))
			exit('Both username and password are required!');
		$username = $_POST['username'];
		$password = hash('sha256', $_POST['password']);
		$result = $con->prepare("SELECT * FROM users WHERE `username`=? AND `password`=?");
		$result->execute([$username, $password]);
		$user = $result->fetch();
		echo $user;
		session_start();
		echo $user;
		if ($user)
		{
		//	if ($user['verified'] == 1)
		//	{
				$user = array(
					'username' => $user['username'],
					'email' => $user['email'],
					'user_id' => $user['user_id']
				);
				$_SESSION['user'] = $user;
				header('location: ../camagru/index.php');
				die();
			}
			//else
			//	array_push($errors, "You have to verify your account");
		else 
		{
			array_push($errors, "Wrong username/password combination");
		}
	}
}
?>
</html>