<?php
	
	require_once("parts/init.php");

	//Champion
	//http://ddragon.leagueoflegends.com/cdn/8.19.1/data/en_US/champion.json
	$idchampignon = $_GET['c'];
	$result = file_get_contents('./ddragon/'.$version.'/data/'.$lang.'/champion/'.$_GET['c'].'.json');
	$champion = json_decode($result);

?>
<html>
	<head>
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	    <!--<link href="V/css/style.css" rel="stylesheet">-->
	    <script src="bootstrap/js/jquery-3.2.1.min.js"></script>
		<script src="bootstrap/js/bootstrap.js"></script>
	    <script>
			$(function () {
				$('[data-toggle="tooltip"]').tooltip()
			})
		</script>
		<title>VCT Stats - <?php echo $champion->data->$idchampignon->name ?></title>
		<meta name="theme-color" content="#912A2A">
		<meta name="author" content="Traumination">
		<meta name="description" content="LoL Champions list">
		<meta name="copyright" content="© Traumination All right reserved" />
		<style>
			body.dark{
				background:#333;
				color:#ccc;
			}
		</style>
	</head>
	<body style="margin:0;padding:0;">
		<?php require_once("parts/$lang/header.php"); ?>
		<?php require_once("parts/$lang/footer.php"); ?>
		<div class="container" style="width:100%;margin-top:15px;">
			<?php require_once("parts/$lang/champs_detail.php"); ?>
		</div>
		<div id="miniature" onclick="close_display()" style="width:100%;height:100vh;background:rgba(0,0,0,0.5);position:fixed;top:0;left:0;display:none;">
			<div style="width:70%;background:#dfdfdf;margin:auto;margin-top:75px;display:block;text-align:right;padding-right:10px;border-top-left-radius:5px;border-top-right-radius:5px;">
				<a style="text-decoration:none;font-size:25px;color:black;cursor:pointer;" >&times;</a>
			</div>
			<img onclick="cancel_close = true" id="miniature-image" style="width:70%;background:white;margin:auto;display:block;border-bottom-left-radius:5px;border-bottom-right-radius:5px;"/>
		</div>
		<script>
			var cancel_close = false;
			function display(url){
				document.getElementById("miniature").style.display = "block";
				document.getElementById("miniature-image").src = url;
			}

			function close_display(){
				if(cancel_close == true){
					cancel_close = false;
					return;
				}
				document.getElementById("miniature").style.display = "none";
				document.getElementById("miniature-image").src = "";

			}
		</script>
		
		<?php require_once("./parts/bas.html"); ?>
	</body>
</html>
