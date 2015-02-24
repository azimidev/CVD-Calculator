<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php
$token = $_GET['token'];
// Confirm that the token sent is valid
$user = find_by_token($token);
if(!$user || !$token) {
	// Token wasn't sent or didn't match a user.
	redirect_to('forgot_password.php');
}
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
} elseif(isset($_POST['reset'])) {
	$password         = $_POST['pass'];
	$password_confirm = $_POST['password_confirm'];
	if($password !== $password_confirm) {
		$message = "Password confirmation does not match password.";
	} else {
		$new_pass = password_encrypt($_POST["pass"]);
		// update password
		$id     = $user["id"];
		$query  = "UPDATE Patients SET password = '{$new_pass}' WHERE id = {$id} LIMIT 1";
		$result = mysqli_query($connection, $query);
		if($result && mysqli_affected_rows($connection) == 1) {
			delete_reset_token($user["username"]);
			$_SESSION["message"] = "Thank You! You reset your password successfully.";
			redirect_to('index.php');
		} else {
			$message = "Could not perform the update";
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
				<form class="navbar-form navbar-right" role="form" action="reset_password.php?token=<?php echo $user["token"]; ?>" method="POST">
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
			<!--/.navbar-collapse -->
		</div>
	</nav>
	<section class="container">
		<?php echo message(); ?> <?php echo form_errors($errors); ?>
		<div class="row">
			<section class="col-lg-12">
				<div class="alert alert-seccess">
					<h2>Reset Password</h2>
					<br/>

					<form class="form-horizontal" action="reset_password.php?token=<?php echo urldecode($token); ?>" method="POST" accept-charset="utf-8">
						<fieldset>
							<legend>Set your new password</legend>
							<section class="row">
								<label class="col col-lg-4 control-label" for="pass">New Password:</label>
								<div class="controls">
									<div class="input-group">
										<span style="font-size: 10px;" class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
										<input class="col col-lg-8" type="password" name="pass" id="pass" autofocus placeholder="New Password" required/>
									</div>
								</div>
							</section>
							<section class="row">
								<label class="col col-lg-4 control-label" for="password_confirm">New Password
								                                                                 Confirm:</label>
								<div class="controls">
									<div class="input-group">
										<span style="font-size: 10px;" class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
										<input onkeyup="checkResetPass(); return false;" class="col col-lg-8" type="password" name="password_confirm" id="password_confirm" placeholder="Confirm New Password" required/>
										&nbsp;&nbsp;<span id="confirmMessage"></span>
									</div>
								</div>
							</section>
							<section class="row">
								<label class="col col-lg-4 control-label" for="submit"></label>
								<div class="controls">
									<a href="index.php" class="btn btn-danger">Cancel</a>
									<button class="btn btn-primary" name="reset" id="submit" type="submit">Set
									                                                                       Password
									</button>
								</div>
							</section>
						</fieldset>
					</form>
				</div>
			</section>
		</div>
	</section>
	<br/><br/><br/><br/><br/><br/>
<?php include("../includes/footer.php"); ?>