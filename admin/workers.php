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

	<div id="addWorkerModal" class="modal fade" role="dialog">
	  <form class="modal-dialog" action="php/add-worker.php" method="POST" enctype="multipart/form-data">
	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Add worker</h4>
	      </div>
	      <div class="modal-body">
	      	<div class="worker-photo-preview"></div>
	      	<p>
	      		<b>Photo:</b> <br>
	      		<input type="file" name="photo" id="uploadPhoto" accept="image/*">
	      	</p>
	      	<p>
	      		<b>Full Name*։</b> <br>
	      		<input type="text" name="surname" placeholder="Surname" required>
	      		<input type="text" name="name" placeholder="Name" required>
	      	</p>
	      	<p>
				<b>Date of birth*:</b> <br>
				<input type="date" name="dob" required>
	      	</p>
	      	<p>
				<b>Phone*:</b> <br>
				<input type="phone" name="phone" placeholder="+0 000 000-0000" required>
	      	</p>
	      	<p>
				<b>Work since:</b> <br>
				<input type="date" name="work_date"> <br>
				<b>Notice</b>: if not set, automaticly set today
	      	</p>
	      	<p>
				<b>Post*:</b> <br>
				<input type="text" name="post" placeholder="Example: manager" required>
	      	</p>
	      </div>
	      <div class="modal-footer">
	      	<input type="submit" value="Add worker" class="btn btn-primary">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>
	  </form>
	</div>

	<div id="editWorkerModal" class="modal fade" role="dialog">
	  <form class="modal-dialog" action="php/modify-worker.php" method="POST" enctype="multipart/form-data">

	    <!-- Modal content-->
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	        <h4 class="modal-title">Edit worker info</h4>
	      </div>
	      <div class="modal-body">
	      	<div class="worker-photo-preview"></div>
	      	<input type="number" id="worker-id" name="id" style="display: none">
	      	<p>
	      		<b>Photo:</b> <br>
	      		<input type="file" name="photo" id="uploadPhoto">
	      	</p>
	      	<p>
	      		<b>Full Name*։</b> <br>
	      		<input type="text" name="surname" id="surname">
	      		<input type="text" name="name" id="name">
	      	</p>
	      	<p>
				<b>Date of birth*:</b> <br>
				<input type="date" name="dob" id="dob">
	      	</p>
	      	<p>
				<b>Phone*:</b> <br>
				<input type="phone" name="phone" id="phone">
	      	</p>
	      	<p>
				<b>Work since:</b> <br>
				<input type="date" name="work_date" id="work_date"> <br>
				<b>Notice</b>: if not set, automaticly set today
	      	</p>
	      	<p>
				<b>Post*:</b> <br>
				<input type="text" name="post" id="post">
	      	</p>
	      </div>
	      <div class="modal-footer">
	      	<input type="submit" value="Save changes" class="btn btn-primary">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	      </div>
	    </div>

	  </form>
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
					<li class="active"><a href="workers.php">
						<i class="lnr lnr-users"></i>
						<span>Workers</span></a>
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
					echo '<table class="workers-table table table-hover table-responsive-md">';
					echo '<thead>';
						echo '<tr>';
						 	echo '<th scope="col">#</th>';
						 	echo '<th scope="col">Image</th>';
						 	echo '<th scope="col">Surname</th>';
						 	echo '<th scope="col">Name</th>';
						 	echo '<th scope="col">Birth date</th>';
						 	echo '<th scope="col">Phone</th>';
						 	echo '<th scope="col">Work since</th>';
						 	echo '<th scope="col">Post</th>';
						 	echo '<th scope="col">Modify</th>';
						 echo '</tr>';
					echo '</thead>';

					$query = "SELECT * FROM workers";

					echo '<tbody>';

					if ($result = $mysql -> query($query)) {
						while($row = $result -> fetch_array()) {
							$age = floor((time() - strtotime($row['DOB'])) / 31556926);

							echo '<tr>';
								echo "<th scope='row' id='t-id'>" . $row['id'] . "</th>";
								echo '<td><div class="worker-image" style="background: url(' .$row['photo'] . ') 50% 50%; background-size: cover;"></div></td>';
								echo '<td id="t-surname">' . $row['surname'] . '</td>';
								echo '<td id="t-name">' . $row['name'] . '</td>';
								echo '<td><span class="b-day">' . $row['DOB'] . '</span> <br>(<b>' . $age .' y.o.</b>)</td>';
								echo '<td id="t-phone">' . $row['phone'] . '</td>';
								echo '<td id="t-enter_date">' . $row['enter_date'] . '</td>';
								echo '<th id="t-post">' . $row['post'] . '</th>';

								echo '<td class="worker-modify">
										<a href="#" data-toggle="modal" data-target="#editWorkerModal" class="worker-modify-btn" id="worker-edit"><i class="fa fa-pencil-square-o"></i></a>
										<a href="php/delete-worker.php?id=' . $row['id'] . '" class="worker-modify-btn" id="worker-delete"><i class=" fa fa-times-circle"></i></a>
									  </td>';
							echo '</tr>';
						}
 					} else {
						die('ERROR: Could not execute query! ' . $mysql -> error);
					}

					echo '<tr>';

						echo "<th class='worker-add' scope='row' colspan='9'>
								<a href='#' data-toggle='modal' data-target='#addWorkerModal'><i class='fa fa-plus'></i> Add new worker</a>
							  </th>";
					echo '</tr>';

					echo '</tbody>';
					echo '</table>';
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
		const addUploadPhoto = document.querySelector('#addWorkerModal #uploadPhoto');
		const addWorkerPreview = document.querySelector('#addWorkerModal .worker-photo-preview');

		const editUploadPhoto = document.querySelector('#editWorkerModal #uploadPhoto');
		const editWorkerPreview = document.querySelector('#editWorkerModal .worker-photo-preview');

		const editWorkerModal = document.querySelector('#editWorkerModal')

		const workerEditButtons = document.querySelectorAll('#worker-edit');

		for (var i = 0; i < workerEditButtons.length; i++) {

			workerEditButtons[i].addEventListener('click', function () {
				const row = this.parentElement.parentElement;

				let name = row.querySelector('#t-name').innerHTML;
				let surname = row.querySelector('#t-surname').innerHTML;
				let id = row.querySelector('#t-id').innerHTML;
				let phone = row.querySelector('#t-phone').innerHTML;
				let work_date = row.querySelector('#t-enter_date').innerHTML;
				let post = row.querySelector('#t-post').innerHTML;
				let dob = row.querySelector('.b-day').innerHTML;

				let imageUrl = row.querySelector('.worker-image').style.background;
				
				editWorkerModal.querySelector('#name').value = name;
				editWorkerModal.querySelector('#surname').value = surname;
				editWorkerModal.querySelector('#dob').value = dob;
				editWorkerModal.querySelector('#phone').value = phone;
				editWorkerModal.querySelector('#work_date').value = work_date;
				editWorkerModal.querySelector('#post').value = post;
				editWorkerModal.querySelector('#worker-id').value = id;
				editWorkerModal.querySelector('.worker-photo-preview').style.background = imageUrl;

			});

		}

		addUploadPhoto.addEventListener('change', function () {
			let files = addUploadPhoto.files;
			addWorkerPreview.style.background = 'url("' + URL.createObjectURL(files[0]) + '")';
			addWorkerPreview.style.backgroundSize = 'cover';
			addWorkerPreview.style.backgroundPosition = '50% 50%';
		});

		editUploadPhoto.addEventListener('change', function () {
			let files = editUploadPhoto.files;
			editWorkerPreview.style.background = 'url("' + URL.createObjectURL(files[0]) + '")';
			editWorkerPreview.style.backgroundSize = 'cover';
			editWorkerPreview.style.backgroundPosition = '50% 50%';
		});


	</script>
</body>
</html>