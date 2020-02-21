<?php
	$mysql = mysqli_connect('localhost', 'root', '', 'shop');

	if(!$mysql) {
		die("Connection error! " . $mysql -> error());
	}

	if(isset($_POST['username']) && isset($_POST['password'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];

		$query = "INSERT INTO admins(id, username, password, avatar) VALUES ('', '$username', '" . password_hash($password, PASSWORD_DEFAULT) . "', '')";
		if($mysql -> query($query)) {
			echo "Admin added successfully!";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<form method="POST">
		<p><input type="text" name="username" placeholder="username"></p>
		<p><input type="password" name="password" placeholder="password"></p>
		<p><input type="submit"></p>
	</form>
</body>
</html>