<?php
	session_start();
	$mysql = mysqli_connect('localhost', 'root', '', 'shop');

	if(!isset($_SESSION['admin_id'])) {
		header('Location: sign-in.php');
	}
	if(!isset($_GET['id']))
		header('Location: products.php');

	$query = 'SELECT * FROM admins WHERE id=' . $_SESSION['admin_id'];

	$username = "";

	if($result = $mysql -> query($query)) {
		$row = $result -> fetch_array();

		$username = $row['username'];
	} else {
		die('ERROR: Could not execute query! ' . $mysql -> error());
	}

	$query = 'SELECT * FROM categories';
	$categories = [];

	if($result = $mysql -> query($query)) {
		while($row = $result -> fetch_array()) {
			$categories[] = $row['name'];
		}
	} else {
		die('ERROR: Could not execute query! ' . $mysql -> error());
	}

	$info = [];

	$query = 'SELECT * FROM products WHERE id=' . $_GET['id'];

	if($result = $mysql -> query($query)) {
		$info = $result -> fetch_array();
	} else {
		die('ERROR: Could not execute query! ' . $mysql -> error());
	}

	$query = 'SELECT * FROM images WHERE productID=' . $_GET['id'] . ' AND isPreview = true';

	$preview_url = '';
	if($result = $mysql -> query($query)) {
		$row = $result -> fetch_array();
		$preview_url = $row['url'];
	} else {
		die('ERROR: Could not execute query! ' . $mysql -> error());
	}

	$images_info = [];
	$query = 'SELECT * FROM images WHERE productID=' . $_GET['id'] . ' AND isPreview = false';

	if($result = $mysql -> query($query)) {
		while($row = $result -> fetch_array()) {
			$images_info[] = $row;
		}
		
	} else {
		die('ERROR: Could not execute query! ' . $mysql -> error());
	}

	$mysql -> close();
?>

<!DOCTYPE HTML>
<html>
<head>
	<title>Admin Panel</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="keywords" content="Easy Admin Panel Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template, 
	Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
	<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
	 <!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
	<!-- Custom CSS -->
	<link href="css/style.css" rel='stylesheet' type='text/css' />
	<!-- Graph CSS -->
	<link href="css/font-awesome.css" rel="stylesheet"> 
	<!-- jQuery -->
	<!-- lined-icons -->
	<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
	<!-- //lined-icons -->
	<!-- chart -->
	<script src="js/Chart.js"></script>
	<!-- //chart -->
	<!--animate-->
	<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
	<script src="js/wow.min.js"></script>
		<script>
			 new WOW().init();
		</script>
	<!--//end-animate-->
	<!----webfonts--->
	<link href='//fonts.googleapis.com/css?family=Cabin:400,400italic,500,500italic,600,600italic,700,700italic' rel='stylesheet' type='text/css'>
	<!---//webfonts---> 
	 <!-- Meters graphs -->
	<script src="js/jquery-1.10.2.min.js"></script>
	<!-- Placed js at the end of the document so the pages load faster -->

	<link href="css/myStyle.css" rel='stylesheet' type='text/css' />

</head> 
   
 <body class="sticky-header left-side-collapsed product"  onload="initMap()">
    <section>
    <!-- left side start-->
		<div class="left-side sticky-left-side">
			<!--logo and iconic logo start-->
			<div class="logo">
				<h1><a href="index.php">Easy <span>Admin</span></a></h1>
			</div>
			<div class="logo-icon text-center">
				<a href="index.php"><i class="lnr lnr-home"></i> </a>
			</div>

			<!--logo and iconic logo end-->
			<div class="left-side-inner">
				<!--sidebar nav start-->
				<ul class="nav nav-pills nav-stacked custom-nav">
					<li><a href="index.php"><i class="lnr lnr-power-switch"></i><span>Dashboard</span></a></li>

					<li class="active">
						<a href="index.php">
							<i class="lnr lnr-cart"></i>
							<span>Products</span>
						</a>
						<ul class="sub-menu-list">
							<li><a href="add-product.php">Add new product</a> </li>
						</ul>
						
					</li>

					<li><a href="sales.php"><i class="lnr lnr-pie-chart"></i>
						<span>Sales</span></a>
					</li>
					<li>
						<a href="workers.php">
							<i class="lnr lnr-users"></i>
							<span>Workers</span>
						</a>
					</li>
				</ul>
				<!--sidebar nav end-->
			</div>
		</div>
		<!-- left side end-->
    
		<!-- main content start-->
		<div class="main-content">
			<!-- header-starts -->
			<div class="header-section">
			 
			<!--toggle button start-->
			<a class="toggle-btn  menu-collapsed"><i class="fa fa-bars"></i></a>
			<!--toggle button end-->

			<!--notification menu start -->
			<div class="menu-right">
				<div class="user-panel-top">  	
					<div class="profile_details">		
						<ul>
							<li class="dropdown profile_details_drop">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
									<div class="profile_img">	
										<span style="background:url(images/1.jpg) no-repeat center"> </span> 
										 <div class="user-name">
											<p>
												<?php if (isset($username))
													echo $username;
												?>
												<span>Administrator</span>
											</p>
										 </div>
										 <i class="lnr lnr-chevron-down"></i>
										 <i class="lnr lnr-chevron-up"></i>
										<div class="clearfix"></div>	
									</div>	
								</a>
								<ul class="dropdown-menu drp-mnu">
									<li> <a href="logout.php"><i class="fa fa-sign-out"></i> Logout</a> </li>
								</ul>
							</li>
							<div class="clearfix"> </div>
						</ul>
					</div>		
					<div class="social_icons">
						<div class="col-md-4 social_icons-left">
							<a href="#" class="yui"><i class="fa fa-facebook i1"></i><span>300<sup>+</sup> Likes</span></a>
						</div>
						<div class="col-md-4 social_icons-left pinterest">
							<a href="#"><i class="fa fa-google-plus i1"></i><span>500<sup>+</sup> Shares</span></a>
						</div>
						<div class="col-md-4 social_icons-left twi">
							<a href="#"><i class="fa fa-twitter i1"></i><span>500<sup>+</sup> Tweets</span></a>
						</div>
						<div class="clearfix"> </div>
					</div>            	
					<div class="clearfix"></div>
				</div>
			  </div>
			<!--notification menu end -->
			</div>
			<!-- //header-ends -->

			<!-- Form -->
			<div id="page-wrapper">
				<form class="add-product container" action="php/modify-product.php?id=<?php echo $_GET['id']; ?>" method="POST" enctype="multipart/form-data">
					<h1>Edit product</h1>

					<!-- Product title -->
					<p>
						<div>Product title*</div>
						<input type="text" name="title" placeholder="Example: Coffee" required value="<?php echo $info['name']; ?>">
					</p>
					<p>
						<div>Product description*</div>
						<textarea placeholder="Some words about products..." required maxlength="1000" name="description"><?php echo $info['description']; ?></textarea>
						<br>
						<span id="textareaInfo">max length: 1000 characters</span>
					</p>
					<p class="imgPreview">
						<div>Select another preivew image</div>
						<input type="file" id="preview" name="preview" accept="image/*">


					</p>
					<img src="<?php echo $preview_url; ?>" style="max-width: 200px; max-height: 300px" id="previewImage">
					<p>
						<div>More images (optional)</div>
						<input type="file" id="images" name="images[]" accept="image/*" multiple>
						<div class="row" id="loadedImages">
							<?php 
								for ($i = 0; $i < count($images_info) - 1; $i++) {
									$url = $images_info[$i]['url'];
									$id = $images_info[$i]['id'];
									echo " 
									<div class='imageSmall' style='background: url($url); background-size: cover; background-position: 50% 50%;' id='$id'>
										<i class='fa fa-minus-circle' id='deleteExistImage'></i>
									</div>";
								}
							?>
							<label class="images_label" for="images">
								<i class="fa fa-upload"></i>
							</label>
						</div>
						
					</p>
					<p>
						<div>Avalible*</div>
						<input type="number" id="avalible" name="avalible" value="<?php echo $info['avalible']; ?>" min="1" required>
					</p>
					<p>
						<div>Purchase price*</div>
						<input type="number" id="purchasePrice" name="purchasePrice" min="0" required value="<?php echo $info['purchase_price']; ?>">
					</p>
					<p>
						<div>Sale price*</div>
						<input type="number" id="salePrice" name="salePrice" min="0" required value="<?php echo $info['sale_price']; ?>">
						<span id="salePriceInfo"></span>
					</p>
					<p>
						<div>Discount % (optional)</div>
						<input type="number" id="discount" name="discount" min="0" max="100" required value="<?php echo $info['discount']; ?>">
						<span id="discountInfo"></span>
					</p>
					<p>
						<div>Product category*</div>
						<select required name="category">
							<?php  
								for ($i = 0; $i < count($categories); $i++) {
									echo '<option value="' . strval($i + 1) . '">' . $categories[$i] . '</option>';
								}
							?>
						</select>
					</p>
					<input type="submit" value="Save changes" class="btn btn-primary">
					<input type="button" value="Cancel" class="btn btn-secondary" onclick="location.href='products.php'">

					<select class="hidden" name="deleteImages[]" id="deletedImagesList" multiple>
					</select>
				</form>
			</div>
       		<!--footer section start-->
			<footer>
			   <p>&copy 2020 Easy Admin Panel. All Rights Reserved</p>
			</footer>
        	<!--footer section end-->

      <!-- main content end-->
   </section>
  
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.min.js"></script>

	<script type="text/javascript">
		document.addEventListener("DOMContentLoaded", function(event) {

			const deleteExistsImgButton = document.querySelectorAll('#deleteExistImage');

			for(let i = 0; i < deleteExistsImgButton.length; i++) {
				deleteExistsImgButton[i].addEventListener('click', function() {
					var imageIndex = parseInt(deleteExistsImgButton[i].parentElement.id);
					// alert(imageIndex);

					let node = document.createElement("option");
					node.value = imageIndex;
					node.selected = 'selected';
					document.getElementById('deletedImagesList').appendChild(node);
					deleteExistsImgButton[i].parentElement.remove();
				})
			}

			const form = document.querySelector('form');

			const imagesUploadButton = document.getElementById('images');
			const imagesUpload = document.getElementById('loadedImages');

			const previewUploadButton = document.getElementById('preview');
			const previewUpload = document.querySelector('.imgPreview');

			const textarea = document.querySelector('textarea');
			const textInfo = document.getElementById('textareaInfo');

			const purchase = document.getElementById('purchasePrice');
			const sale = document.getElementById('salePrice');
			const discount = document.getElementById('discount');

			var formdata = new FormData();

			var deleteImageButton;
			let fileList = new DataTransfer();

			const removeFileFromList = (transferList, index) => {
				let tmp = new DataTransfer();
				for(let i = 0; i < transferList.items.length; i++) {
					if(i == index) {
						// alert(transferList.files[i].name)
						continue;
					}
					tmp.items.add(transferList.files[i]);
				}
				return tmp;
			}

			// Adding image to file list
			const addImage = () => {
				let files = imagesUploadButton.files;
				for(let i = 0; i < files.length; i++)
					fileList.items.add(files[i]);

				console.dir(fileList)

				for(let i = 0; i < files.length; i++){
					let node = document.createElement("div");

					node.classList.add('imageSmall');
					node.id = i; // Image ID
					node.innerHTML = `
						<div class="imageSmall">
							<i class="fa fa-minus-circle" id="deleteImage"></i>
						</div>`;

					node.style.background = 'url('  + URL.createObjectURL(files[i]) + ')';
					node.style.backgroundSize = 'cover';
					node.style.backgroundPosition = '50% 50%';
					imagesUpload.prepend(node);

					deleteImageButton = document.getElementById('deleteImage');
					deleteImageButton.addEventListener('click', function() {
						var imageIndex = parseInt(this.parentElement.parentElement.id);
						fileList = removeFileFromList(fileList, imageIndex);
						//console.dir(fileList);
						this.parentElement.parentElement.remove();
					});
				}

				// Image Deleting from list

			}

			const showPreview = () => {
				let files = previewUploadButton.files;

				document.getElementById('previewImage').src = URL.createObjectURL(files[0]);
			}

			imagesUploadButton.addEventListener('change', addImage);
			previewUploadButton.addEventListener('change', showPreview)

			textarea.addEventListener('input', function () {
				if(textarea.value == 0)
					textInfo.innerHTML = 'max length: 1000 characters';
				else 
					textInfo.innerHTML = 'Entered ' + textarea.value.length + '/1000 characters';
			})

			purchase.addEventListener('input', function () {
				sale.value = parseFloat(this.value);
				document.getElementById('salePriceInfo').innerHTML = '';
				document.getElementById('discountInfo').innerHTML = '';	
			});
			sale.addEventListener('input', function () {
				if(this.value.length != 0)
					document.getElementById('salePriceInfo').innerHTML = 'Profit: $' + ( parseFloat(sale.value) - parseFloat(purchase.value) );
				else 
					document.getElementById('salePriceInfo').innerHTML = '';
				document.getElementById('discountInfo').innerHTML = '';	
			});
			discount.addEventListener('input', function () {
				if(this.value.length != 0)
					document.getElementById('discountInfo').innerHTML = 'Price with discount: $' + (parseFloat(sale.value) - parseFloat(sale.value) * parseInt(this.value) / 100);
				else
					document.getElementById('discountInfo').innerHTML = '';	
			});

			// Giving fileList to form input
			form.addEventListener('submit', function (evnt) {
				imagesUploadButton.files = fileList.files;
				// alert(imagesUploadButton.files.length);
			})
		})
	</script>

	<!-- modal -->
</body>
</html>