<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_patient_signned_in(); ?>
<?php 
$patient_id = $_SESSION["patient_id"];
$user = find_patient_by_id($patient_id);
$health_set = find_health_by_user_id($patient_id);
?>
<?php include("../includes/header.php"); ?>
<?php echo message(); ?>
<section class="container">
	<div class="jumbotron">
		<div class="container">
			<h2>Welcome <?php echo $_SESSION["full_name"]; ?></h2>
			<a class="btn btn-danger pull-right" href="logout.php">Logout</a>
		</div>
	</div>
	<section class="main col col-lg-12">
		<h3>Your CVD History</h3>
			<div class="table-responsive">
					<table class="table table-hover">
					<thead>
						<tr>
							<th>Age</th>
							<th>LDL-C</th>
							<th>Cholesterol</th>
							<th>HDL-C</th>
							<th>Blood Pressure</th>
							<th>Diabetes</th>
							<th>Smoker</th>
							<th>Total Point</th>
							<th>Date &amp; Time</th>
							<th>Chart</th>
						</tr>
					</thead>
					<tbody>
						<?php while ($health = mysqli_fetch_assoc($health_set)) { ?>
						<tr>
							<td><?php echo htmlentities($health["age"]); ?></td>
							<td><?php echo htmlentities($health["ldl_c"]); ?></td>
							<td><?php echo htmlentities($health["cholesterol"]); ?></td>
							<td><?php echo htmlentities($health["hdl_c"]); ?></td>
							<td><?php echo htmlentities($health["bp"]); ?></td>
							<td><?php echo ($health["diabetes"]) ? "Yes" : "No"; ?></td>
							<td><?php echo ($health["smoker"]) ? "Yes" : "No"; ?></td>
							<td><?php echo htmlentities($health["total_point"]); ?>
							<?php if($health["total_point"] == -8 && $user["gender"] == "Male") {
								echo "<span class='glyphicon glyphicon-heart small text-success'></span>";
							} elseif ($health["total_point"] == -10 && $user["gender"] == "Female") {
								echo "<span class='glyphicon glyphicon-heart small text-success'></span>";
							} ?>
							</td>
							<td><?php echo htmlentities(datetime_to_text($health["date"])); ?></td>
							<td><a class="btn btn-sm btn-success" href="patient_chart.php?id=<?php echo urldecode($health["id"]); ?>"><span class="glyphicon glyphicon-picture"></span></a></td>
						</tr>
						<?php } ?>
					</tbody>
							</table>
				</div>	</section>
</section>
<br>
<?php include("../includes/footer.php"); ?>