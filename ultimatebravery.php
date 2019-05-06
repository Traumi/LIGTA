<?php
	
	require_once("parts/init.php");

	$result = file_get_contents('./ddragon/'.$version.'/data/'.$lang.'/item.json');
	$items = json_decode($result, true);

	$result = file_get_contents('./ddragon/'.$version.'/data/'.$lang.'/summoner.json');
	$spells = json_decode($result);
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
		<title>Ultimate Bravery</title>
		<style>
			body.dark{
				background:#333;
				color:#ccc;
			}

			.game-profil a{
				color:#222;
				font-size:18px;
			}

			.game-profil a:hover{
				color:#222;
			}

			body.dark .game-profil a{
				color:#ccc;
			}

			body.dark .game-profil a:hover{
				color:#ccc;
			}
		</style>
	</head>
	<body style="margin:0;padding:0;">
		<?php require_once("parts/$lang/header.php"); ?>
		<?php require_once("parts/$lang/footer.php"); ?>
		<div class="container" style="width:100%;margin-bottom:25px;">
			<?php
				//var_dump($items["data"][1413]);
				$availableItems = [];
				foreach($items["data"] as $key => $item){
					if(!isset($item["into"]) && isset($item["from"]) && !isset($item["requiredAlly"]) && $item["maps"][11]){
						$availableItems[] = $key;
					}
				}

				//Pas bon :
				//3384 : Ornn Upgraded
				//3029 : HA/TT/SR (Game typed) ["maps"]
				//HA TT SR
				//12 10 11
				//3671,3675 : WHUUUT?
				//3181,4402 : Deleted items ?
				//1400 : Item jungler : nope ["hideFromAll"]
				//1413 : No image
				//3198 : Viktor

				for($i = 0 ; $i < 6 ; ++$i){
					$index = rand(0, sizeof($availableItems)-1);
					echo $availableItems[$index]." - ";
					echo '<img src="./ddragon/9.9.1/img/item/'.$availableItems[$index].'.png"/>';
					array_splice($availableItems, $index, 1);
				}
			?>
		</div>
		<?php require_once("./parts/bas.html"); ?>
	</body>
</html>