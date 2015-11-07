	
<div class="container">
	<div class="row">
		<footer>
			<nav class="col-lg-12">
				<ul class="breadcrumb">
					<li>Copyright &copy; <?php echo strftime("%Y", time()); ?> Group Delta</li>
				</ul><!-- breadcrumb -->
			</nav><!-- nav -->
		</footer><!-- footer -->
		</div>
	</div>
	<!-- </div> -->
	<!-- jQuery (necessary for Flat UI's JavaScript plugins) -->
	<script src="js/vendor/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	<script src="js/vendor/video.js"></script>
	<script src="js/flat-ui.min.js"></script>
	<script src="js/canvasjs.min.js"></script>
	<script src="js/custom.js"></script>

</body>
</html>
<?php
//Close database connection
if (isset($connection)) {
	mysqli_close($connection);
}
?>
