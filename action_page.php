<?php
	
include 'config/setup.php';
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$sql = "INSERT INTO `users` (`username`, `email`, `password`) VALUES ('$username', '$email', '$password')";
$stmt= $con->prepare($sql);
$result = $stmt->execute();
if ($result){
	$user_id = $con->lastInsertId();
	
	$_SESSION['id'] = $user_id;
	$_SESSION['username'] = $username;
	$_SESSION['email'] = $email;
}
session_start();
if (isset($_POST["submit"]))
{
	echo 'hjgfjffjghfgfh';
	if ($_POST["submit"])
	{
		echo '123456789';
		if ($_POST["submit"] === "submit")
		{
			echo '4';
//			if ($input_count == 3)
//			{
//				$result = $con->prepare("SELECT * FROM users");
//				$result->execute ();
//				$rows = $result->fetchAll();
//				foreach ($rows as $row)
//				{
//					if ($row['email'] == $email || $row['username'] == $username)
//					{
//						$count = 1;
//						array_push($errors, "This username/email is already exists");
//					}
//				}
//				if ($count == 0)
				{
					$sql = "INSERT INTO `users` (`username`, `email`, `password`) VALUES ('$username', '$email', '$password')";
					$stmt= $con->prepare($sql);
					$result = $stmt->execute();
					if ($result){
						$user_id = $con->lastInsertId();
						
						$_SESSION['id'] = $user_id;
						$_SESSION['username'] = $username;
						$_SESSION['email'] = $email;
					}	
				}
			}
		}
	}
//}

?>