<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
$username = ""; 

if (isset($_POST['submit'])) { 
	$required_fields = array("username", "password");
	validate_presences($required_fields);

	if (empty($errors)) { 
		$username = trim($_POST["username"]); 
		$password = trim($_POST["password"]); 
		$found_patient = patient_authenticate($username, $password); 
		$found_doctor  = doctor_authenticate($username, $password); 
		if ($found_patient) { 
			$_SESSION["patient_id"] = $found_patient["id"];
			$_SESSION["full_name"] = $found_patient["firstname"] . " " . $found_patient["lastname"];
			redirect_to("patient_content.php");
		} elseif ($found_doctor) {
			$_SESSION["doctor_id"] = $found_doctor["id"];
			$_SESSION["full_name"] = "Dr. " . $found_doctor["firstname"] . " " . $found_doctor["lastname"];
			redirect_to("doctor_content.php");
		} else {
			$_SESSION["message"] = "Username or password not found!";
		}
	}
} else {
} // end: if (isset($_POST['submit']))
?>
<?php include("../includes/header.php"); ?>

<nav class="navbar navbar-inverse navbar-lg navbar-embossed" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-9">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">Group Delta</a>
		</div>
		<div class="navbar-collapse collapse" id="navbar-collapse-9">
			<form class="navbar-form navbar-right" role="form" action="index.php" method="POST">
				<div class="form-group">
					<input type="text" placeholder="Username" class="form-control" name="username"  value="<?php echo htmlentities($username); ?>">
				</div>
				<div class="form-group">
					<input type="password" placeholder="Password" class="form-control" name="password" value="" >
				</div>
				<button type="submit" name="submit" class="btn btn-success">Sign in</button><br>
				<div class="form-group">
				<a href="forgot_password.php">Forgot Password?</a>
				</div>
			</form>
		</div><!--/.navbar-collapse -->
	</div>

	<div id="myCarousel" class="carousel hidden-sm slide" data-ride="carousel">
		<ol class="carousel-indicators">
			<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
			<li data-target="#myCarousel" data-slide-to="1"></li>
			<li data-target="#myCarousel" data-slide-to="2"></li>
			<li data-target="#myCarousel" data-slide-to="3"></li>
		</ol><!-- carousel-indicators -->

		<section class="carousel-inner">
			<div class="active item"><img src="img/03.jpg">
				<div class="carousel-caption">
					<h1>Welcome to our website!</h1>
				</div>
			</div>
			<div class="item"><img src="img/04.jpg"></div>
			<div class="item"><img src="img/02.jpg"></div>
			<div class="item"><img src="img/01.jpg"></div>
		</section><!-- carousel-inner -->

		<a href="#myCarousel" class="left carousel-control" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
		<a href="#myCarousel" class="right carousel-control" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
	</div><!-- myCarousel -->
</nav>
<section class="container">
	<?php echo message(); ?> <?php echo form_errors($errors); ?>
	<div class="row">
		<h3>Group Members</h3>
		<p style="padding:5px;border-radius:5px; text-align:center;" class="bg-primary">Ali Shaikh <small>(Manager) K1052280</small></p>
		<p style="padding:5px;border-radius:5px; text-align:center;" class="bg-danger">Hassan Azimi <small>(Programmer) K1221692</small></p>
		<p style="padding:5px;border-radius:5px; text-align:center;" class="bg-success">Lennard Graham <small>(Programmer) K1221683</small></p>
		<p style="padding:5px;border-radius:5px; text-align:center;" class="bg-info">Zeeshan Minhas <small>(Analyst) K1236469</small></p>
		<p style="padding:5px;border-radius:5px; text-align:center;" class="bg-warning">Hamza Ashraf <small>(Tester) K1217559</small></p>
	</div>
</section>
<br>
<br>
<?php include("../includes/footer.php"); ?>