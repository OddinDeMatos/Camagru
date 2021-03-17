<?php
//require_once 'dataco.php';
require_once 'config/setup.php';
session_start();
if (isset($_POST["submit"]))
{
	if($_POST["submit"] === "submit")
	{
			$username = $_POST["username"];
			$email = $_POST["email"];
			//$token = bin2hex(random_bytes(50));
			$password = $_POST["password"];
			if ($username && $email && $password)
			{
				$password = hash('sha256', $_POST['password']);
				$exist = FALSE;
				$result = $con->prepare("SELECT * FROM users");
				$result->execute();
				$rows = $result->fetchAll();

				foreach ($rows as $row)
				{
					if ($row['email'] == $email || $row['username'] == $username)
					{
						$exist = TRUE;
						array_push($errors,"This username/email is already exists");
					}
				}
				if (!$exist)
				{
					$sql = "INSERT INTO `users` (`username`, `email`, `password`) VALUES (?, ?, ?)";
					$stmt= $con->prepare($sql);
					$result = $stmt->execute([$username, $email, $password]);
					if ($result){
						$user_id = $con->lastInsertId();
						//sendVerificationEmail($email, $token);
						
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

<form action="signup.php" method="POST">
	<div class="container">
	<h1>Sign Up</h1>
	<label for="username"><b>Username</b></label>
	<input type="text" placeholder="Enter Username" name="username" required>

	<label for="password"><b>Password</b></label>
	<input type="password" placeholder="Enter Password" name="password" required>

	<label for="email"><b>Email</b></label>
	<input type="email" placeholder="Enter Email" name="email" required>

	<div class="clearfix">
		<button name="submit" type="submit" class="signupbtn" value="submit">submit</button>
	</div>
	</div>

</form>