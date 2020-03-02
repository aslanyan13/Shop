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
   
 <body class="sticky-header left-side-collapsed"  onload="initMap()">
	<div class="dark-wrapper">
		
	</div>

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
				<form class="add-product product-info container" action="php/add-product.php" method="POST" enctype="multipart/form-data">
					<h1>Product info</h1>

					<!-- Product title -->
					<p>
						<h4>Product title</h4>
						<?php echo $info['name']; ?>
					</p>
					<p>
						<h4>Product description</h4>
						<?php echo $info['description']; ?>
					</p>
					<p class="imgPreview">
						<h4>Preview image</h4>
						<img src="<?php echo $preview_url; ?>" style="max-width: 200px; max-height: 300px">
					</p>
					<p>
						<h4>Images</h4>
						<div class="row" id="loadedImages">
							<?php 
								for ($i = 0; $i < count($images_info) - 1; $i++) {
									$url = $images_info[$i]['url'];
									echo " 
									<div class='imageSmall' style='background: url($url); background-size: cover; background-position: 50% 50%;'>
									</div>";
								}
							?>
						</div>
						
					</p>
					<p>
						<div>Avalible: <?php echo $info['avalible']; ?></div>
					</p>
					<p>
						<div>Purchase price: $ <?php echo $info['purchase_price']; ?></div>
					</p>
					<p>
						<div>Sale price: $ <?php echo $info['sale_price']; ?></div>
					</p>
					<p>
						<div>Discount: <?php echo $info['discount']; ?> $</div>
					</p>
					<p>
						<div>Product category: <?php echo $categories[$info['categoryID'] - 1]; ?></div>
					</p>
					<input type="button" value="Back" class="btn btn-secondary" onclick="location.href='products.php'">
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

	<script>
		var images = document.querySelectorAll('.imageSmall');
		var darkWrapper = document.querySelector('.dark-wrapper');

		for(let i = 0; i < images.length; i++)
		{
			images[i].addEventListener('click', function () {
				darkWrapper.style.display = 'flex';
				let imageUrl = images[i].style.backgroundImage;

				let urlStart = imageUrl.indexOf('"');
				let urlEnd = imageUrl.lastIndexOf('"');

				imageUrl = imageUrl.substr(urlStart + 1, urlEnd -2 - urlStart + 1);

				let node = document.createElement('img');
				node.classList.add('image-full');
				node.src = imageUrl;
				darkWrapper.appendChild(node);
				darkWrapper.addEventListener('click', function(event) {
					if(event.target.className == 'dark-wrapper') {
						darkWrapper.innerHTML = '';
						darkWrapper.style.display = 'none';
					}
				})
			})
		}
	</script>
	<!-- modal -->
</body>
</html>