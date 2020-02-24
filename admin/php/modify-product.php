<?php
	session_start();
	$mysql = mysqli_connect('localhost', 'root', '', 'shop');

	//print_r($_POST);
	//echo '<br><br>';
	//print_r($_FILES);

	if(!isset($_POST['title']))
		header('Location: ../add-product.php');

	// Product info
	$id = $_GET['id'];
	$title = $_POST['title'];
	$desc = $_POST['description'];
	$p_price = $_POST['purchasePrice'];
	$s_price = $_POST['salePrice'];
	$discount = $_POST['discount'];
	$category = $_POST['category'];
	$delete_images_list = $_POST['deleteImages'];
	$mysqltime = date ("Y-m-d H:i:s");

	// Adding products to db
	$query = "UPDATE products 
			SET
				name='$title', 
				description='$desc',
				purchase_price=$p_price,
				sale_price=$s_price,
				discount=$discount,
				categoryID=$category
			";
	if(!$mysql -> query($query)){
		die("ERROR: Couldn't add record. " . $mysql -> error);
	}

	if($_FILES['preview']['error'] != 4) {
		// Getting image extension
		$preview_extension = mb_substr($_FILES['preview']['name'], strripos($_FILES['preview']['name'], '.'));
		// Creating new path to preview
		$preview_new_url = '../Images/product' . $id . '_preview' . $preview_extension;
		move_uploaded_file($_FILES['preview']['tmp_name'], '../' . $preview_new_url );
		$query = "UPDATE images SET  
			url = '$preview_new_url'
			WHERE productID = $id AND isPreview = true
		";

		if(!$mysql -> query($query)){
			die("ERROR: Couldn't add record. " . $mysql -> error);
		}
	}

	for($i = 0; $i < count($_FILES['images']['tmp_name']); $i++) {
		if($_FILES['images']['error'][$i] == 4) continue;
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

	foreach ($delete_images_list as $id) {
		$query = "DELETE FROM images WHERE id=" . $id;

		if(!$mysql -> query($query)){
			die("ERROR: Couldn't add record. " . $mysql -> error());
		}
	}
	
	header('Location: ../products.php');

	$mysql -> close();
?>