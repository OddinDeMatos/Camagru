<?php
//require_once 'dataco.php';
require_once 'config/setup.php';
session_start();
if (isset($_POST["submit"]))
{
	if($_POST["submit"] === "Sign up")
	{
			$fullname = $var_name;
			$username = $var_user;
			$email = $var_email;
			$token = bin2hex(random_bytes(50));
			$passwd = $var_passwd;
			if ($input_count == 4)
			{
				$passwd = hash('sha256', $_POST['passwd']);
				$cpasswd = hash('sha256', $_POST['cpasswd']);
				$count = 0;

				$result = $con->prepare("SELECT * FROM users");
				$result->execute();
				$rows = $result->fetchAll();

				foreach ($rows as $row)
				{
					if ($row['email'] == $email || $row['username'] == $username)
					{
						$count = 1;
						array_push($errors,"This username/email is already exists");
					}
				}
				if ($count == 0)
				{
					$sql = "INSERT INTO `users` (`name`, `username`, `email`, `token`, `password`) VALUES (?, ?, ?, ?, ?)";
					$stmt= $con->prepare($sql);
					$result = $stmt->execute([$fullname, $username, $email, $token, $passwd]);
					if ($result){
						$user_id = $con->lastInsertId();
						sendVerificationEmail($email, $token);
						
						$_SESSION['id'] = $user_id;
						$_SESSION['username'] = $username;
						$_SESSION['email'] = $email;
						$_SESSION['verified'] = false;
						$_SESSION['message'] = 'You are logged in!';
						$_SESSION['type'] = 'alert-success';
					}	
				}
			}
	}
}
?>

<form action="action_page.php" method="POST">
	<div class="container">
	<h1>Sign Up</h1>
	<label for="username"><b>Username</b></label>
	<input type="text" placeholder="Enter Username" name="username" required>

	<label for="password"><b>Password</b></label>
	<input type="password" placeholder="Enter Password" name="password" required>

	<label for="email"><b>Email</b></label>
	<input type="email" placeholder="Enter Email" name="email" required>

	<div class="clearfix">
		<button type="submit" class="signupbtn" value="submit">submit</button>
	</div>
	</div>

</form>