<?php
	session_start();
	$mysql = mysqli_connect('localhost', 'root', '', 'shop');

	if(!isset($_POST['name']))
		header('Location: ../workers.php');

	$name = $_POST['name'];
	$surname = $_POST['surname'];
	$dob = $_POST['dob'];
	$phone = $_POST['phone'];
	$work_date = (isset($_POST['work_date']) && !empty($_POST['work_date'])) ? $_POST['work_date'] : date('Y-m-d');
	$post = $_POST['post'];

	// Adding worker to db
	$query = "INSERT INTO workers(id, surname, name, DOB, enter_date, phone, post) 
			VALUES (
				'',
				'$surname', 
				'$name',
				'$dob',
				'$work_date',
				'$phone',
				'$post'
			)";

	if(!$mysql -> query($query)){
		die("ERROR: Couldn't add record. " . $mysql -> error);
	}

	// Getting last added product id
	if($result = $mysql -> query ("SELECT last_insert_id();")) {
		$row = $result -> fetch_array();
		$id = $row['last_insert_id()'];
		// echo "<br>" . $id;
	} else {
		die("ERROR: Couldn't execute query. " . $mysql -> error);
	}

	// Getting image extension
	if(isset($_FILES['photo'])) {
		$photo_extension = mb_substr($_FILES['photo']['name'], strripos($_FILES['photo']['name'], '.'));

		// Creating new path to preview
		$photo_new_url = '../Images/worker' . $id . '_photo' . $photo_extension;
		move_uploaded_file($_FILES['photo']['tmp_name'], '../' . $photo_new_url);
	} else {
		$photo_new_url = '../Images/avatar-placeholder.gif';
	}
	
	$query = "UPDATE workers SET photo='$photo_new_url' WHERE id=$id";

	if(!$mysql -> query($query)){
		die("ERROR: Couldn't add record. " . $mysql -> error);
	}

	header('Location: ../workers.php');

	$mysql -> close();

?>