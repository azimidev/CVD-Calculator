<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_doctor_signned_in(); ?>
<?php $health = find_health_by_id($_GET["id"]); ?>
<?php $user = find_patient_by_id($_GET["user_id"]); ?>
<?php $age = date("Y") - $user["dob"]; ?>
<?php 
if (isset($_POST["submit"])) {
	$rec = mysql_prep($_POST["rec"]);
	$query = "UPDATE Health SET rec = '{$rec}' WHERE id=".$health['id']." LIMIT 1";
	$result = mysqli_query($connection, $query);

	if ($result && mysqli_affected_rows($connection) == 1) {
		$_SESSION["message"] = "Recommendation updated.";
		redirect_to("chart.php?id=". $health["id"]."&user_id=". $user["id"]);
	} else {
		$_SESSION["message"] = "Could not add recommendation.";
	}
} elseif(isset($_POST["email"])) {
$message = 'Hi '.$user["firstname"] . ',

Please find your recent CVD risk point below:

		Age: '.$health["age"].'
		LDL-C: '.$health["ldl_c"].' mg/dl
		HDL-C: '.$health["hdl_c"].' mg/dl
		Blood Pressure: '.$health["bp"].'
		Diabetes: '.$health["diabetes"].'
		Smoker: '.$health["smoker"].'
		Total Points: '.$health["total_point"].'
		Date: '.datetime_to_text($health["date"]).'
		
		Recommendation: '.$health["rec"];

      	$result = mail($user["email"], 'CVD Risk Details', $message);

      if ($result) {
          $_SESSION["message"] = "The email has been sent to the patient.";
          redirect_to("chart.php?id=". $health["id"]."&user_id=". $user["id"]);
      } else {
          $_SESSION["message"] = "Error! Could not send email to the patient.";
          redirect_to("chart.php?id=". $health["id"]."&user_id=". $user["id"]);
      }
}
?>

<?php include("../includes/header.php"); ?>
<div class="container">
	<?php echo message(); ?>
	<script type="text/javascript">
		window.onload = function () {
			var chart = new CanvasJS.Chart("chartContainer",
			{      
				title:{
					text: "Framingham Risk Chart"
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
								{x: 1, y: <?php echo female_result($health["total_point"]+2); ?>},
								{x: 2, y: <?php echo female_result($health["total_point"]+4); ?>},
								{x: 3, y: <?php echo female_result($health["total_point"]+6); ?>},
								{x: 4, y: <?php echo female_result($health["total_point"]+8); ?>},
								{x: 5, y: <?php echo female_result($health["total_point"]+10); ?>},
								{x: 6, y: <?php echo female_result($health["total_point"]+12); ?>},
								{x: 7, y: <?php echo female_result($health["total_point"]+14); ?>},
								{x: 8, y: <?php echo female_result($health["total_point"]+16); ?>},
								{x: 9, y: <?php echo female_result($health["total_point"]+18); ?>},
								{x: 10, y: <?php echo female_result($health["total_point"]+20); ?>}
					        <?php } elseif($age < 39) { ?>
								{x: 0, y: <?php echo female_result($health["total_point"]); ?>},
								{x: 1, y: <?php echo female_result($health["total_point"]+2.5); ?>},
								{x: 2, y: <?php echo female_result($health["total_point"]+5); ?>},
								{x: 3, y: <?php echo female_result($health["total_point"]+7.5); ?>},
								{x: 4, y: <?php echo female_result($health["total_point"]+10); ?>},
								{x: 5, y: <?php echo female_result($health["total_point"]+12.5); ?>},
								{x: 6, y: <?php echo female_result($health["total_point"]+15); ?>},
								{x: 7, y: <?php echo female_result($health["total_point"]+17.5); ?>},
								{x: 8, y: <?php echo female_result($health["total_point"]+20); ?>},
								{x: 9, y: <?php echo female_result($health["total_point"]+22.5); ?>},
								{x: 10, y: <?php echo female_result($health["total_point"]+25); ?>}
					        <?php } elseif($age < 49) { ?>
								{x: 0, y: <?php echo female_result($health["total_point"]); ?>},
								{x: 1, y: <?php echo female_result($health["total_point"]+3.33); ?>},
								{x: 2, y: <?php echo female_result($health["total_point"]+6.66); ?>},
								{x: 3, y: <?php echo female_result($health["total_point"]+9.99); ?>},
								{x: 4, y: <?php echo female_result($health["total_point"]+13.33); ?>},
								{x: 5, y: <?php echo female_result($health["total_point"]+16.66); ?>},
								{x: 6, y: <?php echo female_result($health["total_point"]+19.99); ?>},
								{x: 7, y: <?php echo female_result($health["total_point"]+23.33); ?>},
								{x: 8, y: <?php echo female_result($health["total_point"]+26.66); ?>},
								{x: 9, y: <?php echo female_result($health["total_point"]+29.99); ?>},
								{x: 10, y: <?php echo female_result($health["total_point"]+33.33); ?>}
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
				// {        
				// 	type: "splineArea",  
				// 	name: "Recommended",
				// 	color: "green",
				// 	showInLegend: true,
				// 	dataPoints: [
				// 	<?php if($user["gender"] == "Male") { ?>
				// 		{x: 0, y: <?php echo result(-8); ?>},
				// 		{x: 1, y: <?php echo result(-8+1); ?>},
				// 		{x: 2, y: <?php echo result(-8+2); ?>},
				// 		{x: 3, y: <?php echo result(-8+3); ?>},
				// 		{x: 4, y: <?php echo result(-8+4); ?>},
				// 		{x: 5, y: <?php echo result(-8+5); ?>},
				// 		{x: 6, y: <?php echo result(-8+6); ?>},
				// 		{x: 7, y: <?php echo result(-8+7); ?>},
				// 		{x: 8, y: <?php echo result(-8+8); ?>},
				// 		{x: 9, y: <?php echo result(-8+9); ?>},
				// 		{x: 10, y: <?php echo result(-8+10); ?>}
				// 	<?php } ?>
				// 	<?php if($user["gender"] == "Female") { ?>
				// 		{x: 0, y: <?php echo result(-10); ?>},
				// 		{x: 1, y: <?php echo result(-10+1); ?>},
				// 		{x: 2, y: <?php echo result(-10+2); ?>},
				// 		{x: 3, y: <?php echo result(-10+3); ?>},
				// 		{x: 4, y: <?php echo result(-10+4); ?>},
				// 		{x: 5, y: <?php echo result(-10+5); ?>},
				// 		{x: 6, y: <?php echo result(-10+6); ?>},
				// 		{x: 7, y: <?php echo result(-10+7); ?>},
				// 		{x: 8, y: <?php echo result(-10+8); ?>},
				// 		{x: 9, y: <?php echo result(-10+9); ?>},
				// 		{x: 10, y: <?php echo result(-10+10); ?>}
				// 	<?php } ?>
				// 	]
				// }
			]
		});
		chart.render();
		}
	</script>
	<section class="col-lg-5">
	<h3>Patient: <?php echo htmlentities($user["firstname"]) ." ". htmlentities($user["lastname"]) ?></h3>
		<a href="calculate.php?id=<?php echo $user["id"]; ?>" class="btn btn-warning">Back</a>
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
			
			<form action="chart.php?id=<?php echo urldecode($health["id"]); ?>&user_id=<?php echo urldecode($user["id"]); ?>" method="POST" role="form">
				<div class="form-group">
					<dt><label for="comment">Recommendation :</label></dt>
					<dd>
						<textarea class="form-control" rows="5" id="comment" name="rec"><?php echo htmlentities($health["rec"]); ?></textarea>
						<button type="submit" class="btn btn-success" name="submit">Submit</button>
						<button type="button" class="btn btn-danger" onclick="printPage()" id="print"><span class="glyphicon glyphicon-print"></span> Print</button>
						<button type="submit" class="btn btn-warning" name="email"><span class="glyphicon glyphicon-envelope"></span> Email</button>
					</dd>
				</div>
			</form>

		</dl>
	</section>
	<section class="col-lg-7">
		<div id="chartContainer" style="height: 500px; width: 100%;">
	</section>
</div>
<br>
	<script>
		function printPage() { window.print(); }
	</script>
	<?php include("../includes/footer.php"); ?>