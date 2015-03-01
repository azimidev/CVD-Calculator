<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_doctor_signned_in(); ?>
<?php
$user = find_patient_by_id($_GET["id"]);
if (!$user) {
	redirect_to("doctor_content.php");
}
$health_set = find_health_by_user_id($_GET["id"]);
$age = (int)(date("Y") - $user["dob"]);
if (isset($_POST['submit'])) {
	if (empty($errors)) {
		$user_id 	 	= $user["id"];
		$gender 	 	= $user["gender"];
		$ldl_c 		 	= (double)$_POST["ldl_c"];
		$cholesterol 	= (double)$_POST["cholesterol"];
		$hdl_c 		 	= (double)$_POST["hdl_c"];
		$systolic 		= (double)$_POST["systolic"];
		$diastolic 		= (double)$_POST["diastolic"];
		$bp 		 	= $_POST["systolic"] . "/" . $_POST["diastolic"];
		$db 		 	= (int)$_POST["db"];
		$smoker 	 	= (int)$_POST["smoker"];
		
		if ($user["gender"] == "Male"){
			$total_points = calculate_men($age, $ldl_c, $cholesterol, $hdl_c, $systolic, $diastolic, $db, $smoker);
		} elseif ($user["gender"] == "Female") {
			$total_points = calculate_women($age, $ldl_c, $cholesterol, $hdl_c, $systolic, $diastolic, $db, $smoker);
		} else {
			$total_points = NULL;
		}

		$query = "INSERT INTO Health (";
        $query .= "  patient_id, gender, age, ldl_c, cholesterol, hdl_c, bp, diabetes, smoker, total_point";
        $query .= ") VALUES (";
        $query .= "  {$user_id}, '{$gender}', {$age}, {$ldl_c}, {$cholesterol}, {$hdl_c}, '{$bp}', {$db}, {$smoker}, {$total_points}";
        $query .= ")";
		$result = mysqli_query($connection, $query);

		if ($result) {
			$_SESSION["message"] = "Health Profile added.";
			redirect_to("calculate.php?id=". $user["id"]);
		} else {
			$_SESSION["message"] = "Health Profile creation failed! Please fill out all the fields correctly!";
		}
	}
} else {
} // end: if (isset($_POST['submit']))
?>

<?php include("../includes/header.php"); ?>
<?php echo message(); ?>
<section class="container">
	<div class="row">
		<section class="col col-lg-12">
			<h2>Add Risk of CVD for <?php echo $user["firstname"] . " " . $user["lastname"]; ?></h2>
		</section>
	</div>
	<section class="main col col-lg-9">
		<form action="calculate.php?id=<?php echo urlencode($user["id"]); ?>" method="POST" class="form-horizontal" role="form">
			<div class="form-group">
				<a class="btn btn-warning" href="doctor_content.php">&laquo; Back</a>
				<h4>Calculate Risk of CVD:</h4>
			</div>
			<!-- Age -->
			<div class="form-group">
				<label class="col col-sm-2 control-label" for="ldl_c">Age:</label>
				<div class="col-sm-2 col-sm-offset-1">
					<input type="number" name="age" id="age" class="form-control" title="Age" disabled value="<?php echo $age; ?>">
				</div>
				<small class="text-info col-sm-7"> (Age has been calculated from your registration details)</small>
			</div>
			<!-- LDL_C -->
			<div class="form-group">
				<label class="col col-sm-2 control-label" for="ldl_c">LDL-C:</label>
				<div class="col-sm-7 col-sm-offset-1">
					<input onkeyup="checkldlc(); return false;" type="number" name="ldl_c" id="ldl_c" class="form-control" value="" required="required" pattern="" title="LDL-C" placeholder="Between 80 to 200" min="80" max="200" size="3" maxlength="3">
				</div>
				<span class="col-sm-1">mg/dl</span>
				<span class="col-sm-1" id="ldlcMessage"></span>
			</div>
			<!-- Cholesterol -->
			<div class="form-group">
				<label class="col col-sm-2 control-label" for="cholesterol">Cholesterol:</label>
				<div class="col-sm-7 col-sm-offset-1">
					<input onkeyup="checkcholesterol(); return false;" type="number" name="cholesterol" id="cholesterol" class="form-control" value="" required="required" pattern="" title="Cholesterol" placeholder="Between 150 to 300" min="150" max="300" size="3" maxlength="3">
				</div>
				<span class="col-sm-1">mg/dl</span>
				<span class="col-sm-1" id="cholMessage"></span>
			</div>
			<!-- HDL-C -->
			<div class="form-group">
				<label class="col col-sm-2 control-label" for="hdl_c">HDL-C:</label>
				<div class="col-sm-7 col-sm-offset-1">
					<input onkeyup="checkhdlc(); return false;" type="number" name="hdl_c" id="hdl_c" class="form-control" value="" required="required" pattern="" title="HDL-C" placeholder="Between 30 to 65" min="30" max="65" size="2" maxlength="2">
				</div>
				<span class="col-sm-1">mg/dl</span>
				<span class="col-sm-1" id="hdlcMessage"></span>
			</div>
			<!-- Blood Pressure -->
			<div class="form-group">
				<label class="col col-sm-2 control-label">Blood Pressure:</label>
				<div class="col-sm-3 col-sm-offset-1">
					<input onkeyup="checksystolic(); return false;" type="number" name="systolic" id="systolic" class="form-control" value="" required="required" pattern="" title="Systolic" placeholder="Systolic 100 to 180" min="100" max="180" size="1" maxlength="3">
				</div>
				<span class="col-sm-1" id="systolicMessage"></span>
				<div class="col-sm-3">
					<input onkeyup="checkdiastolic(); return false;" type="number" name="diastolic" id="diastolic" class="form-control" value="" required="required" pattern="" title="Diastolic" placeholder="Diastolic 70 to 110" min="70" max="110" size="3" maxlength="3">
				</div>
				<span class="col-sm-1">mm/Hg</span>
				<span class="col-sm-1" id="diastolicMessage"></span>
			</div>
			<!-- Diabetes -->
			<div class="form-group">
				<label class="col col-sm-2 control-label" for="db">Diabetes:</label>
				<div class="col-sm-9 col-sm-offset-1">
					<div class="controls radio-disabled">
						<label class="radio-inline">
							<input type="radio" name="db" id="db" value="1"> Yes
						</label>
						<label class="radio-inline">
							<input type="radio" name="db" id="db" value="0"> No
						</label>
					</div>
				</div>
			</div>
			<!-- smoker -->
			<div class="form-group">
				<label class="col col-sm-2 control-label" for="smoker">Smoker:</label>
				<div class="col-sm-9 col-sm-offset-1">
					<div class="controls radio-disabled">
						<label class="radio-inline">
							<input type="radio" name="smoker" id="smoker" value="1"> Yes
						</label>
						<label class="radio-inline">
							<input type="radio" name="smoker" id="smoker" value="0"> No
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col col-sm-2 control-label" for="submit"></label>
				<div class="col-sm-9 col-sm-offset-1">
					<input type="submit" value="Submit" name="submit" class="btn btn-success" id="submit">
				</div>
			</div>
		</form>
	</section>
	<section class="sidebar col col-lg-3">
		<!--  -->
	</section>
</section>
<section class="container">
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
						<th>Date & Time</th>
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
						<td><a class="btn btn-sm btn-danger" href="chart.php?id=<?php echo urldecode($health["id"]); ?>&user_id=<?php echo urldecode($user["id"]); ?>"><span class="glyphicon glyphicon-picture"></span></a></td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
</section>
<br>
<?php include("../includes/footer.php"); ?>