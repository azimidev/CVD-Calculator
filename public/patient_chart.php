<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_patient_signned_in(); ?>
<?php $health = find_health_by_id($_GET["id"]); ?>
<?php $user = find_patient_by_id($_SESSION["patient_id"]); ?>
<?php $age = date("Y") - $user["dob"]; ?>

<?php include("../includes/header.php"); ?>
<script type="text/javascript">
	window.onload = function () {
		var chart = new CanvasJS.Chart("chartContainer",
		{
			title:{
				text: "CVD Risk Chart"
			},
			animationEnabled: true,
			axisY :{
				title: "Percentage",
				includeZero: false,
				maximum: 60,
				// valueFormatString: "#0,.",
				suffix: " %"
			},
			axisX: {
				title: "Years After"
			},
			toolTip: {
				shared: true,
				content: "<span style='\"'color: {color};'\"'><strong>{name}</strong></span> {y}%"
			},

			data: [
			{
				type: "splineArea",
				color: "red",
				showInLegend: true,
				name: "Risk",
				dataPoints: [
					<?php if($user["gender"] == "Male") { ?>
							{x: 0, y: <?php echo result($health["total_point"]); ?>},
							{x: 1, y: <?php echo result($health["total_point"]+1); ?>},
							{x: 2, y: <?php echo result($health["total_point"]+2); ?>},
							{x: 3, y: <?php echo result($health["total_point"]+3); ?>},
							{x: 4, y: <?php echo result($health["total_point"]+4); ?>},
							{x: 5, y: <?php echo result($health["total_point"]+5); ?>},
							{x: 6, y: <?php echo result($health["total_point"]+6); ?>},
							{x: 7, y: <?php echo result($health["total_point"]+7); ?>},
							{x: 8, y: <?php echo result($health["total_point"]+8); ?>},
							{x: 9, y: <?php echo result($health["total_point"]+9); ?>},
							{x: 10, y: <?php echo result($health["total_point"]+10); ?>}
					<?php } elseif($user["gender"] == "Female") { ?>
						<?php if($age < 34) { ?>
							{x: 0, y: <?php echo female_result($health["total_point"]); ?>},
							{x: 1, y: <?php echo female_result($health["total_point"]+5); ?>},
							{x: 2, y: <?php echo female_result($health["total_point"]+10); ?>},
							{x: 3, y: <?php echo female_result($health["total_point"]+15); ?>},
							{x: 4, y: <?php echo female_result($health["total_point"]+20); ?>},
							{x: 5, y: <?php echo female_result($health["total_point"]+25); ?>},
							{x: 6, y: <?php echo female_result($health["total_point"]+30); ?>},
							{x: 7, y: <?php echo female_result($health["total_point"]+35); ?>},
							{x: 8, y: <?php echo female_result($health["total_point"]+40); ?>},
							{x: 9, y: <?php echo female_result($health["total_point"]+45); ?>},
							{x: 10, y: <?php echo female_result($health["total_point"]+50); ?>}
					<?php } elseif($age < 39) { ?>
							{x: 0, y: <?php echo female_result($health["total_point"]); ?>},
							{x: 1, y: <?php echo female_result($health["total_point"]+4); ?>},
							{x: 2, y: <?php echo female_result($health["total_point"]+8); ?>},
							{x: 3, y: <?php echo female_result($health["total_point"]+12); ?>},
							{x: 4, y: <?php echo female_result($health["total_point"]+16); ?>},
							{x: 5, y: <?php echo female_result($health["total_point"]+20); ?>},
							{x: 6, y: <?php echo female_result($health["total_point"]+24); ?>},
							{x: 7, y: <?php echo female_result($health["total_point"]+28); ?>},
							{x: 8, y: <?php echo female_result($health["total_point"]+32); ?>},
							{x: 9, y: <?php echo female_result($health["total_point"]+36); ?>},
							{x: 10, y: <?php echo female_result($health["total_point"]+40); ?>}
					<?php } elseif($age < 49) { ?>
							{x: 0, y: <?php echo female_result($health["total_point"]); ?>},
							{x: 1, y: <?php echo female_result($health["total_point"]+3); ?>},
							{x: 2, y: <?php echo female_result($health["total_point"]+6); ?>},
							{x: 3, y: <?php echo female_result($health["total_point"]+9); ?>},
							{x: 4, y: <?php echo female_result($health["total_point"]+12); ?>},
							{x: 5, y: <?php echo female_result($health["total_point"]+15); ?>},
							{x: 6, y: <?php echo female_result($health["total_point"]+18); ?>},
							{x: 7, y: <?php echo female_result($health["total_point"]+21); ?>},
							{x: 8, y: <?php echo female_result($health["total_point"]+24); ?>},
							{x: 9, y: <?php echo female_result($health["total_point"]+27); ?>},
							{x: 10, y: <?php echo female_result($health["total_point"]+30); ?>}
					<?php } elseif($age < 54) { ?>
							{x: 0, y: <?php echo female_result($health["total_point"]); ?>},
							{x: 1, y: <?php echo female_result($health["total_point"]+1); ?>},
							{x: 2, y: <?php echo female_result($health["total_point"]+2); ?>},
							{x: 3, y: <?php echo female_result($health["total_point"]+3); ?>},
							{x: 4, y: <?php echo female_result($health["total_point"]+4); ?>},
							{x: 5, y: <?php echo female_result($health["total_point"]+5); ?>},
							{x: 6, y: <?php echo female_result($health["total_point"]+6); ?>},
							{x: 7, y: <?php echo female_result($health["total_point"]+7); ?>},
							{x: 8, y: <?php echo female_result($health["total_point"]+8); ?>},
							{x: 9, y: <?php echo female_result($health["total_point"]+9); ?>},
							{x: 10, y: <?php echo female_result($health["total_point"]+10); ?>}
						<?php } else { ?>
							{x: 0, y: <?php echo female_result($health["total_point"]); ?>},
							{x: 1, y: <?php echo female_result($health["total_point"]); ?>},
							{x: 2, y: <?php echo female_result($health["total_point"]); ?>},
							{x: 3, y: <?php echo female_result($health["total_point"]); ?>},
							{x: 4, y: <?php echo female_result($health["total_point"]); ?>},
							{x: 5, y: <?php echo female_result($health["total_point"]); ?>},
							{x: 6, y: <?php echo female_result($health["total_point"]); ?>},
							{x: 7, y: <?php echo female_result($health["total_point"]); ?>},
							{x: 8, y: <?php echo female_result($health["total_point"]); ?>},
							{x: 9, y: <?php echo female_result($health["total_point"]); ?>},
							{x: 10, y: <?php echo female_result($health["total_point"]); ?>}
						<?php } ?>
					<?php } ?>
				]
			},
			]
		});
chart.render();
}
</script>
<section class="col-lg-5">
	<a href="patient_content.php" class="btn btn-warning">Back</a>
	<h3>Patient: <?php echo htmlentities($user["firstname"]) ." ". htmlentities($user["lastname"]) ?></h3>
	<dl class="dl-horizontal">
		<dt>Age :</dt>
		<dd><?php echo $health["age"]; ?></dd>

		<dt>LDL-C :</dt>
		<dd><?php echo $health["ldl_c"]; ?>
			<small>mg/dl</small> <span class="badge">Recommended less than 100</span>
		</dd>

		<dt>HDL-C :</dt>
		<dd><?php echo $health["hdl_c"]; ?>
			<small>mg/dl</small> <span class="badge">Recommended 60 or more</span>
		</dd>

		<dt>Blood Pressure :</dt>
		<dd><?php echo $health["bp"]; ?>
			<span class="badge">Recommended 120/80</span>
		</dd>

		<dt>Diabetes :</dt>
		<dd><?php echo $health["diabetes"] ? "Yes": "No"; ?></dd>

		<dt>Smoker :</dt>
		<dd><?php echo $health["smoker"] ? "Yes": "No"; ?></dd>

		<dt>Total Points :</dt>
		<dd><?php echo $health["total_point"]; ?>
			<?php if($user["gender"] == "Male"): ?>
				<span class="badge">Lowest point for male is -8</span>
			<?php else: ?>
				<span class="badge">Lowest point for female is -10</span>
			<?php endif; ?>
		</dd>

		<dt>Date :</dt>
		<dd><?php echo datetime_to_text($health["date"]); ?></dd>

		<dt><label for="comment">Recommendation :</label></dt>
		<dd>
			<?php if(!empty($health["rec"])) { ?>
			<p class="text-primary"><?php echo htmlentities($health["rec"]); ?></p>
			<?php } else { ?>
			<p class="text-danger">No recommendation!</p>
			<?php } ?>
		</dd>
	</dl>
</section>
<section class="col-lg-7">
	<div id="chartContainer" style="height: 500px; width: 100%;">
</section>
<br />
	<?php include("../includes/footer.php"); ?>