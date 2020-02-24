<?php
	session_start();
	$mysql = mysqli_connect('localhost', 'root', '', 'shop');

	//print_r($_POST);
	//echo '<br><br>';
	//print_r($_FILES);

	if(!isset($_POST['title']))
		header('Location: ../add-product.php');

	// Product info
	$title = htmlspecialchars(trim($_POST['title']));
	$desc = htmlspecialchars(trim($_POST['description']));
	$p_price = $_POST['purchasePrice'];
	$s_price = $_POST['salePrice'];
	$discount = $_POST['discount'];
	$category = $_POST['category'];
	$mysqltime = date ("Y-m-d H:i:s");

	// Adding products to db
	$query = "INSERT INTO products(id, name, description, purchase_price, sale_price, discount, date, categoryID) 
			VALUES (
				'',
				'$title', 
				'$desc',
				$p_price,
				$s_price,
				$discount,
				'$mysqltime',
				$category
			)";
	if(!$mysql -> query($query)){
		die("ERROR: Couldn't add record. " . $mysql -> error());
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
	$preview_extension = mb_substr($_FILES['preview']['name'], strripos($_FILES['preview']['name'], '.'));
	// Creating new path to preview
	$preview_new_url = '../Images/product' . $id . '_preview' . $preview_extension;
	move_uploaded_file($_FILES['preview']['tmp_name'], '../' . $preview_new_url );
	$query = "INSERT INTO images(id, url, productID, isPreview) VALUES ('', '$preview_new_url', $id, true)";

	if(!$mysql -> query($query)){
		die("ERROR: Couldn't add record. " . $mysql -> error());
	}

	for($i = 0; $i < count($_FILES['images']['tmp_name']); $i++) {
		$image_extension = mb_substr($_FILES['images']['name'][$i], strripos($_FILES['images']['name'][$i], '.'));
		//echo '<br>' . $preview_extension;
		$images_new_url = '../Images/product' . $id . '_image' . $i . $image_extension;
		//echo  '<br>' .$images_new_url;

		move_uploaded_file($_FILES['images']['tmp_name'][$i], '../' . $images_new_url );
		$query = "INSERT INTO images(id, url, productID, isPreview) VALUES ('', '$images_new_url', $id, false)";

		if(!$mysql -> query($query)){
			die("ERROR: Couldn't add record. " . $mysql -> error());
		}
	}
	
	header('Location: ../products.php');

	$mysql -> close();
?>