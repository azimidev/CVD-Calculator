<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_doctor_signned_in(); ?>
<?php $doctor_id = $_SESSION["doctor_id"]; ?>
<?php $message = "";
if(isset($_GET["q"]) && !empty($_GET["q"]) && $_GET["q"] != " ") {
	$user_set = search_patient($_GET["q"]);
} else {
	$user_set = find_patients_for_doctor($doctor_id);
}
?>
<?php include("../includes/header.php"); ?>
	<section class="container">
		<div class="jumbotron">
			<div class="container">
				<h2>Welcome <?php echo $_SESSION["full_name"]; ?></h2>
				<a class="btn btn-danger pull-right" href="logout.php">Logout</a>
			</div>
			<form action="doctor_content.php" method="get" class="navbar-form navbar-right" role="search">
				<div class="form-group">
					<input type="text" class="form-control" size="50" placeholder="Search patient" name="q" maxlength="50" value="<?php echo !empty($_GET["q"]) ? $_GET["q"] : ""; ?>">
				</div>
				<a class="btn btn-default" href="doctor_content.php">Clear</a>
			</form>
		</div>
	</section>
<?php echo message();
?>
	<section class="container">
		<section class="col col-lg-12">
			<h3>Your Patients</h3>
			<?php if (mysqli_num_rows($user_set) != 0) { ?>
			<div class="table-responsive">
				<table class="table table-hover table-bordered">
					<thead>
					<tr>
						<th class="success">Username</th>
						<th class="info">First Name</th>
						<th class="info">Last Name</th>
						<th class="warning">Gender</th>
						<th class="warning">DOB</th>
						<th class="danger">Recent Point</th>
						<th class="active">Actions</th>
					</tr>
					</thead>
					<tbody>
					<?php while($user = mysqli_fetch_assoc($user_set)) { ?>
						<tr>
							<td class="success"><?php echo htmlentities($user["username"]); ?></td>
							<td class="info"><?php echo htmlentities($user["firstname"]); ?></td>
							<td class="info"><?php echo htmlentities($user["lastname"]); ?></td>
							<td class="warning"><?php echo htmlentities($user["gender"]); ?></td>
							<td class="warning"><?php echo htmlentities($user["dob"]); ?></td>
							<td class="danger"><?php
								$all_health = find_all_health_for_user($user["id"]);
								echo $all_health["total_point"];
								?></td>
							<td class="active">
								<a class="btn btn-info" href="calculate.php?id=<?php echo urldecode($user["id"]); ?>">Calculate
								                                                                                      Risk</a>
							</td>
						</tr>
					<?php } ?>
					</tbody>
				</table>
				<?php } else { ?>
					<div class="alert alert-danger">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
						<strong><span class="glyphicon glyphicon-exclamation-sign"></span></strong> No result found!
					</div>
				<?php } ?>
			</div>
		</section>
	</section>
	<br>
<?php include("../includes/footer.php"); ?>