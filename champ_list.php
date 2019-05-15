<?php
	
	require_once("parts/init.php");

	$result = file_get_contents('./ddragon/'.$version.'/data/'.$lang.'/champion.json');
	$champions = json_decode($result);
?>
<html>
	<style>
		body.dark{
			background: #333;
			color:#ccc;
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
		<title>LIGTA - Champions</title>
		<meta name="theme-color" content="#912A2A">
		<meta name="author" content="Traumination">
		<meta name="description" content="LoL Champions list">
		<meta name="copyright" content="© Traumination All right reserved" />
		<!--<meta name="og:site_name" content="VCT Stats">
		<meta name="og:type" content="object">
		<meta name="og:image" content="http://89.156.31.147/vct/ddragon/img/champion/splash/Aatrox_1.jpg">
		<meta name="og:title" content="Champs">
		<meta name="og:url" content="https://89.156.31.147/vct/">
		<meta name="og:description" content="Champions list">-->
	</head>
	<body style="margin:0;padding:0;">
		<?php require_once("parts/header.php"); ?>
		<?php require_once("parts/footer.php"); ?>
		<div class="container" style="width:100%;">
			<?php require_once("parts/champs.php") ?>
		</div>
		<?php require_once("./parts/bas.html"); ?>
		
	</body>
</html>
