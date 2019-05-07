<?php
	
	require_once("parts/init.php");

	$result = file_get_contents('./ddragon/'.$version.'/data/'.$lang.'/item.json');
	$items = json_decode($result, true);

	$result = file_get_contents('./ddragon/'.$version.'/data/'.$lang.'/summoner.json');
	$spells = json_decode($result, true);

	isset($_GET["lane"])? $lane = $_GET["lane"] : $lane = "top";
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
		<div class="container" style="width:90%;margin-bottom:25px;">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<form method="get">
						<div class="form-group">
							<label for="lane">Lane:</label>
							<select class="form-control" name="lane" id="lane">
								<option value="top" <?php if($lane == "top") echo "selected"; ?>>top</option>
								<option value="mid" <?php if($lane == "mid") echo "selected"; ?>>mid</option>
								<option value="jungler" <?php if($lane == "jungler") echo "selected"; ?>>jungler</option>
								<option value="bot" <?php if($lane == "bot") echo "selected"; ?>>bot</option>
								<option value="sup" <?php if($lane == "sup") echo "selected"; ?>>sup</option>
							</select>
						</div>
						
						<button class="btn btn-primary" type="submit">Let's go</button>
					</form>
				</div>
			</div>
			<?php
				$kicked_items = [3671,3672,3673,3675,2033,3007,3008,3029];
				$jungler_items = [1400,1401,1402,1412,1413,1414,1416,1419];
				$support_items = [3069,3092,3401];
				//var_dump($items["data"][3040]);
				$availableItems = [];
				foreach($items["data"] as $key => $item){
					if(!isset($item["into"]) && isset($item["from"]) && !isset($item["requiredAlly"]) && !isset($item["requiredChampion"]) && $item["maps"][11] 
					&& !in_array($key, $kicked_items) && !in_array($key, $jungler_items) && !in_array($key, $support_items) && $item["gold"]["purchasable"]){
						$availableItems[] = $key;
					}
				}

				/*for($i = 0 ; $i < sizeof($availableItems) ; ++$i){
					echo $availableItems[$i]." - ";
					echo '<img src="./ddragon/9.9.1/img/item/'.$availableItems[$i].'.png"/>';
				}*/

				//Pas bon :
				//Hydra & Runaan
				$i = 0;
				$stuff = [];
				
				if($lane == "jungler"){
					$index = rand(0, sizeof($jungler_items)-1);
					echo $jungler_items[$index]." - ";
					$stuff[] = $jungler_items[$index];
					$i++;
				}else if($lane == "sup"){
					$index = rand(0, sizeof($support_items)-1);
					echo $support_items[$index]." - ";
					$stuff[] = $support_items[$index];
					$i++;
				}

				for($i ; $i < 6 ; ++$i){
					$index = rand(0, sizeof($availableItems)-1);
					echo $availableItems[$index]." - ";
					$stuff[] = $availableItems[$index];
					//echo '<img src="./ddragon/9.9.1/img/item/'.$availableItems[$index].'.png"/>';
					array_splice($availableItems, $index, 1);
				}
			?>
		</div>
		<?php require_once("./parts/bas.html"); ?>
	</body>
</html>