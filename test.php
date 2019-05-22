<?php
	
	set_error_handler(function($errno, $errstr, $errfile, $errline, array $errcontext) {
	    if (0 === error_reporting()) {
	        return false;
	    }

	    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
	});

	require_once("parts/init.php");

	isset($_GET["reg"])? $reg = $_GET["reg"] : $reg = "euw1";

	$result = file_get_contents('./ddragon/'.$version.'/data/'.$lang.'/champion.json');
	$champions = json_decode($result);

	$result = file_get_contents('./ddragon/'.$version.'/data/'.$lang.'/runesReforged.json');
	$perks = json_decode($result);

	$result = file_get_contents('./ddragon/'.$version.'/data/'.$lang.'/summoner.json');
	$spells = json_decode($result);

	$result = file_get_contents('./data/gametype.json');
	$gametype = json_decode($result);

	function updatePlayer($pseudo, $key, $reg){
		$pseudo = str_replace ( " " , "" , $pseudo);
		if (!file_exists('data/'.$reg.'/players/'.$pseudo)) {
          	mkdir('data/'.$reg.'/players/'.$pseudo, 0777, true);
          	$file = fopen("data/$reg/players/$pseudo/date.txt", "w");
	      	fwrite($file, "1990-01-01 00:00");
	      	fclose($file);

	      	//Summoner
	        $result = file_get_contents('https://'.$reg.'.api.riotgames.com/lol/summoner/v4/summoners/by-name/'.$pseudo.'?api_key='.$key);
	        $file = fopen("data/$reg/players/$pseudo/summoner.json", "w");
	        fwrite($file, $result);
	        fclose($file);
	        $result = file_get_contents('data/'.$reg.'/players/'.$pseudo.'/summoner.json');
	        $profil = json_decode($result);
			
			$id = $profil->id;
			$accountId = $profil->accountId;

			//Rank
			$result = file_get_contents('https://'.$reg.'.api.riotgames.com/lol/league/v4/positions/by-summoner/'.$id.'?api_key='.$key);
	        $file = fopen("data/$reg/players/$pseudo/ranks.json", "w");
	        fwrite($file, $result);
	        fclose($file);

			//Masteries
	        $result = file_get_contents('https://'.$reg.'.api.riotgames.com/lol/champion-mastery/v4/champion-masteries/by-summoner/'.$id.'?api_key='.$key);
	        $file = fopen("data/$reg/players/$pseudo/masteries.json", "w");
	        fwrite($file, $result);
	        fclose($file);

	        $result = file_get_contents('https://'.$reg.'.api.riotgames.com/lol/match/v4/matchlists/by-account/'.$accountId.'?api_key='.$key);
	        $file = fopen("data/$reg/players/$pseudo/matches.json", "w");
	        fwrite($file, $result);
	        fclose($file);

	        $file = fopen("data/$reg/players/$pseudo/date.txt", "w");
	        fwrite($file, date("Y-m-d H:i"));
	        fclose($file);
        }
	}

	function playerRank($pseudo, $key, $reg){

		$rank_values = array("IRON" => 0 , "BRONZE" => 4 , "SILVER" => 8 , "GOLD" => 12 , "PLATINUM" => 16 , "DIAMOND" => 20 , "MASTER" => 24 , "GRANDMASTER" => 28 , "CHALLENGER" => 32);
		$division_values = array("IV" => 1 , "III" => 2 , "II" => 3 , "I" => 4);

		$pseudo = str_replace ( " " , "" , $pseudo);
		if (file_exists('data/'.$reg.'/players/'.$pseudo)) {
          	$result = file_get_contents('data/'.$reg.'/players/'.$pseudo.'/ranks.json');
	        $ranks = json_decode($result);
        }

        $rank = "UNRANKED";
        $division = "";
        $queue = "Solo/Duo";

        $act_max = 0;

        $allranks = array();
        $allranks[0] = array("tier" => "UNRANKED", "rank" => "", "queue" => "/", "value" => 0, "lp" => 0, "wins" => 0, "losses" => 0);//leaguePoints
        $allranks[1] = array("tier" => "UNRANKED", "rank" => "", "queue" => "/", "value" => 0, "lp" => 0, "wins" => 0, "losses" => 0);
        $allranks[2] = array("tier" => "UNRANKED", "rank" => "", "queue" => "/", "value" => 0, "lp" => 0, "wins" => 0, "losses" => 0);

        if(count($ranks) >= 1){
        	foreach($ranks as $index => $infos){
        		$act_max = $rank_values[$infos->tier] + $division_values[$infos->rank] + ($infos->leaguePoints/150);
        		$rank = $infos->tier;
        		$division = $infos->rank;
        		$lp = $infos->leaguePoints;

        		switch($infos->queueType){
    				case "RANKED_SOLO_5x5" :
    					$queue = "Solo/Duo";
    					break;
    				case "RANKED_FLEX_SR" :
    					$queue = "Flex 5v5";
    					break;
    				case "RANKED_FLEX_TT" :
    					$queue = "Flex 3v3";
    					break;
    			}

				if($allranks[0]["value"] < $act_max){
					$allranks[1] = array("tier" => $allranks[0]["tier"], "rank" => $allranks[0]["rank"], "queue" => $allranks[0]["queue"], "value" => $allranks[0]["value"], "lp" => $allranks[0]["lp"], "wins" => $allranks[0]["wins"], "losses" => $allranks[0]["losses"]);
					$allranks[0] = array("tier" => $rank, "rank" => $division, "queue" => $queue, "value" => $act_max, "lp" => $lp, "wins" => $infos->wins, "losses" => $infos->losses);
				}else if($allranks[1]["value"] < $act_max){
					$allranks[2] = array("tier" => $allranks[1]["tier"], "rank" => $allranks[1]["rank"], "queue" => $allranks[1]["queue"], "value" => $allranks[1]["value"], "lp" => $allranks[1]["lp"], "wins" => $allranks[1]["wins"], "losses" => $allranks[1]["losses"]);
					$allranks[1] = array("tier" => $rank, "rank" => $division, "queue" => $queue, "value" => $act_max, "lp" => $lp, "wins" => $infos->wins, "losses" => $infos->losses);
				}else{
					$allranks[2] = array("tier" => $rank, "rank" => $division, "queue" => $queue, "value" => $act_max, "lp" => $lp, "wins" => $infos->wins, "losses" => $infos->losses);
				}
				
        	}
        }

        if($allranks[0]["queue"] == "/"){
        	$allranks[0]["queue"] = "Solo/Duo";
        }

        if($allranks[1]["queue"] == "/"){
        	if($allranks[0]["queue"] == "Solo/Duo"){
	        	$allranks[1]["queue"] = "Flex 5v5";
	        }
	        else{
	        	$allranks[1]["queue"] = "Solo/Duo";
	        }
        }
        if($allranks[2]["queue"] == "/"){
        	if(($allranks[0]["queue"] == "Solo/Duo" && $allranks[1]["queue"] == "Flex 5v5") || ($allranks[1]["queue"] == "Solo/Duo" && $allranks[0]["queue"] == "Flex 5v5")){
	        	$allranks[2]["queue"] = "Flex 3v3";
	        }
	        else if(($allranks[0]["queue"] == "Flex 3v3" && $allranks[1]["queue"] == "Flex 5v5") || ($allranks[1]["queue"] == "Flex 3v3" && $allranks[0]["queue"] == "Flex 5v5")){
	        	$allranks[2]["queue"] = "Solo/Duo";
	        }
	        else{
	        	$allranks[2]["queue"] = "Flex 5v5";
	        }
        }
        return $allranks;
	}

	function displayPlayer($infos, $key, $champions, $spells, $perks, $version, $reg){
		updatePlayer($infos->summonerName, $key, $reg);
		$result = file_get_contents('data/'.$reg.'/players/'.str_replace ( " " , "" , $infos->summonerName).'/summoner.json');
	    $profil = json_decode($result);
		echo '<div class="col-md-2 col-xs-2" style="text-align:left;padding:5px;"><div class="game-profil">';
		foreach($champions->data as $champname => $champ ){
			if($champ->key == $infos->championId){
				echo '<div>';
					echo '<div style="display:inline-block;">';
						echo '<img style="width:64px;" src="ddragon/'.$version.'/img/champion/'.$champname.'.png" /><span class="level-match">'.$profil->summonerLevel.'</span>';
						echo '<div>';
						foreach($spells->data as $num => $spell ){
							if($infos->spell1Id == $spell->key){
								echo '<img style="width:32px;" src="http://ddragon.leagueoflegends.com/cdn/'.$version.'/img/spell/'.$spell->id.'.png" />';
							}
							if($infos->spell2Id == $spell->key){
								echo '<img style="width:32px;" src="http://ddragon.leagueoflegends.com/cdn/'.$version.'/img/spell/'.$spell->id.'.png" />';
							}
						}
						echo '</div>';
					echo '</div>';
					echo '<div style="position:relative;display:inline-block;width:calc(100% - 64px);bottom:30px;text-align:center;font-size:20px;"><span class="pseudo-match"><a href="profil.php?pseudo='.$infos->summonerName.'">'.$infos->summonerName.'</a></span></div>';
				echo '</div>';
			}
		}
		

		$bestrank = playerRank($infos->summonerName, $key, $reg);
		echo '<hr/>';
		echo '<div style="text-align:center;">';
			echo '<div style="width:29%;display:inline-block;text-align:center;">';
				echo '<img style="width:90%;" src="images/rank/s9/'.$bestrank[1]["tier"].'_'.$bestrank[1]["rank"].'.png" />';
				echo '<div style="font-weight:bold;">'.$bestrank[1]["tier"].' '.$bestrank[1]["rank"].'</div>';
				echo '<div style="font-weight:bold;">'.$bestrank[1]["lp"].' LP</div>';
				echo '<div style="font-size:12px;">('.$bestrank[1]["wins"].' W - '.$bestrank[1]["losses"].' L)</div>';
				echo '<div style="font-weight:bold;font-size:18px;">'.$bestrank[1]["queue"].'</div>';
			echo '</div>';
			echo '<div style="width:40%;display:inline-block;text-align:center;">';
				
				//if($infos->summonerName == "Traumination"){
				if(false){
					echo '<img style="width:90%;" src="images/rank/s9/challenger_i.png" />';
					echo '<div style="font-weight:bold;">CHALLENGER I</div>';
					echo '<div style="font-weight:bold;">725 LP</div>';
				}else{
					echo '<img style="width:90%;" src="images/rank/s9/'.$bestrank[0]["tier"].'_'.$bestrank[0]["rank"].'.png" />';
					echo '<div style="font-weight:bold;">'.$bestrank[0]["tier"].' '.$bestrank[0]["rank"].'</div>';
					echo '<div style="font-weight:bold;">'.$bestrank[0]["lp"].' LP</div>';
					echo '<div style="font-size:12px;">('.$bestrank[0]["wins"].' W - '.$bestrank[0]["losses"].' L)</div>';
				}
				
				echo '<div style="font-weight:bold;font-size:18px;">'.$bestrank[0]["queue"].'</div>';
			echo '</div>';
			echo '<div style="width:29%;display:inline-block;text-align:center;">';
				echo '<img style="width:90%;" src="images/rank/s9/'.$bestrank[2]["tier"].'_'.$bestrank[2]["rank"].'.png" />';
				echo '<div style="font-weight:bold;">'.$bestrank[2]["tier"].' '.$bestrank[2]["rank"].'</div>';
				echo '<div style="font-weight:bold;">'.$bestrank[2]["lp"].' LP</div>';
				echo '<div style="font-size:12px;">('.$bestrank[2]["wins"].' W - '.$bestrank[2]["losses"].' L)</div>';
				echo '<div style="font-weight:bold;font-size:18px;">'.$bestrank[2]["queue"].'</div>';
			echo '</div>';
		echo '</div>';
		echo '<hr/>';
		$player_perks = array();
		foreach($infos->perks->perkIds as $pperkid => $pperkinfo){
			//var_dump($pperkinfo);
			foreach($perks as $perkid => $perkinfo){
				foreach ($perkinfo->slots as $slotid => $slotinfo) {
					foreach ($slotinfo->runes as $runeid => $runeinfo) {
						if($runeinfo->id == $pperkinfo){
							$player_perks[] = $runeinfo->icon;
							break 3;
						}
					}
				}
			}
		}

		echo '<div>';
			echo '<div style="position:relative">';
				echo '<div><img style="height:32px;position:absolute;left:calc(12.5% - 16px);top:0;" src="./ddragon/img/'.$player_perks[0].'"/></div>';
				echo '<div><img style="height:32px;position:absolute;left:calc(25% - 16px);top:0;;" src="./ddragon/img/'.$player_perks[1].'"/></div>';
				echo '<div><img style="height:32px;position:absolute;left:calc(37.5% - 16px);top:0;" src="./ddragon/img/'.$player_perks[2].'"/></div>';
				echo '<div><img style="height:32px;position:absolute;left:calc(50% - 16px);top:0;" src="./ddragon/img/'.$player_perks[3].'"/></div>';
				echo '<div><img style="height:32px;position:absolute;left:calc(12.5% - 16px);top:40px;" src="./ddragon/img/'.$player_perks[4].'"/></div>';
				echo '<div><img style="height:32px;position:absolute;left:calc(25% - 16px);top:40px;" src="./ddragon/img/'.$player_perks[5].'"/></div>';
				echo '<div style="height:70px;"></div>';
			echo '</div>';
			//
		echo '</div>';

		echo '<hr/>';
		
		echo '</div></div>';
	}

	echo '<button class="btn btn-success" onclick="currentGame()"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button><br/>';
	try{

		$result = file_get_contents('https://'.$reg.'.api.riotgames.com/lol/spectator/v4/active-games/by-summoner/'.$_GET["id"].'?api_key='.$key);
		$match = json_decode($result);

		$team1 = array();
		$team2 = array();

		foreach($match->participants as $num => $infos){
			if($infos->teamId == 100){
				$team1[] = $infos;
			}else{
				$team2[] = $infos;
			}
		}

		echo '<div>';
			echo '<div class="col-md-12 col-xs-12">';
				foreach($gametype->type as $index => $name){
					if($match->gameQueueConfigId == $index){
						echo '<h1>'.$name.'</h1>';
					}
				}
				
			echo '</div>';
			echo '<div class="col-md-12 col-xs-12">';
			echo '<div class="col-md-1 col-xs-1">';
			echo '<div><h3>Bans</h3></div>';
			for($i = 0 ; $i < 5 ; $i++){
				if(count($match->bannedChampions) <= $i){ echo '<img style="width:64px;margin-right:5px;border-radius:100%;" src="ddragon/img/bg/F5141416.png" /><br/>'; }
				else{
					$tmpid = $match->bannedChampions[$i]->championId;
					if($tmpid != -1){
						foreach($champions->data as $champname => $champ ){
							if($champ->key == $tmpid){
								echo '<img style="width:64px;margin-right:5px;border-radius:100%;" src="ddragon/'.$version.'/img/champion/'.$champname.'.png" /><br/>';
							}
						}
					}else{
						echo '<img style="width:64px;margin-right:5px;border-radius:100%;" src="ddragon/img/bg/F5141416.png" /><br/>';
					}
				}
			}
			echo '</div>';
			foreach($team1 as $num => $infos){
				displayPlayer($infos, $key, $champions, $spells, $perks, $version, $reg);
			}
			echo '<div class="col-md-1 col-xs-1"></div>';
			echo '</div>';

			echo '<div class="col-md-12 col-xs-12">';
				echo '<div class="col-md-5 col-xs-12">';
				echo '</div>';
				echo '<div class="col-md-2 col-xs-12">';
					echo '<h1>VS</h1>';
				echo '</div>';
				echo '<div class="col-md-5 col-xs-12">';
				echo '</div>';
			echo '</div>';

			echo '<div class="col-md-12 col-xs-12">';
			echo '<div class="col-md-1 col-xs-1">';
			echo '<div><h3>Bans</h3></div>';
			for($i = 5 ; $i < 10 ; $i++){
				if(count($match->bannedChampions) <= $i){ echo '<img style="width:64px;margin-right:5px;border-radius:100%;" src="ddragon/img/bg/F5141416.png" /><br/>'; }
				else{
					$tmpid = $match->bannedChampions[$i]->championId;
					if($tmpid != -1){
						foreach($champions->data as $champname => $champ ){
							if($champ->key == $tmpid){
								echo '<img style="width:64px;margin-right:5px;border-radius:100%;" src="ddragon/'.$version.'/img/champion/'.$champname.'.png" /><br/>';
							}
						}
					}else{
						echo '<img style="width:64px;margin-right:5px;border-radius:100%;" src="ddragon/img/bg/F5141416.png" /><br/>';
					}
				}
				
			}
			echo '</div>';
			foreach($team2 as $num => $infos){
				displayPlayer($infos, $key, $champions, $spells, $perks, $version, $reg);
			}
			echo '<div class="col-md-1 col-xs-1"></div>';
			echo '</div>';
			
		echo '</div>';
	}catch(Exception $e){
		echo $e;
		echo "<h3>Pas de partie en cours</h3>";
	}
	
	sleep(0.25);

	restore_error_handler();
?>