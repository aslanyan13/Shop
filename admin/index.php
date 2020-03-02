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

	$query = "SELECT count(id) as prod_count FROM products";

	$products_count = 0;
	if($result = $mysql -> query ($query)) {
		if($result -> num_rows > 0) {
			$row = $result -> fetch_array();

			$products_count = $row['prod_count'] ;
		}
	} else {
		die('ERROR: Could not execute query! ' . $mysql -> error);
	}

	$query = "SELECT sum(count) as sales_count FROM sales";

	$sales_count = 0;
	if($result = $mysql -> query ($query)) {
		if($result -> num_rows > 0) {
			$row = $result -> fetch_array();

			$sales_count = $row['sales_count'] ;
		}
	} else {
		die('ERROR: Could not execute query! ' . $mysql -> error);
	}

	$sales_list = [];

	$query = "SELECT p.purchase_price, p.sale_price, p.discount, s.date, s.count FROM sales as s
			  LEFT JOIN products as p
			  ON s.productID = p.id";

	if($result = $mysql -> query ($query)) {
		while($sales_list[] = $result -> fetch_array()) {
		}
	} else {
		die('ERROR: Could not execute query! ' . $mysql -> error);
	}

	$profit = 0;

	for($i = 0; $i < count($sales_list) - 1; $i++) {
		if($sales_list[$i]['discount'] != 0)
			$profit += ($sales_list[$i]['sale_price'] * $sales_list[$i]['discount'] / 100 - $sales_list[$i]['purchase_price']) * $sales_list[$i]['count'];
		else 
			$profit += ($sales_list[$i]['sale_price'] - $sales_list[$i]['purchase_price']) * $sales_list[$i]['count'];
	}

	$query = 'SELECT count(id) as workers_count FROM workers';

	if($result = $mysql -> query($query)) {
		$row = $result -> fetch_array();

		$workers = $row['workers_count'];
	} else {
		die('ERROR: Could not execute query! ' . $mysql -> error());
	}

	$today_earning = 0;
	$today_sold = 0;

	$all_time_earning = 0;
	$all_time_sold = 0;

	$month_earning = 0;
	$month_sold = 0;

	$now = date("Y-m-d h:i:sa");
	$day_start = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
	$day_start = date("Y-m-d h:i:sa", $day_start);

	$month_start = mktime(0, 0, 0, date('m'), 1, date('Y'));
	$month_start = date("Y-m-d h:i:sa", $month_start);


	for($i = 0; $i < count($sales_list) - 1; $i++) {
		if($sales_list[$i]['date'] > $day_start) {
			$today_earning += $sales_list[$i]['sale_price'] * $sales_list[$i]['count'];
			$today_sold++;
		}
		if($sales_list[$i]['date'] > $month_start) {
			$month_earning += $sales_list[$i]['sale_price'] * $sales_list[$i]['count'];
			$month_sold++;
		}
		$all_time_earning += $sales_list[$i]['sale_price'] * $sales_list[$i]['count'];
		$all_time_sold++;
	}
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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
					<li class="active"><a href="index.php"><i class="lnr lnr-power-switch"></i><span>Dashboard</span></a></li>

					<li>
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
			<div id="page-wrapper">
				<div class="graphs">
					<div class="col_3">
						<div class="col-md-3 widget widget1">
							<div class="r3_counter_box">
								<i class="fa fa-shopping-basket"></i>
								<div class="stats">
								  <h5>
								  	<?php 
								  		echo ($products_count != 0) ? $products_count : '0'; 
								  	?>
								  </h5>
								  <div class="grow">
									<p>Products</p>
								  </div>
								</div>
							</div>
						</div>
						<div class="col-md-3 widget widget1">
							<div class="r3_counter_box">
								<i class="fa fa-cart-arrow-down"></i>
								<div class="stats">
								  <h5>
								  <?php 
								  		echo ($sales_count != 0) ? $sales_count : '0'; 
								  	?>
								  	</h5>
								  <div class="grow grow1">
									<p>Sales</p>
								  </div>
								</div>
							</div>
						</div>
						<div class="col-md-3 widget widget1">
							<div class="r3_counter_box">
								<i class="fa fa-users"></i>
								<div class="stats">
								  <h5>
								  	<?php
								  		echo ($workers != 0) ? $workers : '0';
								  	?>
								  </h5>
								  <div class="grow grow3">
									<p>Workers</p>
								  </div>
								</div>
							</div>
						 </div>
						 <div class="col-md-3 widget">
							<div class="r3_counter_box">
								<i class="fa fa-usd"></i>
								<div class="stats">
								  <h5><?php echo ($profit != 0) ? $profit : '0'; ?> <span>$</span></h5>
								  <div class="grow grow2">
									<p>Profit</p>
								  </div>
								</div>
							</div>
						</div>
						<div class="clearfix"> </div>
					</div>

			<!-- switches -->
			<div class="switches">
				<div class="col-4">
					<div class="col-md-4 switch-right">
						<div class="switch-right-grid">
							<div class="switch-right-grid1">
								<h3>TODAY'S STATS</h3>
								<p>Duis aute irure dolor in reprehenderit.</p>
								<ul>
									<li>Earning: $<?php echo ($today_earning != 0) ? $today_earning : '0'; ?> USD</li>
									<li>Items Sold: <?php echo ($today_sold != 0) ? $today_earning : '0'; ?> Items</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-4 switch-right">
						<div class="switch-right-grid">
							<div class="switch-right-grid1">
								<h3>MONTHLY STATS</h3>
								<p>Duis aute irure dolor in reprehenderit.</p>
								<ul>
									<li>Earning: $<?php echo ($month_earning != 0) ? $month_earning : '0'; ?> USD</li>
									<li>Items Sold: <?php echo ($month_sold != 0) ? $month_sold : '0'; ?> Items</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-md-4 switch-right">
						<div class="switch-right-grid">
							<div class="switch-right-grid1">
								<h3>ALLTIME STATS</h3>
								<p>Duis aute irure dolor in reprehenderit.</p>
								<ul>
									<li>Earning: $<?php echo ($all_time_earning != 0) ? $all_time_earning : '0'; ?> USD</li>
									<li>Items Sold: <?php echo ($all_time_sold != 0) ? $all_time_sold : '0'; ?> Items</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
			<!-- //switches -->
		</div>
		<!--body wrapper start-->
		<!--body wrapper end-->
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
</body>
</html>