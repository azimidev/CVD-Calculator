<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php confirm_patient_signned_in(); ?>
<?php $health = find_health_by_id($_GET["id"]); ?>
<?php $user = find_patient_by_id($_SESSION["patient_id"]); ?>

<?php include("../includes/header.php"); ?>
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
	<a href="patient_content.php" class="btn btn-warning">Back</a>
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
				<span class="badge">Recommended point for male is -8</span>
			<?php else: ?>
				<span class="badge">Recommended point for female is -10</span>
			<?php endif; ?>
		</dd>

		<dt>Date :</dt>
		<dd><?php echo datetime_to_text($health["date"]); ?></dd>

		<dt><label for="comment">Recommendation :</label></dt>
		<dd>
			<p class="text-primary"><?php echo htmlentities($health["rec"]); ?></p>
		</dd>
	</dl>
</section>
<section class="col-lg-7">
	<div id="chartContainer" style="height: 500px; width: 100%;">
	</section>
	<?php include("../includes/footer.php"); ?>