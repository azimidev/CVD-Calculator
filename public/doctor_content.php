<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_doctor_signned_in(); ?>
<?php $doctor_id = $_SESSION["doctor_id"]; ?>
<?php $user_set = find_patients_for_doctor($doctor_id); ?>

<?php include("../includes/header.php"); ?>
<section class="container">
	<div class="jumbotron">
		<div class="container">
			<h2>Welcome <?php echo $_SESSION["full_name"]; ?></h2>
			<a class="btn btn-danger pull-right" href="logout.php">Logout</a>
		</div>
	</div>
</section>
<?php echo message(); ?>
<section class="container">
	<section class="col col-lg-12">
		<h3>Your Patients</h3>
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Username</th>
							<th>First Name</th>
							<th>Last Name</th>
							<th>Gender</th>
							<th>DOB</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php while ($user = mysqli_fetch_assoc($user_set)) { ?>
						<tr>
							<td><?php echo htmlentities($user["username"]); ?></td>
							<td><?php echo htmlentities($user["firstname"]); ?></td>
							<td><?php echo htmlentities($user["lastname"]); ?></td>
							<td><?php echo htmlentities($user["gender"]); ?></td>
							<td><?php echo htmlentities($user["dob"]); ?></td>
							<td><a class="btn btn-primary" href="calculate.php?id=<?php echo urldecode($user["id"]); ?>">Calculate Risk</a></td>
						</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
	</section>
</section>
<?php include("../includes/footer.php"); ?>