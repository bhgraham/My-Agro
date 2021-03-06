<?php
require_once("db/db.php");
session_start();
if($_SESSION['email']==""|| $_SESSION['pass']=="") 
{
    header("location: ../login.html"); 
    exit();
}
$sid=$_SESSION["id"];
?>
<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Farmers Profile</title>
    <script src="http://s.codepen.io/assets/libs/modernizr.js" type="text/javascript"></script>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
	<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
	<script src="js/prefixfree.min.js"></script>
	<link rel="stylesheet" href="css/ProfileStyle.css">
  </head>

  <body>
		<div class="header navbar-fixed-top">
			<table>
				<tr>
					<td style = "color:white;width:100%"><img src="img/logo.png"></td>
					<td style = "color:black;" class="text-right">
						<button type="button" onClick="openNav()">
							<i style="font-size:20px;" class="glyphicon glyphicon-menu-hamburger"></i>
						</button>
					</td>
				</tr>
			</table>
		</div>		
		<div id="mySidenav" class="sidenav">
			<a href="javascript:void(0)" class="closebtn" onClick="closeNav()"><i class="glyphicon glyphicon-minus"></i></a>
			<a href="FarmersProfile.php" class="active"><i class="glyphicon glyphicon-home"></i>&nbsp;Home</a>
			<a href="Profile.php"><i class="glyphicon glyphicon-user"></i>&nbsp;Profile</a>
			<a href="bid/index.php"><i class="glyphicon glyphicon-king"></i>&nbsp;Bid</a>
			<a href="Search.php"><i class="glyphicon glyphicon-search"></i>&nbsp;Search</a>
			<a href="PublicChat.php"><i class="glyphicon glyphicon-envelope"></i>&nbsp;Chat</a>
			<a href="weather/index.html"><i class="glyphicon glyphicon-info-sign"></i>&nbsp;Climate</a>
			<a href="tips_add_tricks/index.html"><i class="glyphicon glyphicon-edit"></i>&nbsp;Tips and tricks</a>
			<a href="Finance/index.php"><i class="glyphicon glyphicon-usd"></i>&nbsp;Finance</a>
			<a href="Ecommerce/index.php"><i class="glyphicon glyphicon-shopping-cart"></i>&nbsp;E-commerce</a>
			<a href="Logout.php"><i class="glyphicon glyphicon-off"></i>&nbsp;Logout</a>
		</div>
		<section class="farmer-progress">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<br><br><br><br>
					</div>
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3>Progress</h3>
							</div>
							<div class="panel-body">
								<h4>Target of year</h4>
								<div class="progress">
									<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:40%">
										40%
									</div>
								</div>
								<h4>Trend in agriculture</h4>
								<div class="progress">
									<div class="progress-bar progress-bar-danger" role="progressbar" style="width:20%">
										Yesterday
									</div>
									<div class="progress-bar progress-bar-warning" role="progressbar" style="width:30%">
										Today
									</div>
									<div class="progress-bar progress-bar-success" role="progressbar" style="width:50%">
										Tommorow
									</div>
								</div>
							</div>
							<div class="panel-footer text-center">
								<button class="btn btn-primary">View complete chart</button>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3>Weather</h3>
							</div>
							<div class="panel-body">
								<div id="weather"></div>
								<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
								<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery.simpleWeather/3.1.0/jquery.simpleWeather.min.js'></script>
								<script src="js/index.js"></script>
							</div>
							<div class="panel-footer text-center">
								<a role="button" class="btn btn-primary" href="weather/index.html">View detailed report</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3>Notifications</h3>
							</div>
							<div class="panel-body" style="max-height:300px;scroll:auto;">
								<table class="table table-striped">
									<?php
										$notification=mysql_query("SELECT * FROM notification WHERE id='$sid' ORDER BY `nid` DESC  LIMIT 10");
										while($row=mysql_fetch_array($notification))
										{
											$msg=$row['msg'];
											echo '<tr><td>'.$msg.'</td></tr>';
										}
									?>
								</table>
							</div>
							<div class="panel-footer text-center">
								<a class="btn btn-primary" role="button" href="notification.php">Show all</a>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3>Post for followers</h3>
							</div>
							<div class="panel-body">
								<textarea placeholder="Enter your posts"></textarea>	
							</div>
							<div class="panel-footer text-center">
								<button class="btn btn-primary">Post</button>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3>peoples to follow </h3>
							</div>
							<div class="panel-body">
								<?php
								$sql_res=mysql_query("select * from profile where  uid!='$sid'");
								$count=mysql_num_rows($sql_res);
								if($count>0)
								{
									while($row=mysql_fetch_array($sql_res))
									{
										$uid=$row['uid'];
										$fname=$row['fname'];
										$lname=$row['lname'];
										$img=$row['profilepic'];
										echo'
											<div class="col-md-3 text-center">
												<img src="'.$img.'" class="img img-rounded  img-responsive">
												<p>'.$fname.'&nbsp;'.$fname.'</p>
												<a href="ViewProfile.php?uid='.$uid.'" role="button" class="btn btn-success">View profile</a>
											</div>
										';
									}
								}
								else 
								{
									$result= "No result found!";
								}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<div class="col-md-12">
			<br><br><br><br>
		</div>
		<footer>
			All rights are reserved by team My-Agro &copy;
		</footer>
	<script>
		function openNav() {
		    document.getElementById("mySidenav").style.width = "250px";
		    document.getElementById("main").style.marginLeft = "250px";
		}

		function closeNav() {
		    document.getElementById("mySidenav").style.width = "0";
		    document.getElementById("main").style.marginLeft= "0";
		}
	</script>
  </body>
</html>
