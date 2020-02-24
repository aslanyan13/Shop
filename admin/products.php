<?php
	session_start();
	$mysql = mysqli_connect('localhost', 'root', '', 'shop');

	if(!isset($_SESSION['admin_id'])) {
		header('Location: sign-in.php');
	}

	$query = 'SELECT * FROM admins WHERE id=' . $_SESSION['admin_id'];

	$username = "";

	if($result = $mysql -> query($query)) {
		$row = $result -> fetch_array();
		$username = $row['username'];
	} else {
		die('ERROR: Could not execute query! ' . $mysql -> error());
	}

	$page = isset($_GET['page']) ? $_GET['page'] - 1: 0;


	$query = 'SELECT * FROM products ';

	if(isset($_GET['searchQuery']) && !empty($_GET['searchQuery'])) {
		$query .= 'WHERE name REGEXP "^.*' . trim($_GET['searchQuery']) . '.*$" ';
	}

	if(isset($_GET['sorting'])) {
		if($_GET['sorting'] == 'old') $query .= 'ORDER BY date';
		if($_GET['sorting'] == 'new') $query .= 'ORDER BY date DESC';
		if($_GET['sorting'] == 'priceUp') $query .= 'ORDER BY sale_price';
		if($_GET['sorting'] == 'priceDown') $query .= 'ORDER BY sale_price DESC';
		if($_GET['sorting'] == 'aZ') $query .= 'ORDER BY name';
		if($_GET['sorting'] == 'zA') $query .= 'ORDER BY name DESC';
	}

	$elements_in_page = 18;

	$query .= ' LIMIT ' . $page*$elements_in_page . ', ' . $elements_in_page;
	$row = [];

	if($result = $mysql -> query($query)) {
		while($row[] = $result -> fetch_array()) {}
	} else {
		die('ERROR: Could not execute query! ' . $mysql -> error);
	}
	$products = 0;
	$max_pages = 0;

	$query = "SELECT count(id) AS row_count FROM products";
	if($result = $mysql -> query($query)) {
		$tmp = $result -> fetch_array();
		$products = $tmp['row_count'];
		$max_pages = ceil($products / 18);
	} else {
		die('ERROR: Could not execute query! ' . $mysql -> error);
	}

	//print_r($row);
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

					<li class="selected">
						<a href="products.php">
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

			<!-- Here is products list -->
			<div id="page-wrapper">
				<form class="search" method="GET">
					<input type="search" name="searchQuery" placeholder="Product title..." value="<?php if(isset($_GET['searchQuery'])) echo $_GET['searchQuery']; ?>">
					<p>
						Sort by: 
						<select name="sorting">
							<option value="new" <?php if(isset($_GET['sorting']) && $_GET['sorting'] == 'new') echo 'selected'; ?>>Date (First newest)</option>
							<option value="old" <?php if(isset($_GET['sorting']) && $_GET['sorting'] == 'old') echo 'selected'; ?>>Date (First oldest)</option>
							<option value="priceUp" <?php if(isset($_GET['sorting']) && $_GET['sorting'] == 'priceUp') echo 'selected'; ?>>Price Up</option>
							<option value="priceDown" <?php if(isset($_GET['sorting']) && $_GET['sorting'] == 'priceDown') echo 'selected'; ?>>Price Down</option>
							<option value="Az" <?php if(isset($_GET['sorting']) && $_GET['sorting'] == 'Az') echo 'selected'; ?>>Alphabet (A-z)</option>
							<option value="zA" <?php if(isset($_GET['sorting']) && $_GET['sorting'] == 'zA') echo 'selected'; ?>>Alphabet (Z-a)</option>
						</select>
					</p>
					<input type="submit" class="btn btn-success" value="Search">
				</form>

				<?php
					if(count($row) - 1 == 0) {
						echo "<h2 class='text-center'>There are no products! <a href='add-product.php'>Add product</a>.</h2>";
					} else {
						echo '<p class="text-center page-select">';

						echo '<a href="products.php"><<</a> ';

						for($i = $page - 2; $i <= $page +2; $i++)
						{
							if($i <= 0 || $i > $max_pages) continue;
							echo "<a href='products.php?page=$i'>" . ($i) ." </a>";
						}

						echo "<a href='products.php?page=$max_pages'>>></a>";
						echo '</p>';
					}
					

					for($i = 0; $i < count($row) - 1; $i++) {
						$title = $row[$i]["name"];
						$desc = $row[$i]['description'];
						$price = $row[$i]['sale_price'];
						$purchase = $row[$i]['purchase_price'];
						$discount = $row[$i]['discount'];
						$id = $row[$i]['id'];
						$preview_url = '';

						$query = "SELECT * FROM images WHERE productID = $id AND isPreview=true";

						if($result = $mysql -> query($query)) {
							$tmp = $result -> fetch_array();
							$preview_url = $tmp['url'];
						}

						echo <<<BLOCK
						<div class="product-block col-lg-3 col-sm-4" id="product$i">
							<div class="product-block-inner">
								<h3>$title</h3>
								<img src="$preview_url">
								<p class="desc">
									$desc
								</p>
								<p>
									Price: <span class="price">$ $price</span>
								</p>
								<p>
									Discount: <span class="discount">$discount %</span>
								</p>
								<div class="product-controlls">
									<a href="product-info.php?id=$id" class="see"><i class="fa fa-eye"></i></a>
									<a href="edit-product.php?id=$id" class="edit"><i class="fa fa-edit"></i></a>
									<a href="php/delete-product.php?id=$id" class="remove"><i class="fa fa-trash-o"></i></a>
								</div>
							</div>
						</div>
						BLOCK;
					}
					
				?>
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
		var removeButtons = document.querySelectorAll('.remove');

		for(let i = 0; i < removeButtons.length; i++)
		{
			removeButtons[i].addEventListener('click', function (event) {
				let ans = confirm('Do you want to delete this product?');

				if(ans == false) 
					event.preventDefault();
			})
		}
	</script>

	<!-- modal -->
</body>
</html>