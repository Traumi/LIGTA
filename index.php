<?php
	require_once("parts/init.php");
?>
<html>
	<style>
		body.dark{
			background: #333;
			color:#ccc;
		}
		#logo{
			transition: 8s all;
		}
	</style>
	<head>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<link rel="icon" type="image/png" href="images/favicon.png" />
	    <script src="bootstrap/js/jquery-3.2.1.min.js"></script>
		<script src="bootstrap/js/bootstrap.js"></script>
	    <script>
			$(function () {
				$('[data-toggle="tooltip"]').tooltip()
			})
		</script>
		<title>LIGTA</title>
		<meta name="theme-color" content="#912A2A">
		<meta name="author" content="Traumination">
		<meta name="copyright" content="© Traumination All right reserved" />
		<meta name="og:image" content="http://89.156.31.147/ligta/images/favicon.png" />
		<meta property="og:title" content="LIGTA" />
		<meta property="og:description" content="Home Page" />
	</head>
	<body style="margin:0;padding:0;">
		<?php require_once("parts/header.php"); ?>
		<?php require_once("parts/footer.php"); ?>
		<div class="container" style="width:100%;">
			<div class="col-md-12 col-xs-12 text-center">
				<img id="logo" style="filter: drop-shadow(0 0 15px #A20C0C);margin-top:50px;" width="20%" src="./images/favicon.png"/>
				<h1>LIGTA</h1>
				<div class="col-md-6 col-md-offset-3 col-xs-12">
					<form action="profil.php" method="get">
						<div class="input-group">
							<input placeholder="<?php echo $translations['SEARCH_PLAYER'] ?>" name="pseudo" class="form-control" type="text">
							<div class="input-group-btn">
							<button class="btn btn-default" type="submit" style="">
								&nbsp;<i class="glyphicon glyphicon-search"></i>&nbsp;
							</button>
							</div>

						</div>
					</form>
				</div>
			</div>
		</div>
		<?php require_once("./parts/bas.html"); ?>
		<script>
			var logo = document.getElementById("logo");
			var bright = false;
			shine = function(){
				let color = getRandomColor();
				logo.style.filter = "drop-shadow(0 0 15px "+color+")";
			}
			function getRandomColor() {
				var letters = '0123456789ABCDEF';
				var color = '#';
				for (var i = 0; i < 6; i++) {
					color += letters[Math.floor(Math.random() * 16)];
				}
				return color;
			}
			setTimeout(shine, 1);
			var timer = setInterval(shine, 4000);
		</script>
	</body>
</html>
