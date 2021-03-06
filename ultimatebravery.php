<?php
	
	require_once("parts/init.php");

	$result = file_get_contents('./ddragon/'.$version.'/data/'.$lang.'/item.json');
	$items = json_decode($result, true);

	$result = file_get_contents('./ddragon/'.$version.'/data/'.$lang.'/summoner.json');
	$spells = json_decode($result, true);

	$result = file_get_contents('./ddragon/'.$version.'/data/'.$lang.'/runesReforged.json');
	$runes = json_decode($result, true);

	$result = file_get_contents('./ddragon/'.$version.'/data/'.$lang.'/champion.json');
	$champions = json_decode($result, true);

	$result = file_get_contents('./data/champranged.json');
	$champions_range = json_decode($result, true);

	isset($_GET["lane"])? $lane = $_GET["lane"] : $lane = "top";
?>
<html>
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
			.tooltip-inner {
				max-width: 250px;
				/* If max-width does not work, try using width instead */
				width: 250px; 
			}

			/*Riot of legends ITEMS*/
			stats{
				color:#CFD353;
			}
			passive{
				color:#3D7DDF;
			}
			active{
				color:#3D7DDF;
			}
			unique{
				color:#3D7DDF;
			}
			rules{
				color:#EF5656;
			}
			groupLimit{
				color:#FA9939;
			}
			mana{
				color:#A1A1FA;
			}
			scaleLevel{
				color:#BFBFBF;
			}
			unlockedPassive{
				color:#41C341;
			}
			consumable{
				color:#b66dff;
			}
			itemName, summonerName{
				color:#EFEFEF;
			}
			itemCost{
				color:#ffc321;
			}
			scaleAP{
				color:#00af43;
				font-weight:bold;
			}
			scaleAD{
				color:#e28902;
				font-weight:bold;
			}
			scaleLevel{
				color:#cccccc;
				font-weight:bold;
			}
			scaleHealth{
				color:#D54525;
				font-weight:bold;
			}

			input[type=checkbox]:not(checked) + label{
				filter: grayscale(100%);
			}

			input[type=checkbox]:checked + label{
				filter: grayscale(0%);
			}

			.runes img{
				margin:0 5px;
			}
		</style>
	</head>
	<body style="margin:0;padding:0;">
		<?php require_once("parts/header.php"); ?>
		<?php require_once("parts/footer.php"); ?>
		<div class="container" style="width:90%;margin-bottom:25px;">
			<div class="row">
				<div class="col-md-8 col-md-offset-2">
					<form method="get">
						<div class="form-group">
							<label for="lane">Lane:</label>
							<select class="form-control" name="lane" id="lane">
								<option value="top" <?php if($lane == "top") echo "selected"; ?>>Top Lane</option>
								<option value="mid" <?php if($lane == "mid") echo "selected"; ?>>Mid Lane</option>
								<option value="jungler" <?php if($lane == "jungler") echo "selected"; ?>>Jungler</option>
								<option value="bot" <?php if($lane == "bot") echo "selected"; ?>>Adc</option>
								<option value="sup" <?php if($lane == "sup") echo "selected"; ?>>Support</option>
							</select>
						</div>
						<div class="form-group">
							<span class="btn btn-primary" onclick="uncheckAll()">Uncheck all</span>
							<span class="btn btn-primary" onclick="checkAll()">Check all</span>
						</div>
						<div class="form-group text-center">
							<?php

								foreach($champions["data"] as $key => $champion){
									if(isset($_GET[$key])){
										if($_GET[$key] == "1"){
											echo '<input style="display:none;" type="checkbox" id="'.$key.'" name="'.$key.'" value="1" checked/>';
										}else{
											echo '<input style="display:none;" type="checkbox" id="'.$key.'" name="'.$key.'" value="1"/>';
										}
									}else{
										echo '<input style="display:none;" type="checkbox" id="'.$key.'" name="'.$key.'" value="1"/>';
									}
									echo '<label for="'.$key.'" style="margin:0;"><img width="48px" src="./ddragon/'.$version.'/img/champion/'.$key.'.png"/></label>';
								}
							?>
							
						</div>
						
						<button class="btn btn-success" type="submit">Let's go</button>
					</form>
				</div>
			</div>
			<?php

				$availableChamps = [];

				foreach($champions["data"] as $key => $champion){
					if(isset($_GET[$key])){
						if($_GET[$key] == "1"){
							$availableChamps[] = $key;
						}
					}
				}

				if(sizeof($availableChamps) <= 0){
					foreach($champions["data"] as $key => $champion){
						$availableChamps[] = $key;
					}
				}

				$index = rand(0, sizeof($availableChamps)-1);
				$champ = $availableChamps[$index];

				$ranged = $champions_range[$champ];

				//_____________________________________________________________________________________

				$availableBranches = [];
				$branche1 = [];
				$branche2 = [];
				$branche2["branche"] = null;
				foreach($runes as $key => $rune){
					$availableBranches[] = $key;
				}

				$index = rand(0, sizeof($runes)-1);
				$branche1["branche"] = $runes[$index];
				$index = rand(0, sizeof($branche1["branche"]["slots"][0]["runes"])-1);
				$branche1[0] = $branche1["branche"]["slots"][0]["runes"][$index];
				$index = rand(0, sizeof($branche1["branche"]["slots"][1]["runes"])-1);
				$branche1[1] = $branche1["branche"]["slots"][1]["runes"][$index];
				$index = rand(0, sizeof($branche1["branche"]["slots"][2]["runes"])-1);
				$branche1[2] = $branche1["branche"]["slots"][2]["runes"][$index];
				$index = rand(0, sizeof($branche1["branche"]["slots"][3]["runes"])-1);
				$branche1[3] = $branche1["branche"]["slots"][3]["runes"][$index];

				while($branche2["branche"] == null){
					$index = rand(0, sizeof($runes)-1);
					if($branche1["branche"] != $runes[$index]){
						$branche2["branche"] = $runes[$index];
					}
				}
				$index1 = rand(0, 2);
				$index2 = rand(0, 2);
				if($index1 == $index2) $index2 = ($index2 + 1)%3;
				$index1 += 1;
				$index2 += 1;
				$index = rand(0, sizeof($branche2["branche"]["slots"][$index1]["runes"])-1);
				$branche2[0] = $branche2["branche"]["slots"][$index1]["runes"][$index];
				$index = rand(0, sizeof($branche2["branche"]["slots"][$index2]["runes"])-1);
				$branche2[1] = $branche2["branche"]["slots"][$index2]["runes"][$index];
				

				//_____________________________________________________________________________________

				$kicked_items = [3671,3672,3673,3675,2033,3007,3008,3029];
				$jungler_items = [1400,1401,1402,1412,1413,1414,1416,1419];
				$support_items = [3069,3092,3401];
				$boots = [3006,3009,3020,3047,3111,3117,3158];
				$cac_items = [3074,3748];
				$ranged_items = [3085,3094];
				$availableItems = [];
				foreach($items["data"] as $key => $item){
					if(!isset($item["into"]) && isset($item["from"]) && !isset($item["requiredAlly"]) && !isset($item["requiredChampion"]) && $item["maps"][11] 
					&& !in_array($key, $kicked_items) && !in_array($key, $jungler_items) && !in_array($key, $support_items) && !in_array($key, $boots) && $item["gold"]["purchasable"]){
						if((!in_array($key, $cac_items) && $ranged == "RANGE") || (!in_array($key, $ranged_items) && $ranged == "CAC") || $ranged == "BOTH"){
							$availableItems[] = $key;
						}
						
					}
				}

				$i = 0;
				$stuff = [];
				
				if($lane == "jungler"){
					$index = rand(0, sizeof($jungler_items)-1);
					$stuff[] = $jungler_items[$index];
					$i++;
				}else if($lane == "sup"){
					$index = rand(0, sizeof($support_items)-1);
					$stuff[] = $support_items[$index];
					$i++;
				}

				$index = rand(0, sizeof($boots)-1);
				$stuff[] = $boots[$index];
				$i++;

				for($i ; $i < 6 ; ++$i){
					$index = rand(0, sizeof($availableItems)-1);
					$stuff[] = $availableItems[$index];
					if(in_array($availableItems[$index],$cac_items) ){
						for($j = 0 ; $j < sizeof($availableItems) ; ++$j){
							if(in_array($availableItems[$j],$cac_items)){
								array_splice($availableItems, $j, 1);
							}
						}
					}else{
						array_splice($availableItems, $index, 1);
					}
				}

				//_____________________________________________________________________________________

				$availableSummoners = [];
				$summoners = [];

				foreach($spells["data"] as $key => $spell){
					if(in_array("CLASSIC" , $spell["modes"])){
						$availableSummoners[] = $key;
					}
				}

				$i = 0;
				if($lane == "jungler"){
					for($j = 0 ; $j < sizeof($availableSummoners) ; ++$j){
						if($availableSummoners[$j] == "SummonerSmite"){
							$index = $j;
						}
					}
					$summoners[] = $availableSummoners[$index];
					array_splice($availableSummoners, $index, 1);
					$i++;
				}
				for($i ; $i < 2 ; ++$i){
					$index = rand(0, sizeof($availableSummoners)-1);
					$summoners[] = $availableSummoners[$index];
					array_splice($availableSummoners, $index, 1);
				}


				echo '<div class="text-center col-md-8 col-md-offset-2" style="border:solid lightgrey 1px;padding:10px 0 15px 0;border-radius:5px;">';
				echo '<img width="92px" src="./ddragon/'.$version.'/img/champion/'.$champions["data"][$champ]["id"].'.png"/>';
				echo '<h4 style="margin:5px 0 15px 0;">'.$champions["data"][$champ]["name"].'</h4>';
				echo '<div style="margin-bottom : 20px;">';
				foreach($summoners as $key => $summoner){
					echo '<div style="display:inline-block;margin:0 9px;">';
					$stringbuilder = '';
					$stringbuilder .= '<summonerName>'.$spells["data"][$summoner]["name"].'</summonerName>';
					$stringbuilder .= '<br/><br/>';
					$stringbuilder .= $spells["data"][$summoner]["description"];
					echo '<img width="64px" src="./ddragon/'.$version.'/img/spell/'.$summoner.'.png" data-html="true" data-toggle="tooltip" data-placement="top" title="'.$stringbuilder.'"/>';
					echo '</div>';
				}
				echo '</div>';
				echo '<div>';
				foreach($stuff as $key => $item){
					echo '<div style="display:inline-block;margin:0 9px;">';
					$stringbuilder = '';
					$stringbuilder .= '<itemName>'.$items["data"][$item]["name"].'</itemName>';
					$stringbuilder .= '<br/><br/>';
					$stringbuilder .= $items["data"][$item]["description"];
					$stringbuilder .= '<br/><br/>';
					$stringbuilder .= '<itemCost>'.$items["data"][$item]["gold"]["total"].' ('.$items["data"][$item]["gold"]["base"].')</itemCost>';
					echo '<img width="64px" src="./ddragon/'.$version.'/img/item/'.$item.'.png" data-html="true" data-toggle="tooltip" data-placement="top" title="'.$stringbuilder.'"/>';
					echo '</div>';
				}
				echo '</div>';
				echo '<hr width="90%" style="border-top-color:darkgrey;"/>';
				echo '<div class="runes">';
					echo '<div style="margin:20px 0">';
						echo '<img width="32px" src="./ddragon/img/'.$branche1["branche"]["icon"].'"/>';
						echo '<img width="64px" src="./ddragon/img/'.$branche1[0]["icon"].'" data-html="true" data-toggle="tooltip" data-placement="top" title="'.$branche1[0]["longDesc"].'"/>';
						echo '<img width="64px" src="./ddragon/img/'.$branche1[1]["icon"].'" data-html="true" data-toggle="tooltip" data-placement="top" title="'.$branche1[1]["longDesc"].'"/>';
						echo '<img width="64px" src="./ddragon/img/'.$branche1[2]["icon"].'" data-html="true" data-toggle="tooltip" data-placement="top" title="'.$branche1[2]["longDesc"].'"/>';
						echo '<img width="64px" src="./ddragon/img/'.$branche1[3]["icon"].'" data-html="true" data-toggle="tooltip" data-placement="top" title="'.$branche1[3]["longDesc"].'"/>';
					echo '</div>';
					echo '<div>';
						echo '<img width="32px" src="./ddragon/img/'.$branche2["branche"]["icon"].'"/>';
						echo '<img width="64px" src="./ddragon/img/'.$branche2[0]["icon"].'" data-html="true" data-toggle="tooltip" data-placement="top" title="'.$branche2[0]["longDesc"].'"/>';
						echo '<img width="64px" src="./ddragon/img/'.$branche2[1]["icon"].'" data-html="true" data-toggle="tooltip" data-placement="top" title="'.$branche2[1]["longDesc"].'"/>';
					echo '</div>';
				echo '</div>';
				echo '</div>';
			?>
		</div>
		<?php require_once("./parts/bas.html"); ?>
		<script>
			uncheckAll = function(){
				<?php
					foreach($champions["data"] as $key => $champion){
						echo 'document.getElementById("'.$key.'").checked = false;';
					}
				?>
			}
			checkAll = function(){
				<?php
					foreach($champions["data"] as $key => $champion){
						echo 'document.getElementById("'.$key.'").checked = true;';
					}
				?>
			}
			isEmpty = function(){
				let res = true;
				<?php
					foreach($champions["data"] as $key => $champion){
						echo 'if(document.getElementById("'.$key.'").checked == true) res = false;';
					}
				?>
				return res;
			}
			if(isEmpty()) checkAll();
		</script>
	</body>
</html>