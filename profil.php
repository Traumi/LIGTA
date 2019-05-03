<?php
	
	require_once("parts/init.php");

	$result = file_get_contents('./ddragon/'.$version.'/data/'.$lang.'/champion.json');
	$champions = json_decode($result);

	$result = file_get_contents('./data/gametype.json');
	$gametype = json_decode($result);

	$result = file_get_contents('./ddragon/'.$version.'/data/'.$lang.'/summoner.json');
	$spells = json_decode($result);

	$sale_hop = true;

	if(isset($_GET['pseudo'])){

		$pseudo = str_replace ( " " , "" , $_GET["pseudo"]);

		if(!file_get_contents('https://euw1.api.riotgames.com/lol/summoner/v4/summoners/by-name/'.$pseudo.'?api_key='.$key)){
			$sale_hop = false;
		}else{
			//Init
			if (!file_exists('data/players/'.$pseudo)) {
	          mkdir('data/players/'.$pseudo, 0777, true);
	          $file = fopen("data/players/$pseudo/date.txt", "w");
		      fwrite($file, "1990-01-01");
		      fclose($file);
	        }

	        $lastMaj = file_get_contents('data/players/'.$pseudo.'/date.txt');
		    $now = date("Y-m-d H:i");
		    $datetime1 = new DateTime($lastMaj);
		    $datetime2 = new DateTime($now);
		    $interval = $datetime1->diff($datetime2);
		    
		    //var_dump($interval);// $interval;

		    $sincelastupdate = ($interval->format("%a"))*24*60 + ($interval->h)*60 + ($interval->i);

		    //echo $sincelastupdate;

		    if($sincelastupdate >= 30){

	    		//Summoner
	    		//$result = file_get_contents('https://euw1.api.riotgames.com/lol/summoner/v4/summoners/by-name/'.str_replace ( " " , "" , $pseudo).'?api_key='.$key);
		        $result = file_get_contents('https://euw1.api.riotgames.com/lol/summoner/v4/summoners/by-name/'.$pseudo.'?api_key='.$key);
		        $file = fopen("data/players/$pseudo/summoner.json", "w");
		        fwrite($file, $result);
		        fclose($file);
		        $result = file_get_contents('data/players/'.$pseudo.'/summoner.json');
		        $profil = json_decode($result);
				
				$id = $profil->id;
				$accountId = $profil->accountId;

				//Rank
				if($result = file_get_contents('https://euw1.api.riotgames.com/lol/league/v4/positions/by-summoner/'.$id.'?api_key='.$key)){
					$file = fopen("data/players/$pseudo/ranks.json", "w");
			        fwrite($file, $result);
			        fclose($file);
				}
		        
				//Masteries
		        if($result = file_get_contents('https://euw1.api.riotgames.com/lol/champion-mastery/v4/champion-masteries/by-summoner/'.$id.'?api_key='.$key)){
		        	$file = fopen("data/players/$pseudo/masteries.json", "w");
			        fwrite($file, $result);
			        fclose($file);
		        }
		        
		        //Games 
		        if($result = file_get_contents('https://euw1.api.riotgames.com/lol/match/v4/matchlists/by-account/'.$accountId.'?api_key='.$key)){
		        	$file = fopen("data/players/$pseudo/matches.json", "w");
			        fwrite($file, $result);
			        fclose($file);
		        }
		        
		        $file = fopen("data/players/$pseudo/date.txt", "w");
		        fwrite($file, $now);
		        fclose($file);
		    	

		    }

	    	//Summoner
	        $result = file_get_contents('data/players/'.$pseudo.'/summoner.json');
	        $profil = json_decode($result);
			
			$id = $profil->id;
			$accountId = $profil->accountId;

			//Ranks
			$result = file_get_contents('data/players/'.$pseudo.'/ranks.json');
	        $ranks = json_decode($result);

			//Masteries
	        $result = file_get_contents('data/players/'.$pseudo.'/masteries.json');
	        $masteries = json_decode($result);

	        //Games
	        $result = file_get_contents('data/players/'.$pseudo.'/matches.json');
	        $matches = json_decode($result);

		    //$result = file_get_contents('https://euw1.api.riotgames.com/lol/spectator/v4/active-games/by-summoner/'.$id.'?api_key='.$key);
		    //var_dump(json_decode($result));


		}
		
	}
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
		<title>Profil de <?php echo $profil->name; ?></title>
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
			<?php if($sale_hop){ ?>
			<?php 

				$level = $profil->summonerLevel;
				if($level < 30){
					$index_lvl = 1;
				}else if($level < 50){
					$index_lvl = 30;
				}else if($level < 75){
					$index_lvl = 50;
				}else if($level < 100){
					$index_lvl = 75;
				}else if($level < 125){
					$index_lvl = 100;
				}else if($level < 150){
					$index_lvl = 125;
				}else if($level < 175){
					$index_lvl = 150;
				}else if($level < 200){
					$index_lvl = 175;
				}else if($level < 225){
					$index_lvl = 200;
				}else if($level < 250){
					$index_lvl = 225;
				}else if($level < 275){
					$index_lvl = 250;
				}else if($level < 300){
					$index_lvl = 275;
				}else if($level < 325){
					$index_lvl = 300;
				}else if($level < 350){
					$index_lvl = 325;
				}else if($level < 375){
					$index_lvl = 350;
				}else if($level < 400){
					$index_lvl = 375;
				}else if($level < 425){
					$index_lvl = 400;
				}else if($level < 450){
					$index_lvl = 425;
				}else if($level < 475){
					$index_lvl = 450;
				}else if($level < 500){
					$index_lvl = 475;
				}else{
					$index_lvl = 500;
				}

			?>
			<div style="text-align: center;position:relative;padding:0;width:300px;margin-left:calc(50% - 150px);margin-top:20px;">
				<img style="position:absolute;bottom:22%;width:56%;left:22%;border-radius:100%;" src="ddragon/<?php echo $version; ?>/img/profileicon/<?php echo $profil->profileIconId; ?>.png "/>
				<img style="position:absolute;width:100%;left:0;" src="images/border/Level_<?php echo $index_lvl ?>_Summoner_Icon_Border.png"/>
				<div style="width:100%;height:300px;"></div>
				<div style="position:absolute;bottom:15%;width:100%;color:white;font-size:20px;"><?php echo $profil->summonerLevel; ?></div>
			</div>
			<div style="text-align:center;margin-top:5px;font-size:30px;margin-bottom:5px;"><?php echo $profil->name; ?></div>
			<?php 
				$lastMaj = file_get_contents('data/players/'.$pseudo.'/date.txt'); 
			?>
			<div style="text-align:center;font-size:12px;margin-bottom:15px;">Dernière mise à jour : <?php echo $lastMaj; ?></div>
			<!--<img style="width:100%;left:0;" src="images/prestige/Level_<?php echo $index_lvl ?>_Prestige_Emote.png" />-->

			<style>
				#menu_principal{
					background:#ccc;
					padding:0;
					margin:0;
					margin-bottom:15px;
					border-radius: 10px;
					overflow:hidden;
				}

				#menu_principal > ul{
					margin:0;
					padding:0;
				}

				#menu_principal > ul > li{
					display:inline-block;
					padding-top:15px;
					padding-bottom:15px;
					text-align:center;
					width:20%;
					margin:0;
					border:none;
					font-weight: bold;
					background:#ccc;
					transition: 1s;
					cursor:pointer;
				}

				#menu_principal > ul > li:hover{
					background: #727272;
					color:#e6e6e6;
					text-decoration: dotted underline;
					transition: 1s;
				}

				#menu_principal > ul > li.active{
					background: #727272;
					color:#e6e6e6;
					text-decoration: underline;
				}

				body.dark #menu_principal > ul > li{
					background:#555;
				}

				body.dark #menu_principal{
					background:#555;
				}

				body.dark #menu_principal > ul > li:hover{
					background: #a1a1a1;
					color:#0d0d0d;
					transition: 1s;
				}

				body.dark #menu_principal > ul > li.active{
					background: #a1a1a1;
					color:#0d0d0d;
				}

				#mastery, #games, #inprogress, #resume{
					display:none;
				}

				.infotb{
					margin-left:5px;
					margin-right:5px;
					border-radius:5px;
					background:#dfdfdf;
					border:solid darkgrey 2px;
				}

				body.dark .infotb{
					background:#444;
					border:solid lightgrey 2px;
				}

				.mastery{
					border:solid darkgrey 2px;
					background:#dfdfdf;
					color:#333;
				} 

				body.dark .mastery{
					border:solid lightgrey 2px;
					background:#444;
					color:#ccc;
				}

				.champPoints{
					font-size:18px;
				}
			
				.goldchamp path{
					fill:#DAA520;
				}

				.silverchamp path{
					fill:#7F7F7F;
				}

				body.dark .silverchamp path{
					fill:#A9A9A9;
				}

				.silvercolor{
					color:#7F7F7F;
				}

				body.dark .silvercolor{
					color:#A9A9A9;
				}

				.silverborder{
					stroke:#7F7F7F;
				}

				body.dark .silverborder{
					stroke:#A9A9A9;
				}

				.silvertext{
					fill:#7F7F7F;
				}

				body.dark .silvertext{
					fill:#A9A9A9;
				}

				.bronzechamp path{
					fill:#cd7f32;
				}

				.level-match{
					background:black;
					color:white;
					padding-top:5px;
					border-radius:100%;
					width:25px;
					height:25px;
					display:inline-block;
					text-align:center;
					margin-right:10px;
					font-size:12px;
					overflow:hidden;
					position:absolute;
					top:60px;
					left:32px;
					font-weight: bold;
				}

				.level-champ{
					background:black;
					color:white;
					padding-top:5px;
					border-radius:100%;
					width:30px;
					height:30px;
					display:inline-block;
					text-align:center;
					margin-right:10px;
					font-size:15px;
					overflow:hidden;
					position:absolute;
					top:108px;
					left:60px;
					font-weight: bold;
				}

				.mention{
					border:solid black 2px;
					border-radius:12px;
					padding:0 5px 0 5px;
					display: inline-block;
					font-size:15px;
					height:24px;
					font-weight: bold;
					margin:2px;
				}

				.double{
					border-color: #3C0000;
					color:#3C0000;
					background: #F17474;
				}
				.triple{
					border-color: #7A0000;
					color:#7A0000;
					background: #F17474;
				}
				.quadra{
					border-color: #AF0000;
					color:#AF0000;
					background: #F17474;
				}
				.penta{
					border-color: #C00000;
					color:#C00000;
					background: #F17474;
				}

				.illuminatis{
					border-color: #F1A400;
					color:#F1A400;
					background: #FFFAB6;
				}

				.legendary{
					border-color: #33AC33;
					color:#33AC33;
					background: #91C991;
				}
				.godlike{
					border-color: #2D9A2D;
					color:#2D9A2D;
					background: #91C991;
				}
				.dominating{
					border-color: #278827;
					color:#278827;
					background: #91C991;
				}
				.unstoppable{
					border-color: #217621;
					color:#217621;
					background: #91C991;
				}
				.rampage{
					border-color: #1B641B;
					color:#1B641B;
					background: #91C991;
				}
				.kspree{
					border-color: #155215;
					color:#155215;
					background: #91C991;
				}

				.efarm{
					border-color: #00aaaa;
					color:#00aaaa;
					background: #89FFFF;
					
				}
				.sfarm{
					border-color: #008888;
					color:#008888;
					background: #89FFFF;
				}
				.gfarm{
					border-color: #005555;
					color:#005555;
					background: #89FFFF;
				}
				.gvs{
					border-color: #00ace6;
					color:#00ace6;
					background: #9ADEF4;
				}
				.perfkda{
					border-color: #00BB99;
					color:#00BB99;
					background: #9CE1C2;
				}
				.ekda{
					border-color: #009977;
					color:#009977;
					background: #9CE1C2;
				}
				.grkda{
					border-color: #006655;
					color:#006655;
					background: #9CE1C2;
				}
				.gokda{
					border-color: #003333;
					color:#003333;
					background: #9CE1C2;
				}

				.firstblood{
					border-color: #990000;
					color:#990000;
					background: #CA8585;
				}


			</style>
			<script>
				function selectPart(nom, btn){
					document.getElementById("base").style.display = "none";
					document.getElementById("mastery").style.display = "none";
					document.getElementById("games").style.display = "none";
					document.getElementById("inprogress").style.display = "none";
					document.getElementById("resume").style.display = "none";
					document.getElementById("basebtn").classList.remove("active");
					document.getElementById("masterybtn").classList.remove("active");
					document.getElementById("gamesbtn").classList.remove("active");
					document.getElementById("inprogressbtn").classList.remove("active");
					document.getElementById("resumebtn").classList.remove("active");

					document.getElementById(nom).style.display = "block";
					btn.classList.add("active");
				}
			</script>
			<div id="loading" style="position:fixed;width:100%;height:100vh;top:0;left:0;background:rgba(0,0,0,0.5);">
				<div style="width:500px;height:300px;background:white;margin-left:calc(50% - 250px);margin-top:calc(50vh - 150px);padding-top: 75px;text-align:center;">
					<h3 style="color:black;margin-bottom:35px;">Chargement en cours...</h3>
					<img src="./ddragon/img/global/load01.gif"/>
				</div>
			</div>
			<div id="menu_principal">
				<?php require_once('./parts/'.$lang.'/profil-menu.php'); ?>
			</div>

			<div id="base" style="border:solid lightgrey 2px; border-radius:15px;width:900px;margin-left:calc(50% - 450px);overflow:hidden;margin-bottom:25px;">
				<?php require_once('./parts/'.$lang.'/base.php'); ?>
			</div>
			<div id="mastery">
				<?php 
				$podium = 1;
				$podiumArray = array();
				$ptsmastery = 0;
				$lvlmastery = 0;
				$lvlmasterymax = 0;
				foreach($masteries as $aaa => $infochamp){
					
					//var_dump($infochamp);
					foreach($champions->data as $champname => $champ ){
						if($champ->key == $infochamp->championId){
							if($podium == 1){
								$podiumArray[1] = ["name" => $champname, "level" => $infochamp->championLevel, "points" => $infochamp->championPoints];
								$podium++;
							}
							else if($podium == 2){
								$podiumArray[2] = ["name" => $champname, "level" => $infochamp->championLevel, "points" => $infochamp->championPoints];
								$podium++;
							}
							else if($podium == 3){
								$podiumArray[3] = ["name" => $champname, "level" => $infochamp->championLevel, "points" => $infochamp->championPoints];
								$podium++;
							}
							$ptsmastery += $infochamp->championPoints;
							$lvlmastery += $infochamp->championLevel;
						}

					}
				}

				foreach($champions->data as $champname => $champ ){
					$lvlmasterymax += 7;
				}

				echo '<div id="mastery_infos" class="col-md-6 col-xs-12" style="text-align:center;margin-bottom:5px;position:relative;margin-bottom:25px;">';
				echo '<div class="infotb">';
					//echo "<div>Score de maîtrise : $lvlmastery / $lvlmasterymax</div>";
					//echo "<div>Points de maîtrise : $ptsmastery</div>";

					$percent = $lvlmastery / $lvlmasterymax * 100;
				?>

				<svg style="max-height:350px;" viewBox="0 0 42 50" class="donut">
				  
				  	<circle class="donut-ring" cx="21" cy="21" r="15.91549430918954" fill="transparent" stroke="#aaa" stroke-width="3"/>

				  	<circle class="donut-segment" cx="21" cy="21" r="15.91549430918954" fill="transparent" stroke="#d17914" stroke-width="2.25" stroke-dasharray="<?php echo $percent." ".(100-$percent); ?>" stroke-dashoffset="25" stroke-linecap="round"/>
				  	<text x="21" y="20" text-anchor="middle" style="font-size: 6px" fill="#d17914"><?php echo round($percent,1) ?>%</text>
				  	<text x="21" y="27" text-anchor="middle" style="font-size: 4px" fill="#d17914"><?php echo $lvlmastery ?></text>
				  	<line x1="16" y1="28" x2="26" y2="28" style="stroke:#d17914;stroke-width:0.3"/>
				  	<text x="21" y="32" text-anchor="middle" style="font-size: 4px" fill="#d17914"><?php echo $lvlmasterymax ?></text>
				  	<text x="21" y="46" text-anchor="middle" style="font-size: 3px" fill="#d17914"><?php echo $ptsmastery ?> points</text>
				</svg>
				<?php
				echo '</div>';
				echo '</div>';
				echo '<div id="mastery_podium" class="col-md-6 col-xs-12" style="text-align:center;margin-bottom:5px;position:relative;margin-bottom:25px;">';
				?>
				<div class="infotb">
				<svg viewbox="0 0 500 225" style="max-height:350px;">
					<defs>
						<rect id="rect1" x="210" y="10" width="80px" height="80px" rx="80"/>
						<clipPath id="clip1">
							<use xlink:href="#rect1"/>
						</clipPath>
						<rect id="rect2" x="60" y="20" width="70px" height="70px" rx="70"/>
						<clipPath id="clip2">
							<use xlink:href="#rect2"/>
						</clipPath>
						<rect id="rect3" x="370" y="20" width="70px" height="70px" rx="70"/>
						<clipPath id="clip3">
							<use xlink:href="#rect3"/>
						</clipPath>
					</defs>
					<!--N°1-->
					<use xlink:href="#rect1" stroke-width="4" stroke="#DAA520"/>
					<image xlink:href="<?php echo 'ddragon/'.$version.'/img/champion/'.$podiumArray[1]["name"].'.png' ?>" x="210" y="10" height="80" width="80" clip-path="url(#clip1)"/>
					<image xlink:href="<?php echo 'images/mastery/cm'.$podiumArray[1]["level"].'.png' ?>" x="225" y="65" height="50" width="50"/>
					<g class="goldchamp" transform="translate(210,112.5) scale(0.8)"><!--128 125.8-->
						<?php require("parts/laurier.svg"); ?>
						<text x="50" y="63" font-size="40" font-weight="600" fill="#DAA520" font-family="Verdana" text-anchor="middle">1</text>
						<text x="50" y="122" font-size="18" fill="#DAA520" font-family="Verdana" text-anchor="middle"><?php echo $podiumArray[1]["points"] ?></text>
					</g>
					
					<!--N°2-->
					<use xlink:href="#rect2" stroke-width="4" class="silverborder"/>
					<image xlink:href="<?php echo 'ddragon/'.$version.'/img/champion/'.$podiumArray[2]["name"].'.png' ?>" x="60" y="20" height="70" width="70" clip-path="url(#clip2)"/>
					<image xlink:href="<?php echo 'images/mastery/cm'.$podiumArray[2]["level"].'.png' ?>" x="75" y="70" height="40" width="40"/>
					<g class="silverchamp" transform="translate(60,122.5) scale(0.7)">
						<?php require("parts/laurier.svg"); ?>
						<text x="50" y="63" font-size="40" font-weight="600" class="silvertext" font-family="Verdana" text-anchor="middle">2</text>
						<text x="50" y="125" font-size="18" class="silvertext" font-family="Verdana" text-anchor="middle"><?php echo $podiumArray[2]["points"] ?></text>
					</g>
					<!--N°3-->
					<use xlink:href="#rect3" stroke-width="4" stroke="#cd7f32"/>
					<image xlink:href="<?php echo 'ddragon/'.$version.'/img/champion/'.$podiumArray[3]["name"].'.png' ?>" x="370" y="20" height="70" width="70" clip-path="url(#clip3)"/>
					<image xlink:href="<?php echo 'images/mastery/cm'.$podiumArray[3]["level"].'.png' ?>" x="385" y="70" height="40" width="40"/>
					<g class="bronzechamp" transform="translate(370,122.5) scale(0.7)">
						<?php require("parts/laurier.svg"); ?>
						<text x="50" y="63" font-size="40" font-weight="600" fill="#cd7f32" font-family="Verdana" text-anchor="middle">3</text>
						<text x="50" y="125" font-size="18" fill="#cd7f32" font-family="Verdana" text-anchor="middle"><?php echo $podiumArray[3]["points"] ?></text>
					</g>
				</svg>
				</div>
				<?php
				/*echo '<div class="infotb">';

					echo '<div style="position:absolute;top:15px;left:30%;width:40%;">';
						echo '<div style="position:relative;">';
							echo '<img style="width:50%;max-width:175px;border-radius:100%;border:solid #DAA520 5px;" src="http://ddragon.leagueoflegends.com/cdn/'.$version.'/img/champion/'.$podiumArray[1]["name"].'.png" />';
							echo '<div style="position:absolute;bottom:-30%;width:100%;"><img src="images/mastery/cm'.$podiumArray[1]["level"].'.png" style="width:35%;max-width:100px;"/></div>';
						echo '</div>';
					echo '</div>';
					echo '<div style="position:absolute;bottom:0px;left:calc(50% - 100px);width:200px;font-size:28px;color:#DAA520;">'.$podiumArray[1]["points"].'</div>';
					echo '<div style="position:absolute;bottom:50px;left:calc(50% - 100px);width:200px;font-size:50px;color:#DAA520;">1</div>';
					echo '<div class="goldchamp" style="position:absolute;bottom:35px;left:calc(50% - 100px);width:200px;color:white">';
					
					echo '</div>';

					echo '<div style="position:absolute;top:50px;left:0%;width:30%;">';
						echo '<div style="position:relative;">';
							echo '<img class="silverborder" style="width:50%;max-width:140px;border-radius:100%;" src="http://ddragon.leagueoflegends.com/cdn/'.$version.'/img/champion/'.$podiumArray[2]["name"].'.png" />';
							echo '<div style="position:absolute;bottom:-30%;width:100%;"><img src="images/mastery/cm'.$podiumArray[2]["level"].'.png" style="width:35%;max-width:100px;"/></div>';
						echo '</div>';
					echo '</div>';
					echo '<div class="silvercolor" style="position:absolute;bottom:0px;left:calc(15% - 75px);width:150px;font-size:25px;">'.$podiumArray[2]["points"].'</div>';
					echo '<div class="silvercolor" style="position:absolute;bottom:50px;left:calc(15% - 75px);width:150px;font-size:50px;">2</div>';
					echo '<div class="silverchamp" style="position:absolute;bottom:35px;left:calc(15% - 75px);width:150px;color:white">';
					require("parts/laurier.svg");
					echo '</div>';

					echo '<div style="position:absolute;top:50px;right:0%;width:30%;">';
						echo '<div style="position:relative;">';
							echo '<img style="width:50%;max-width:140px;border-radius:100%;border:solid #cd7f32 5px;" src="http://ddragon.leagueoflegends.com/cdn/'.$version.'/img/champion/'.$podiumArray[3]["name"].'.png" />';
							echo '<div style="position:absolute;bottom:-30%;width:100%;"><img src="images/mastery/cm'.$podiumArray[3]["level"].'.png" style="width:35%;max-width:100px;"/></div>';
						echo '</div>';
					echo '</div>';
					echo '<div style="position:absolute;bottom:0px;right:calc(15% - 75px);width:150px;font-size:25px;color:#cd7f32;">'.$podiumArray[3]["points"].'</div>';
					echo '<div style="position:absolute;bottom:50px;right:calc(15% - 75px);width:150px;font-size:50px;color:#cd7f32;">3</div>';
					echo '<div class="bronzechamp" style="position:absolute;bottom:35px;right:calc(15% - 75px);width:150px;color:white">';
					require("parts/laurier.svg");
					echo '</div>';

				echo '</div>';*/
				echo '</div>';


				$masteriesArray = array();
				foreach($masteries as $aaa => $infochamp){
					foreach($champions->data as $champname => $champ ){
						if($champ->key == $infochamp->championId){
							
							$masteriesArray[] = ["name" => $champname, "level" => $infochamp->championLevel, "points" => $infochamp->championPoints];
							
						}
					}
				}
				//var_dump($masteriesArray);

				for($i = 7 ; $i > 0 ; $i--){
					echo '<div class="col-md-12 col-xs-12 mastery" style="padding:0;margin-bottom:20px;border-radius:10px;">';
					echo '<div style="border-bottom:solid lightgrey 2px; text-align:center;font-size:20px;"><img src="images/mastery/cm'.$i.'.png" style="width:80px;"/>Maîtrise '.$i.'</div>';
					echo '<div style="text-align:center;">';
					foreach($masteriesArray as $index => $content){
						if($content["level"] == $i){
							echo '<div class="col-lg-1 col-md-2 col-xs-3">';
							echo '<img style="width:80%;border-radius:100%;margin-top:15px;" src="http://ddragon.leagueoflegends.com/cdn/'.$version.'/img/champion/'.$content["name"].'.png" />';
							echo '<div style="width:100%;font-size:16px;margin-top:5px;font-weight:bold;">'.$content["points"].'</div>';
							echo '</div>';
						}
					}
					echo '</div>';
					echo "</div>";
				}

				?>

			</div>
			<div id="games">
				<?php 
					//var_dump($matches); 
				$index = 1;
					/*foreach($matches->matches as $num => $infos){
					}*/
					for($i = 0 ; $i < 10 ; $i++){
						try{
							$infos = $matches->matches[$i];
							if (!file_exists("data/games/".$infos->gameId.".json")) {
					        	$result = file_get_contents('https://euw1.api.riotgames.com/lol/match/v4/matches/'.$infos->gameId.'?api_key='.$key);
						        $file = fopen("data/games/".$infos->gameId.".json", "w");
						        fwrite($file, $result);
						        fclose($file);
					        }
					        $result = file_get_contents("data/games/".$infos->gameId.".json");
					        $game = json_decode($result);
							/*echo '<td>'.$index++.'</td>';
							echo '<td>'.$infos->platformId.'</td>';
							echo '<td>'.$infos->gameId.'</td>';
							echo '<td>'.$infos->champion.'</td>';
							echo '<td>'.$infos->queue.'</td>';
							echo '<td>'.$infos->season.'</td>';
							echo '<td>'.date('Y-m-d H:i:s', ($infos->timestamp/1000)).'</td>';//echo date('l jS \of F Y h:i:s A', (1546270479481/1000));
							echo '<td>'.$infos->role.'</td>';
							echo '<td>'.$infos->lane.'</td>';*/
							//var_dump($infos);
							foreach($game->participantIdentities as $idpi => $pi){
								if($pi->player->summonerId == $id){
									$id_stock = $pi->participantId;
									break;
								}
							}
							foreach($game->participants as $idpart => $part){
								if($id_stock == $part->participantId){
									$gamer = $part;
									break;
								}
							}

							$remake = false;
							if($game->gameDuration < (60*4+30)){
								$bg_col = "#888";
								$head_col = "#666";
								$remake = true;
							}else if($gamer->stats->win){
								$bg_col = "#80b3ff";
								$head_col = "#508aff";
							}else{
								$bg_col = "#ff8080";
								$head_col = "#ff5050";
							}

							echo '<div style="background:'.$bg_col.';width:75%;margin:auto;border-radius:10px;overflow:hidden;margin-bottom:10px;color:black;">';
							//var_dump($gamer);
							//echo '<br/>';
							foreach($gametype->type as $num_gt => $gt){
								if($num_gt == $game->queueId){
									$gtype = $gt;
									break;
								}
							}
							//echo $gtype;
							foreach($champions->data as $idch => $ch){
								if($ch->key == $gamer->championId){
									$gchamp = $ch->id;
								}
							}
							//echo $gchamp;
							/*
							echo $gamer->stats->kills.'/'.$gamer->stats->deaths.'/'.$gamer->stats->assists;
							echo date('Y-m-d H:i:s', ($infos->timestamp/1000));
							echo ' - '.round($game->gameDuration/60, 0.1).':'.sprintf('%02d', $game->gameDuration%60);
							echo ' - Items : '.$gamer->stats->item0.' - '.$gamer->stats->item1.' - '.$gamer->stats->item2.' - '.$gamer->stats->item3.' - '.$gamer->stats->item4.' - '.$gamer->stats->item5.' - '.$gamer->stats->item6;
							echo ' - MultiKill : '.$gamer->stats->largestMultiKill;
							echo ' - Killing Spree : '.$gamer->stats->largestKillingSpree;
							echo ' - Farm : '.$gamer->stats->totalMinionsKilled;
							echo ' - Champ level : '.$gamer->stats->champLevel;
							echo ' - Wards : '.$gamer->stats->wardsPlaced;
							echo ' - Pink Wards : '.$gamer->stats->visionWardsBoughtInGame;
							echo ' - Vision Score : '.$gamer->stats->visionScore;
							echo ' - First blood : '.$gamer->stats->firstBloodKill;
							*/
							$gamer_items = array();
							$gamer_items[0] = $gamer->stats->item0;
							$gamer_items[1] = $gamer->stats->item1;
							$gamer_items[2] = $gamer->stats->item2;
							$gamer_items[3] = $gamer->stats->item3;
							$gamer_items[4] = $gamer->stats->item4;
							$gamer_items[5] = $gamer->stats->item5;
							$gamer_items[6] = $gamer->stats->item6;
				?>
					<div style="width:100%;background:<?php echo $head_col; ?>;">
						<?php
							echo date('d/m/Y H:i', ($infos->timestamp/1000)).' - <span style="font-weight:bold;">'.$gtype.'</span> - '.floor($game->gameDuration/60).':'.sprintf('%02d', $game->gameDuration%60); 
						?>
					</div>
					<div style="display:inline-block;width:150px;position:relative;vertical-align:top;text-align: center;">
						<?php echo '<img src="./ddragon/'.$version.'/img/champion/'.$gchamp.'.png" style="width:100px;margin-top:25px;"/><span class="level-champ">'.$gamer->stats->champLevel.'</span>'; ?>
						<?php
							foreach($spells->data as $num => $spell ){
								if($gamer->spell1Id == $spell->key){
									echo '<img style="width:50px;" src="http://ddragon.leagueoflegends.com/cdn/'.$version.'/img/spell/'.$spell->id.'.png" />';
								}
								if($gamer->spell2Id == $spell->key){
									echo '<img style="width:50px;" src="http://ddragon.leagueoflegends.com/cdn/'.$version.'/img/spell/'.$spell->id.'.png" />';
								}
							}
						?>
						<div style="margin-top:5px;font-weight:bold;font-size:16px;"><?php echo $gamer->stats->kills.'/'.$gamer->stats->deaths.'/'.$gamer->stats->assists; ?></div>
						<div style="margin-top:5px;font-size:14px;">
							<?php 
								echo "KDA : ";
								if(($gamer->stats->kills+$gamer->stats->assists) <= 0)
									echo 0;
								else if($gamer->stats->deaths != 0) 
									echo round(($gamer->stats->kills+$gamer->stats->assists)/$gamer->stats->deaths, 2); 
								else 
									echo "Perfect"; 

							?>
							
						</div>
						
						
						
					</div><div style="display:inline-block;width:calc(100% - 150px);vertical-align:top;">
						<?php 
							for($j = 0 ; $j <= 6 ; $j++){
								if($gamer_items[$j] == 0) echo '<img style="width:64px;" src="./images/no_item.svg"/>';
								else echo '<img style="width:64px;" src="./ddragon/'.$version.'/img/item/'.$gamer_items[$j].'.png"/>';
							}
						?>

					<!--<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">-->
					<?php

						$a_totaldmg = $g_totaldmg = $gamer->stats->totalDamageDealtToChampions;
						$a_totaltank = $g_totaltank = $gamer->stats->totalDamageTaken;
						$a_totalgold = $g_totalgold = $gamer->stats->goldEarned;
						$a_totalpush = $g_totalpush = ($gamer->stats->turretKills + $gamer->stats->inhibitorKills);
						$a_totalfarm = $g_totalfarm = ($gamer->stats->totalMinionsKilled + $gamer->stats->neutralMinionsKilled);//totalHeal
						$a_totalheal = $g_totalheal = $gamer->stats->totalHeal;
						$a_totalvs = $g_totalvs = $gamer->stats->visionScore;
						//var_dump($gamer->stats);

						foreach($game->participants as $idpart => $part){
							if($part->stats->totalDamageDealtToChampions > $a_totaldmg){
								$a_totaldmg = $part->stats->totalDamageDealtToChampions;
							}
							if($part->stats->totalDamageTaken > $a_totaltank){
								$a_totaltank = $part->stats->totalDamageTaken;
							}
							if($part->stats->goldEarned > $a_totalgold){
								$a_totalgold = $part->stats->goldEarned;
							}
							if(($part->stats->turretKills + $part->stats->inhibitorKills) > $a_totalpush){
								$a_totalpush = ($part->stats->turretKills + $part->stats->inhibitorKills);
							}
							if(($part->stats->totalMinionsKilled + $part->stats->neutralMinionsKilled) > $a_totalfarm){
								$a_totalfarm = ($part->stats->totalMinionsKilled + $part->stats->neutralMinionsKilled);
							}
							if($part->stats->totalHeal > $a_totalheal){
								$a_totalheal = $part->stats->totalHeal;
							}
							if($part->stats->visionScore > $a_totalvs){
								$a_totalvs = $part->stats->visionScore;
							}


						}
						$ratiodmg = $g_totaldmg/$a_totaldmg;
						$ratiotank = $g_totaltank/$a_totaltank;
						$ratiogold = $g_totalgold/$a_totalgold;
						if($a_totalvs == 0){
							$ratiovs = 1;
						}else{
							$ratiovs = $g_totalvs/$a_totalvs;
						}
						if($a_totalpush == 0){
							$ratiopush = 1;
						}else{
							$ratiopush = $g_totalpush/$a_totalpush;
						}
						if($a_totalfarm == 0){
							$ratiofarm = 1;
						}else{
							$ratiofarm = $g_totalfarm/$a_totalfarm;
						}
						if($a_totalheal == 0){
							$ratioheal = 1;
						}else{
							$ratioheal = $g_totalheal/$a_totalheal;
						}
						
					?>
					<svg width="200" height="150" viewBox="0 0 400 300" xmlns="http://www.w3.org/2000/svg" version="1.1">
					    <polygon style="fill:none;stroke:#000000;stroke-width:2.5px" points="210,235 110,235 60,150 110,65 210,65 260,150 210,235" />
					    <line style="fill:none;stroke:#444;stroke-width:1.5px" x1="160" y1="150" x2="110"  y2="235" />
					    <line style="fill:none;stroke:#444;stroke-width:1.5px" x1="160" y1="150" x2="60"  y2="150" />
					    <line style="fill:none;stroke:#444;stroke-width:1.5px" x1="160" y1="150" x2="110"  y2="65" />
					    <line style="fill:none;stroke:#444;stroke-width:1.5px" x1="160" y1="150" x2="210"  y2="65" />
					    <line style="fill:none;stroke:#444;stroke-width:1.5px" x1="160" y1="150" x2="260"  y2="150" />
					    <line style="fill:none;stroke:#444;stroke-width:1.5px" x1="160" y1="150" x2="210"  y2="235" />
					    <circle r="7" cx="160" cy="150" />
					    <circle r="7" cx="<?php echo 160-((160-60)*$ratiotank); ?>" cy="<?php echo 150-((150-150)*$ratiotank); ?>" />
					    <circle r="7" cx="<?php echo 160-((160-110)*$ratiodmg); ?>" cy="<?php echo 150-((150-65)*$ratiodmg); ?>" />
					    <circle r="7" cx="<?php echo 160-((160-210)*$ratiogold); ?>" cy="<?php echo 150-((150-65)*$ratiogold); ?>" />
					    <circle r="7" cx="<?php echo 160-((160-260)*$ratiovs); ?>" cy="<?php echo 150-((150-150)*$ratiovs); ?>" />
					    <circle r="7" cx="<?php echo 160-((160-210)*$ratiofarm); ?>" cy="<?php echo 150-((150-235)*$ratiofarm); ?>" />
					    <circle r="7" cx="<?php echo 160-((160-110)*$ratioheal); ?>" cy="<?php echo 150-((150-235)*$ratioheal); ?>" />

					    <polygon style="fill:#1F992255;stroke:#000000;stroke-width:2.5px" 
					    	points="
					    		<?php echo 160-((160-60)*$ratiotank); ?>,<?php echo 150-((150-150)*$ratiotank); ?>
					    		<?php echo 160-((160-110)*$ratiodmg); ?>,<?php echo 150-((150-65)*$ratiodmg); ?>
					    		<?php echo 160-((160-210)*$ratiogold); ?>,<?php echo 150-((150-65)*$ratiogold); ?> 
					    		<?php echo 160-((160-260)*$ratiovs); ?>,<?php echo 150-((150-150)*$ratiovs); ?> 
					    		<?php echo 160-((160-210)*$ratiofarm); ?>,<?php echo 150-((150-235)*$ratiofarm); ?> 
					    		<?php echo 160-((160-110)*$ratioheal); ?>,<?php echo 150-((150-235)*$ratioheal); ?> " 
					    />

					    <text x="95" y="265" fill="black" font-size="25" text-anchor="middle" >Heal</text>
					    <text x="225" y="265" fill="black" font-size="25" text-anchor="middle" >Farm</text>
					    <text x="305" y="155" fill="black" font-size="25" text-anchor="middle" >Vision</text>
					    <text x="225" y="50" fill="black" font-size="25" text-anchor="middle" >Gold</text>
					    <text x="95" y="50" fill="black" font-size="25" text-anchor="middle" >Damage</text>
					    <text x="25" y="155" fill="black" font-size="25" text-anchor="middle" >Tank</text>
					</svg>
					

					</div>
					<hr style="margin:10px 0 10px 0;"/>
					<div style="text-align:center;padding-bottom:10px;">
						<?php
							//Mentions honorables :
							switch($gamer->stats->largestMultiKill){
								case 2 :
									echo '<span class="mention double">Doublé</span>';
									break;
								case 3 :
									echo '<span class="mention triple">Triplé</span>';
									break;
								case 4 :
									echo '<span class="mention quadra">Quadruplé</span>';
									break;
								case 5 :
									echo '<span class="mention penta">Pentakill</span>';
									break;
							}
							
							if($gamer->stats->largestKillingSpree > 8){
								echo '<span class="mention legendary">Legendary</span>';
							}else if($gamer->stats->largestKillingSpree == 7){
								echo '<span class="mention godlike">Godlike</span>';
							}else if($gamer->stats->largestKillingSpree == 6){
								echo '<span class="mention dominating">Dominating</span>';
							}else if($gamer->stats->largestKillingSpree == 5){
								echo '<span class="mention unstoppable">Unstoppable</span>';
							}else if($gamer->stats->largestKillingSpree == 4){
								echo '<span class="mention rampage">Rampage</span>';
							}else if($gamer->stats->largestKillingSpree == 3){
								echo '<span class="mention kspree">Killing spree</span>';
							}

							if($gamer->stats->unrealKills > 0){
								echo '<span class="mention illuminatis">Illuminatis</span>';
							}

							if(isset($gamer->stats->firstBloodKill)){
								if($gamer->stats->firstBloodKill){
									echo '<span class="mention firstblood">First Blood</span>';
								}
							}

							$cs_min = 60*($gamer->stats->totalMinionsKilled + $gamer->stats->neutralMinionsKilled)/($game->gameDuration);

							if(10 < $cs_min){
								echo '<span class="mention efarm">Excellent Farm</span>';
							}else if(8 < $cs_min){
								echo '<span class="mention sfarm">Super Farm</span>';
							}else if(6 < $cs_min){
								echo '<span class="mention gfarm">Bon Farm</span>';
							}

							if(($game->gameDuration/60)*1.1 < $gamer->stats->visionScore){
								echo '<span class="mention gvs">Bon Vision Score</span>';
							}

							if($gamer->stats->deaths != 0){
								$kda = ($gamer->stats->kills+$gamer->stats->assists)/$gamer->stats->deaths;
							}else if(($gamer->stats->kills+$gamer->stats->assists) <= 0){
								$kda = 0;
							}else{
								$kda = 999999;
							}

							if($kda >=  15){
								echo '<span class="mention perfkda">Perfect KDA</span>';
							}else if($kda >= 5){
								echo '<span class="mention ekda">Excellent KDA</span>';
							}else if($kda >= 4){
								echo '<span class="mention grkda">Super KDA</span>';
							}else if($kda >= 3){
								echo '<span class="mention gokda">Bon KDA</span>';
							}

							$topdmg = true;
							$topcrit = true; //largestCriticalStrike
							$toptank = true; // totalDamageTaken
							$topgold = true; //goldEarned
							$toppusher = true; // turretKills & inhibitorKills
							$topfarm = true; // totalMinionsKilled

							foreach($game->participants as $idpart => $part){
								if($part->stats->totalDamageDealtToChampions > $gamer->stats->totalDamageDealtToChampions){
									$topdmg = false;
								}
								if($part->stats->largestCriticalStrike > $gamer->stats->largestCriticalStrike){
									$topcrit = false;
								}
								if($part->stats->totalDamageTaken > $gamer->stats->totalDamageTaken){
									$toptank = false;
								}
								if($part->stats->goldEarned > $gamer->stats->goldEarned){
									$topgold = false;
								}
								if(($part->stats->turretKills + $part->stats->inhibitorKills) > ($gamer->stats->turretKills + $gamer->stats->inhibitorKills)){
									$toppusher = false;
								}
								if(($part->stats->totalMinionsKilled + $part->stats->neutralMinionsKilled) > ($gamer->stats->totalMinionsKilled + $gamer->stats->neutralMinionsKilled)){
									$topfarm = false;
								}
							}

							if($topdmg){
								echo '<span class="mention topdmg">Top Damage</span>';
							}
							/*if($topcrit){
								echo '<span class="mention topdmg">Critique</span>';
							}*/
							if($toptank){
								echo '<span class="mention toptank">The Tank</span>';
							}
							if($topgold){
								echo '<span class="mention topgold">Top Gold</span>';
							}
							if($toppusher){
								echo '<span class="mention toppush">Pusher</span>';
							}
							if($topfarm){
								echo '<span class="mention topfarm">Top Farm</span>';
							}
							
							/*
								echo '<span class="mention double">Doublé</span>';
								echo '<span class="mention triple">Triplé</span>';
								echo '<span class="mention quadra">Quadruplé</span>';
								echo '<span class="mention penta">Pentakill</span>';
								echo '<span class="mention illuminatis">Illuminatis</span>';
								echo '<span class="mention legendary">Legendary</span>';
								echo '<span class="mention godlike">Godlike</span>';
								echo '<span class="mention dominating">Dominating</span>';
								echo '<span class="mention unstoppable">Unstoppable</span>';
								echo '<span class="mention rampage">Rampage</span>';
								echo '<span class="mention kspree">Killing spree</span>';
								echo '<span class="mention gfarm">Bon Farm</span>';
								echo '<span class="mention efarm">Excellent Farm</span>';
								echo '<span class="mention firstblood">First Blood</span>';
								echo '<span class="mention gvs">Bon Vision Score</span>';
								echo '<span class="mention perfkda">Perfect KDA</span>';
								echo '<span class="mention ekda">Excellent KDA</span>';
								echo '<span class="mention grkda">Super KDA</span>';
								echo '<span class="mention gokda">Bon KDA</span>';
								echo '<span class="mention topdmg">Top Damage</span>';
								echo '<span class="mention toptank">The Tank</span>';
								echo '<span class="mention topgold">Top Gold</span>';
								echo '<span class="mention toppush">Pusher</span>';
								echo '<span class="mention topfarm">Top Farm</span>';
							/**/
						?>
					</div>
				<?php
							echo '</div>';
						}catch(Exception $e){

						}
					}
				?>
			</div>
			<style>
				#inprogress > button{
					width:80px;
					height:40px;
					color:#444;
					font-size: 20px;
				}

				#inprogress hr{
					margin-top:10px;
					margin-bottom:10px;
				}

				#inprogress .game-profil{
					border:solid #333 1px;
					padding:5px;
					background:#d9d9d9;
					border-radius: 5px;
				}

				body.dark #inprogress .game-profil{
					border:solid #ccc 1px;
					background:#4f4f4f;
				}

				body.dark #inprogress .game-profil hr{
					border-top-color:#999;
				}
			</style>
			<div id="inprogress" style="width:100%;text-align: center;">
				<button class="btn btn-success" onclick="currentGame()"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
				<?php //echo date('l jS \of F Y h:i:s A', (1546270479481/1000)); ?>
			</div>
			<div id="resume" style="width:100%;text-align: center;">
				En cours...
			</div>
			<script>
				function currentGame(){
					document.getElementById("inprogress").innerHTML = '<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">Chargement en cours...</div></div>';
					$.ajax({
					  url: "<?php echo 'test.php?id='.$id; ?>",
					  success: function(data) {
					    document.getElementById("inprogress").innerHTML = data;
					  }
					});
				}
				
			</script>
			<script>
				document.getElementById("loading").style.display = "none";
			</script>
		<?php }else{ echo '<h1 style="width:100%;text-align:center;">Ce joueur n\'existe pas...</h1>'; } ?>
		</div>
		<?php require_once("./parts/bas.html"); ?>
	</body>
</html>