<?php
	session_start();
	$mysql = mysqli_connect('localhost', 'root', '', 'shop');

	// print_r($_POST);
	// echo '<br>';
	// print_r($_FILES);
	
	if(!isset($_POST['id']))
		header('Location: ../workers.php');

	$id = $_POST['id'];
	$name = $_POST['name'];
	$surname = $_POST['surname'];
	$dob = $_POST['dob'];
	$phone = $_POST['phone'];
	$work_date = (isset($_POST['work_date']) && !empty($_POST['work_date'])) ? $_POST['work_date'] : date('Y-m-d');
	$post = $_POST['post'];

	$query = "UPDATE workers SET
			surname='$surname',
			name='$name',
			DOB='$dob',
			enter_date='$work_date',
			phone='$phone',
			post='$post'
		WHERE id=$id
	";

	if(!$mysql -> query($query)){
		die("ERROR: Couldn't add record. " . $mysql -> error);
	}

	if($_FILES['photo']['error'] != 4) {


		// Getting image extension
		$photo_extension = mb_substr($_FILES['photo']['name'], strripos($_FILES['photo']['name'], '.'));
		// Creating new path to photo
		$photo_new_url = '../Images/worker' . $id . '_photo' . $photo_extension;
		move_uploaded_file($_FILES['photo']['tmp_name'], '../' . $photo_new_url );

		$query = "UPDATE workers SET  
			photo = '$photo_new_url'
			WHERE id = $id
		";

		if(!$mysql -> query($query)){
			die("ERROR: Couldn't add record. " . $mysql -> error);
		}
	}

	header('Location: ../workers.php');

	$mysql -> close();
?>