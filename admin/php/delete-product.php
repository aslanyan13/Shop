<?php 
	session_start();
	$mysql = mysqli_connect('localhost', 'root', '', 'shop');

	if(isset($_GET['id'])) {
		echo $_GET['id'];
	}

	$query = "DELETE FROM products WHERE id=" . $_GET['id'];

	if($mysql -> query($query)) {
		header('Location: ../products.php');
	} else {
		die("ERROR: Couldn't remove record. " . $mysql -> error());
	}

	$mysql -> close();
?>