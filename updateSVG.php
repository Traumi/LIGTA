<?php

	require_once("parts/init.php");
	require_once("parts/utils.php");

	$pseudo = str_replace ( " " , "" , $_GET["id"]);
	isset($_GET["skin"]) ? $skin = $_GET["skin"] : $skin = "0";
	isset($_GET["reg"])? $reg = $_GET["reg"] : $reg = "euw1";

	$result = file_get_contents('./ddragon/'.$version.'/data/'.$lang.'/champion.json');
	$champions = json_decode($result);

	$result = file_get_contents('./data/gametype.json');
	$gametype = json_decode($result);

	$result = file_get_contents('./ddragon/'.$version.'/data/'.$lang.'/summoner.json');
	$spells = json_decode($result);

	$result = file_get_contents('./data/champroles.json');
	$champroles = json_decode($result,true);

	$result = file_get_contents('./data/champinfos.json');
	$champinfos = json_decode($result,true);

	//Summoner
	$result = file_get_contents('data/'.$reg.'/players/'.$pseudo.'/summoner.json');
	$profil = json_decode($result);
	
	$id = $profil->id;
	$accountId = $profil->accountId;

	//Ranks
	$result = file_get_contents('data/'.$reg.'/players/'.$pseudo.'/ranks.json');
	$ranks = json_decode($result);

	//Masteries
	$result = file_get_contents('data/'.$reg.'/players/'.$pseudo.'/masteries.json');
	$masteries = json_decode($result);

	//Games
	$result = file_get_contents('data/'.$reg.'/players/'.$pseudo.'/matches.json');
	$matches = json_decode($result);

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


	$podium = 1;
	$podiumArray = array();
	$ptsmastery = 0;
	$lvlmastery = 0;
	$lvlmasterymax = 0;
	foreach($masteries as $aaa => $infochamp){
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

	$percent = $lvlmastery / $lvlmasterymax * 100;
	

	//SVG DATAS
	$rank_values = array("IRON" => 0 , "BRONZE" => 4 , "SILVER" => 8 , "GOLD" => 12 , "PLATINUM" => 16 , "DIAMOND" => 20 , "MASTER" => 24 , "GRANDMASTER" => 28 , "CHALLENGER" => 32);
	$division_values = array("IV" => 1 , "III" => 2 , "II" => 3 , "I" => 4);
	$rank_trad = ["UNRANKED" => "Non Classé", "IRON" => "Fer", "BRONZE" => "Bronze", "SILVER" => "Argent", "GOLD" => "Or", "PLATINUM" => "Platine", "DIAMOND" => "Diamant", "MASTER" => "Maître", "GRANDMASTER" => "Grand Maître", "CHALLENGER" => "Challenger"]; 
	$roman_trade = ["V" => "_5", "IV" => "_4", "III" => "_3", "II" => "_2", "I" => "_1", "" => ""];
	$highestR = "UNRANKED";
	$palier = "";
	$val = 0;
	foreach($ranks as $cle => $value){
		$tmp_val = $rank_values[$value->tier] + $division_values[$value->rank];
		if($tmp_val > $val){
			$val = $tmp_val;
			$highestR = $value->tier;
			$palier = $value->rank;
		}
	}
	$url = $highestR.$roman_trade[$palier];
	if($url == "UNRANKED_") $url = "unranked";

	$mainroles = [];
	$mainqueue = [];
	$mainroles["Top"] = 0;
	$mainroles["Jun"] = 0;
	$mainroles["Mid"] = 0;
	$mainroles["Adc"] = 0;
	$mainroles["Sup"] = 0;

	$mainqueue["SR"] = 0;
	$mainqueue["TT"] = 0;
	$mainqueue["HA"] = 0;
	$mainqueue["RO"] = 0;
	if($matches != null){
		foreach($matches->matches as $key => $match){
			switch(getQueueType($match->queue)){
				case "SR":
				$mainqueue["SR"]++;
				break;
				case "TT":
				$mainqueue["TT"]++;
				break;
				case "HA":
				$mainqueue["HA"]++;
				break;
				case "RO":
				$mainqueue["RO"]++;
				break;
			}
			if(isSRGame($match->queue)){
				foreach($champions->data as $aa => $champion){
					if($champion->key == $match->champion){
						foreach($champroles[$aa] as $aaa => $lane){
							switch($lane){
								case "Top" :
								$mainroles["Top"]++;
								break;
								case "Jun" :
								$mainroles["Jun"]++;
								break;
								case "Mid" :
								$mainroles["Mid"]++;
								break;
								case "Adc" :
								$mainroles["Adc"]++;
								break;
								case "Sup" :
								$mainroles["Sup"]++;
								break;
							}
						}
					}
				}
			}
		}
	}
	

	$highest = "Fill";
	$second = "";
	$val = 0;
	$sval = 0;
	if($mainroles["Top"]>$val){$highest = "Top";$val = $mainroles["Top"];}
	if($mainroles["Jun"]>$val){$highest = "Jungle";$val = $mainroles["Jun"];}
	if($mainroles["Mid"]>$val){$highest = "Mid";$val = $mainroles["Mid"];}
	if($mainroles["Adc"]>$val){$highest = "Bot";$val = $mainroles["Adc"];}
	if($mainroles["Sup"]>$val){$highest = "Support";$val = $mainroles["Sup"];}
	$min = $val*60/100;
	if($mainroles["Top"]>$sval && $mainroles["Top"] > $min && $highest != "Top"){$second = "Top";$sval = $mainroles["Top"];}
	if($mainroles["Jun"]>$sval && $mainroles["Jun"] > $min && $highest != "Jungle"){$second = "Jungle";$sval = $mainroles["Jun"];}
	if($mainroles["Mid"]>$sval && $mainroles["Mid"] > $min && $highest != "Mid"){$second = "Mid";$sval = $mainroles["Mid"];}
	if($mainroles["Adc"]>$sval && $mainroles["Adc"] > $min && $highest != "Bot"){$second = "Bot";$sval = $mainroles["Adc"];}
	if($mainroles["Sup"]>$sval && $mainroles["Sup"] > $min && $highest != "Support"){$second = "Support";$sval = $mainroles["Sup"];}

	$highestQ = "";
	$nameQ = "";
	$qval = 0;
	if($mainqueue["SR"]>$qval){$highestQ = "sr";$qval = $mainqueue["SR"];$nameQ="Normal";}
	if($mainqueue["TT"]>$qval){$highestQ = "tt";$qval = $mainqueue["TT"];$nameQ="3v3";}
	if($mainqueue["HA"]>$qval){$highestQ = "aram";$qval = $mainqueue["HA"];$nameQ="ARAM";}
	if($mainqueue["RO"]>$qval){$highestQ = "rgm";$qval = $mainqueue["RO"];$nameQ="Rotation";}



	$my_file = 'images/svgrecap/'.$reg.'/'.$profil->name.'.svg';
	$handle = fopen($my_file, 'w');
	$data = "";
	$data .= '<?xml version="1.0" encoding="UTF-8"?>';
	$data .= '<!DOCTYPE svg PUBLIC "-//W3C//DTD SVG 1.1//EN" "http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd">';
	$data .= '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 800 400" xmlns:xlink="http://www.w3.org/1999/xlink">';

	//Style
	$data .= '<style>text{font-family : "Helvetica Neue", Helvetica, Arial, sans-serif;}</style>';

	//Constantes
	$data .= '<defs>';
	$data .= '<rect id="rect" x="39.375" y="39.375" width="96.25" height="96.25" rx="100"/>';
	$data .= '<clipPath id="clip">';
		$data .= '<use xlink:href="#rect"/>';
	$data .= '</clipPath>';
	$data .= '<rect id="rect1b" x="210" y="10" width="80px" height="80px" rx="80"/>';
	$data .= '<clipPath id="clip1b">';
		$data .= '<use xlink:href="#rect1b"/>';
	$data .= '</clipPath>';
	$data .= '<rect id="rect2b" x="60" y="20" width="70px" height="70px" rx="70"/>';
	$data .= '<clipPath id="clip2b">';
		$data .= '<use xlink:href="#rect2b"/>';
	$data .= '</clipPath>';
	$data .= '<rect id="rect3b" x="370" y="20" width="70px" height="70px" rx="70"/>';
	$data .= '<clipPath id="clip3b">';
		$data .= '<use xlink:href="#rect3b"/>';
	$data .= '</clipPath>';
	$data .= '<filter id="f3" x="0" y="0" width="100%" height="100%">';
		$data .= '<feOffset result="offOut" in="SourceAlpha" dx="0" dy="0" />';
		$data .= '<feGaussianBlur result="blurOut" in="offOut" stdDeviation="5" />';
		$data .= '<feBlend in="SourceGraphic" in2="blurOut" mode="normal" />';
	$data .= '</filter>';
	$data .= '</defs>';

	//Base icon
	$data .= '<use xlink:href="#rect" stroke-width="2" stroke="black"/>';
	if(isset($podiumArray[1])){
		$data .= '<image href="'.imgToBase64('./ddragon/img/champion/splash/'.$podiumArray[1]["name"].'_'.$skin.'.jpg').'" x="0" y="-10%" width="100%"/>';
	}else{
		$data .= '<image href="'.imgToBase64('./ddragon/img/champion/splash/Gnar_0.jpg').'" x="0" y="-10%" width="100%"/>';
	}
	
	$data .= '<rect x="0" y="0" height="400" width="800" fill="#333333BC" />';
	$data .= '<image href="'.imgToBase64('./ddragon/'.$version.'/img/profileicon/'.$profil->profileIconId.'.png').'" clip-path="url(#clip)" y="39.375" x="39.375" height="96.25"/>';
	$data .= '<image href="'.imgToBase64('./images/border/Level_'.$index_lvl.'.png').'" x="0" y="0" height="175"/>';
	$data .= '<text text-anchor="middle" font-size="12" fill="white" x="87.5" y="144" font-weight="600">'.$profil->summonerLevel.'</text>';

	//Pseudo
	$data .= '<text text-anchor="middle" alignment-baseline="middle" font-size="30" fill="#e5e5e5" x="487.5" y="25">'.$profil->name.'</text>';
	$data .= '<image href="'.imgToBase64('./images/queuetype/underline_gold.png').'" x="400" y="35" width="175"/>';

	//Rank
	$data .= '<image href="'.imgToBase64('./images/rank/ranks_glow/'.$url.'.png').'" x="12.5" y="200" width="150" filter="url(#f3)"/>';
	$data .= '<text text-anchor="middle" font-size="16" fill="white" x="87.5" y="390">'.$rank_trad[$highestR].' '.$palier.'</text>';

	//Lineup
	$data .= '<line x1="0" y1="0" x2="800" y2="0" stroke-width="2" stroke="#C9C9C9"/>';
	$data .= '<line x1="0" y1="0" x2="0" y2="400" stroke-width="2" stroke="#C9C9C9"/>';
	$data .= '<line x1="800" y1="400" x2="0" y2="400" stroke-width="2" stroke="#C9C9C9"/>';
	$data .= '<line x1="800" y1="400" x2="800" y2="0" stroke-width="2" stroke="#C9C9C9"/>';
	$data .= '<line x1="175" y1="0" x2="175" y2="400" stroke="#C9C9C9"/>';
	$data .= '<line x1="175" y1="315" x2="290" y2="315" stroke="#C9C9C9"/>';
	$data .= '<line x1="375" y1="315" x2="440" y2="315" stroke="#C9C9C9"/>';
	$data .= '<line x1="600" y1="315" x2="535" y2="315" stroke="#C9C9C9"/>';
	$data .= '<line x1="800" y1="315" x2="685" y2="315" stroke="#C9C9C9"/>';
	$data .= '<line x1="775" y1="150" x2="625" y2="150" stroke="#C9C9C9"/>';

	//Podium
	$data .= '<g transform="scale(1 1) translate(237.5 260)">';

	$data .= '<use xlink:href="#rect1b" stroke-width="4" stroke="#DAA520"/>';
	if(isset($podiumArray[1])){
		$data .= '<image href="'.imgToBase64('./ddragon/img/champion/tiles/'.$podiumArray[1]["name"].'_0.jpg').'" x="210" y="10" height="80" width="80" clip-path="url(#clip1b)"/>';
		$data .= '<image href="'.imgToBase64('./images/mastery/cm'.$podiumArray[1]["level"].'.png').'" x="225" y="65" height="50" width="50"/>';
		$data .= '<text x="250" y="130" font-size="18" font-weight="600" fill="#DAA520" font-family="Verdana" text-anchor="middle">'.$podiumArray[1]["points"].'</text>';
	}else{
		
	}
	

	$data .= '<use xlink:href="#rect2b" stroke-width="4" stroke="#A9A9A9"/>';
	if(isset($podiumArray[2])){
		$data .= '<image href="'.imgToBase64('./ddragon/img/champion/tiles/'.$podiumArray[2]["name"].'_0.jpg').'" x="60" y="20" height="70" width="70" clip-path="url(#clip2b)"/>';
		$data .= '<image href="'.imgToBase64('./images/mastery/cm'.$podiumArray[2]["level"].'.png').'" x="75" y="70" height="40" width="40"/>';
		$data .= '<text x="95" y="130" font-size="18" font-weight="600" fill="#A9A9A9" font-family="Verdana" text-anchor="middle">'.$podiumArray[2]["points"].'</text>';
	}else{
		
	}
	

	$data .= '<use xlink:href="#rect3b" stroke-width="4" stroke="#d6854C"/>';
	if(isset($podiumArray[3])){
		$data .= '<image href="'.imgToBase64('./ddragon/img/champion/tiles/'.$podiumArray[3]["name"].'_0.jpg').'" x="370" y="20" height="70" width="70" clip-path="url(#clip3b)"/>';
		$data .= '<image href="'.imgToBase64('./images/mastery/cm'.$podiumArray[3]["level"].'.png').'" x="385" y="70" height="40" width="40"/>';
		$data .= '<text x="405" y="130" font-size="18" font-weight="600" fill="#d6854C" font-family="Verdana" text-anchor="middle">'.$podiumArray[3]["points"].'</text>';
	}else{
		
	}
	$data .= '</g>';
	
	//Maitrise
	$data .= '<text font-size="20" text-anchor="middle" x="285" y="90" fill="#DDD">Maîtrises</text>';
	$data .= '<g transform="translate(225 90) scale(3 3)">';
		$data .= '<circle class="donut-ring" cx="21" cy="21" r="15.91549430918954" fill="transparent" stroke="#1D7A91" stroke-width="3"/>';
		$data .= '<circle class="donut-segment" cx="21" cy="21" r="15.91549430918954" fill="transparent" stroke="#7FEFFF" stroke-width="2.25" stroke-dasharray="'.$percent.' '.(100-$percent).'" stroke-dashoffset="25" stroke-linecap="round"/>';
		$data .= '<text x="21" y="20" text-anchor="middle" style="font-size: 6px" fill="#7FEFFF">'.round($percent,1).'%</text>';
		$data .= '<text x="21" y="27" text-anchor="middle" style="font-size: 4px" fill="#7FEFFF">'.$lvlmastery.'</text>';
		$data .= '<line x1="16" y1="28" x2="26" y2="28" style="stroke:#7FEFFF;stroke-width:0.5"/>';
		$data .= '<text x="21" y="32" text-anchor="middle" style="font-size: 4px" fill="#7FEFFF">'.$lvlmasterymax.'</text>';
		$data .= '<text x="21" y="44" text-anchor="middle" style="font-size: 3.5px" fill="#7FEFFF">'.$ptsmastery.' points</text>';
	$data .= '</g>';

	//Role
	if($second != ""){
		$data .= '<text font-size="16" text-anchor="middle" x="700" y="180" fill="#DDD">Roles principaux</text>';
		$data .= '<image href="'.imgToBase64('./images/lanes/new/'.$highest.'-blue.png').'" x="650" y="185" height="50"/>';
		$data .= '<image href="'.imgToBase64('./images/lanes/new/'.$second.'-blue.png').'" x="700" y="185" height="50"/>';
		$data .= '<text font-size="12" text-anchor="middle" x="700" y="250" fill="#DDD">'.$highest.'/'.$second.'</text>';
	}else{
		$data .= '<text font-size="16" text-anchor="middle" x="700" y="180" fill="#DDD">Role principal</text>';
		$data .= '<image href="'.imgToBase64('./images/lanes/new/'.$highest.'-blue.png').'" x="675" y="185" height="50"/>';
		$data .= '<text font-size="12" text-anchor="middle" x="700" y="250" fill="#DDD">'.$highest.'</text>';
	}

	//Gamemode
	$data .= '<text font-size="16" text-anchor="middle" x="700" y="50" fill="#DDD">Mode de jeu préféré</text>';
	$data .= '<image href="'.imgToBase64('./images/queuetype/'.$highestQ.'.png').'" x="675" y="65" height="50"/>';
	$data .= '<text font-size="12" text-anchor="middle" x="700" y="135" fill="#DDD">'.$nameQ.'</text>';

	//Banner
	if(isset($_GET["clan"])){
		$banner_region = $_GET["clan"];
		foreach($masteries as $key => $mastery){
			foreach($champions->data as $champname => $champ ){
				if($champ->key == $mastery->championId){
					if($champinfos[$champ->id]["region"] == $banner_region){
						if($mastery->championLevel == 7){
							$banner_level = 3;
						}else if($mastery->championLevel == 6 || $mastery->championLevel == 5){
							$banner_level = 2;
						}else{
							$banner_level = 1;
						}
						break 2;
					}
				}
			}
		}
		isset($banner_level) ? $banner_level = $banner_level : $banner_level = 1;
	}else{
		if(isset($podiumArray[1])){
			$banner_region = $champinfos[$podiumArray[1]["name"]]["region"];
			if($podiumArray[1]["level"] == 7){
				$banner_level = 3;
			}else if($podiumArray[1]["level"] == 6 || $podiumArray[1]["level"] == 5){
				$banner_level = 2;
			}else{
				$banner_level = 1;
			}
		}else{
			$banner_region = "";
			$banner_level = 1;
		}
		
	}
	
	if($ptsmastery > 1500000){
		$banner_frame = 5;
	}else if($ptsmastery > 750000){
		$banner_frame = 4;
	}else if($ptsmastery > 375000){
		$banner_frame = 3;
	}else if($ptsmastery > 100000){
		$banner_frame = 2;
	}else{
		$banner_frame = 1;
	}
	
	switch($banner_region){
		case "Demacia":
			$data .= '<image href="'.imgToBase64('./images/banners/flag_demacia_'.$banner_level.'_inventory.png').'" x="437.5" y="80" width="100"/>';
			break;
		case "Freljord":
			$data .= '<image href="'.imgToBase64('./images/banners/flag_freljord_'.$banner_level.'_inventory.png').'" x="437.5" y="80" width="100"/>';
			break;
		case "Piltover":
			$data .= '<image href="'.imgToBase64('./images/banners/flag_piltover_'.$banner_level.'_inventory.png').'" x="437.5" y="80" width="100"/>';
			break;
		case "ShadowIsles":
			$data .= '<image href="'.imgToBase64('./images/banners/flag_shadowisles_'.$banner_level.'_inventory.png').'" x="437.5" y="80" width="100"/>';
			break;
		case "Zaun":
			$data .= '<image href="'.imgToBase64('./images/banners/flag_zaun_'.$banner_level.'_inventory.png').'" x="437.5" y="80" width="100"/>';
			break;
		default:
			$data .= '<image href="'.imgToBase64('./images/banners/bannerflag_pilot_'.$banner_level.'_inventory.png').'" x="437.5" y="80" width="100"/>';
			break;
	}
	$data .= '<image href="'.imgToBase64('./images/banners/frames/bannerframe_0'.$banner_frame.'_inventory.png').'" x="427.5" y="57.5" width="120"/>';

	$data .= '</svg>';
	fwrite($handle, $data);
	fclose($handle);
?>