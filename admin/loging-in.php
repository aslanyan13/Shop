<?php
	session_start();

	$mysql = mysqli_connect('localhost', 'root', '', 'shop');

	if($mysql === FALSE)
		die("ERROR: Could not connect to database. " . $mysql -> error());

	$username = '';
	$password = '';


	if(isset($_POST['username']) && isset($_POST['password']))
	{
		$username = $_POST['username'];
		$password = $_POST['password'];
	}

	$query = "SELECT * FROM admins WHERE username='$username'";

	if($result = $mysql -> query($query)) {
		if($result->num_rows > 0) {
			$row = $result -> fetch_array();

			if(password_verify($password, $row['password'])) {
				$_SESSION['admin_id'] = $row['id'];
				header('Location: index.php');
			} else {
				$_SESSION['errno'] = 2;
				header('Location: sign-in.php');
			}
		} else {
			$_SESSION['errno'] = 1;
			header('Location: sign-in.php');
		}
	} else {
		die('ERROR: Could not execute query! ' . $mysql -> error());
	}
?>