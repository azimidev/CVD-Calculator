<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
$username = "";
if(isset($_POST['submit'])) {
	$required_fields = array("username", "password");
	validate_presences($required_fields);
	if(empty($errors)) {
		$username      = trim($_POST["username"]);
		$password      = trim($_POST["password"]);
		$found_patient = patient_authenticate($username, $password);
		$found_doctor  = doctor_authenticate($username, $password);
		if($found_patient) {
			$_SESSION["patient_id"] = $found_patient["id"];
			$_SESSION["full_name"]  = $found_patient["firstname"] . " " . $found_patient["lastname"];
			redirect_to("patient_content.php");
		} elseif($found_doctor) {
			$_SESSION["doctor_id"] = $found_doctor["id"];
			$_SESSION["full_name"] = "Dr. " . $found_doctor["firstname"] . " " . $found_doctor["lastname"];
			redirect_to("doctor_content.php");
		} else {
			$_SESSION["message"] = "Username or password not found!";
		}
	}
} elseif(isset($_POST['forgot'])) {
	$username = $_POST['field'];
	$user = find_user_by_username($username);
	if($user) {
		create_reset_token($username);
		$email = email_reset_token($username);
		if($email) {
			$_SESSION["message"] = "Reset Password link has been sent to your email address.";
			redirect_to("forgot_password.php");
		} else {
			$_SESSION["message"] = "Error! Couldn't sent email";
			redirect_to("forgot_password.php");
		}
	} else {
		// Username was not found; don't do anything for security reasons
	}
	// Message returned is the same whether the user
	// was found or not, so that we don't reveal which
	// usernames exist and which do not.
	$_SESSION["message"] = "Password has been sent to your email address.";
	redirect_to("forgot_password.php");
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
						<input type="text" placeholder="Username" class="form-control" name="username" value="<?php echo htmlentities($username); ?>" required>
					</div>
					<div class="form-group">
						<input type="password" placeholder="Password" class="form-control" name="password" value="" required>
					</div>
					<button type="submit" name="submit" class="btn btn-success">Sign in</button>
					<br>
					<div class="form-group">
						<a href="forgot_password.php">Forgot Password?</a>
					</div>
				</form>
			</div>
		</div>
	</nav>
	<section class="container">
		<?php echo message(); ?> <?php echo form_errors($errors); ?>
		<div class="row">
			<section class="col-lg-12">
				<div class="alert alert-danger">
					<h2>Forgot Password</h2>
					<br/>
					<p>If you have forgotten your password, please type your username one the text field below.
					   An email will be sent to your email address, which you have in your registration details.</p>

					<form class="form-inline" method="POST" action="forgot_password.php">
						<div class="form-group">
							<label for="username">Username:</label>
							<input type="text" name="field" class="form-control" id="username" size="50" maxlength="50" placeholder="Enter username" required>
						</div>
						<button type="submit" name="forgot" class="btn btn-danger">Submit</button>
					</form>
				</div>
			</section>
		</div>
	</section>
	<br/><br/><br/><br/><br/><br/>
<?php include("../includes/footer.php"); ?>