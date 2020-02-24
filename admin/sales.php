<?php
	session_start();
	$mysql = mysqli_connect('localhost', 'root', '', 'shop');

	if(!isset($_SESSION['admin_id'])) {
		header('Location: sign-in.php');
	}

	$query = 'SELECT * FROM admins WHERE id=' . $_SESSION['admin_id'];

	$page = isset($_GET['page']) ? $_GET['page'] - 1: 0;

	$username = "";

	if($result = $mysql -> query($query)) {
		$row = $result -> fetch_array();

		$username = $row['username'];
	} else {
		die('ERROR: Could not execute query! ' . $mysql -> error);
	}

	$sales = 0;
	$query = "SELECT count(id) AS row_count FROM sales";

	if($result = $mysql -> query($query)) {
		$tmp = $result -> fetch_array();
		$sales = $tmp['row_count'];
		$max_pages = ceil($sales / 18);
	} else {
		die('ERROR: Could not execute query! ' . $mysql -> error);
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
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha/js/bootstrap.min.js"></script>
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

					<li>
						<a href="products.php">
							<i class="lnr lnr-cart"></i>
							<span>Products</span>
						</a>
						<ul class="sub-menu-list">
							<li><a href="add-product.php">Add new product</a> </li>
						</ul>
						
					</li>

					<li class="active"><a href="sales.php"><i class="lnr lnr-pie-chart"></i>
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

			<div id="page-wrapper">
				<?php  
					echo '<table class="table table-hover">';
					echo '<thead>';
						echo '<tr>';
						 	echo '<th scope="col">ID</th>';
						 	echo '<th scope="col">Product</th>';
						 	echo '<th scope="col">Purchase price</th>';
						 	echo '<th scope="col">Sale price</th>';
						 	echo '<th scope="col">Profit</th>';
						 	echo '<th scope="col">Date</th>';
						 echo '</tr>';
					echo '</thead>';
					

					$query = 
					"SELECT s.id, p.name, p.sale_price, p.purchase_price, p.discount, s.date FROM sales as s
					LEFT JOIN products as p
					ON s.productID = p.id;";

					echo '<tbody>';

					$total_sales_price = 0;
					$total_count = 0;
					$total_purchase = 0;
					$total_profit = 0;

					if ($result = $mysql -> query($query)) {
						while($row = $result -> fetch_array()) {
							$discount = $row['discount'];
							if($discount != 0)
								$price_with_discount = $row['sale_price'] * $discount / 100;
							else
								$price_with_discount = $row['sale_price'];

							$total_profit += $price_with_discount - $row['purchase_price'];
							$total_sales_price += $price_with_discount;
							$total_purchase += $row['purchase_price'];
							$total_count++;

							if(($row['sale_price'] - $row['purchase_price']) > 0) {
								echo '<tr class="success">';
							} else if (($row['sale_price'] - $row['purchase_price']) == 0) {
								echo '<tr class="warning">';
							} else {
								echo '<tr class="danger">';
							}
								echo "<th scope='row'>" . $row['id'] . "</th>";
								echo "<td>" .$row['name']. "</td>";
								echo "<td> $" .$row['purchase_price']. "</td>";
								echo "<td> $" .$row['sale_price']. " ($ " . $price_with_discount . " with discount) </td>";
								echo "<td> $" . ($price_with_discount - $row['purchase_price']) . "</td>";
								echo "<td>" .$row['date']. "</td>";
							echo '</tr>';
						}
 					} else {
						die('ERROR: Could not execute query! ' . $mysql -> error);
					}

					echo '</tbody>';
					echo '</table>';

					echo '<table class="table table-hover totals">';
					echo '<thead>';
						echo '<tr>';
						 	echo '<th scope="col">Sales Count</th>';
						 	echo '<th scope="col">Total purchase</th>';
						 	echo '<th scope="col">Total sale</th>';
						 	echo '<th scope="col">Total profit</th>';
						 echo '</tr>';
					echo '</thead>';
					echo '<tbody>';
						echo '<tr>';
							echo '<td scope="row">' . $total_count . '</td>';
						 	echo '<td> $' . $total_purchase . '</td>';
						 	echo '<td> $' . $total_sales_price . '</td>';
						 	if($total_profit < 0)
						 		echo '<td class="danger">';
						 	else if($total_profit == 0)
						 		echo '<td class="warning">';
						 	else
						 		echo '<td class="success">';
						 	echo $total_profit . '</td>';
						echo '</tr>';
					echo '</tbody>';

					echo '</table>';

					echo '<p class="text-center page-select">';

					echo '<a href="sales.php"><<</a> ';

					for($i = $page - 2; $i <= $page +2; $i++)
					{
						if($i <= 0 || $i > $max_pages) continue;
						echo "<a href='sales.php?page=$i'>" . ($i) ." </a>";
					}

					echo "<a href='sales.php?page=$max_pages'>>></a>";
					echo '</p>';
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
</body>
</html>