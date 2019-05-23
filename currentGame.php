<?php

    require_once("parts/init.php");
    require_once("parts/utils.php");

    isset($_GET["reg"])? $reg = $_GET["reg"] : $reg = "euw1";

    $result = file_get_contents('./ddragon/'.$version.'/data/'.$lang.'/champion.json');
    $champions = json_decode($result,true);

    $result = file_get_contents('./ddragon/'.$version.'/data/'.$lang.'/runesReforged.json');
    $perks = json_decode($result,true);

    $result = file_get_contents('./ddragon/'.$version.'/data/'.$lang.'/summoner.json');
    $spells = json_decode($result,true);

    $result = file_get_contents('./data/gametype.json');
    $gametype = json_decode($result,true);

    $pseudo = str_replace(" ","",$_GET["pseudo"]);

    if(!@file_get_contents('https://'.$reg.'.api.riotgames.com/lol/summoner/v4/summoners/by-name/'.$pseudo.'?api_key='.$key)){
		$pseudo = utf8_encode($pseudo);
		if(!@file_get_contents('https://'.$reg.'.api.riotgames.com/lol/summoner/v4/summoners/by-name/'.$pseudo.'?api_key='.$key)){
			die('error');
		}
	}

    $result = file_get_contents('https://'.$reg.'.api.riotgames.com/lol/summoner/v4/summoners/by-name/'.$pseudo.'?api_key='.$key);
    $profil = json_decode($result,true);
    //var_dump($profil);

    $result = @file_get_contents('https://'.$reg.'.api.riotgames.com/lol/spectator/v4/active-games/by-summoner/'.$profil["id"].'?api_key='.$key);
    $match = json_decode($result,true);
    //var_dump($match);
    if($match == null){
        die("nomatch");
    }

    $team1 = array();
    $team2 = array();
    foreach($match['participants'] as $num => $infos){
        if($infos['teamId'] == 100){
            $team1[] = $infos;
        }else{
            $team2[] = $infos;
        }
    }
    //var_dump($team1);

    $blueteam = [];
    foreach($team1 as $num => $infos){
        $blueteam[] = displayPlayer($infos, $key, $champions, $spells, $perks, $version, $reg);
    }

    $redteam = [];
    foreach($team2 as $num => $infos){
        $redteam[] = displayPlayer($infos, $key, $champions, $spells, $perks, $version, $reg);
    }
    

    echo '{"blue":[';
    for($i = 0 ; $i < sizeof($blueteam)-1 ; ++$i){
        echo '{';
        echo '"champion":"'.$blueteam[$i]["champion"].'",';
        echo '"champ_name":"'.$blueteam[$i]["champion_name"].'",';
        echo '"champ_mastery":"'.$blueteam[$i]["champ_mastery"].'",';
        echo '"champ_points":"'.$blueteam[$i]["champ_points"].'",';
        echo '"level":'.$blueteam[$i]["level"].',';
        echo '"pseudo":"'.$blueteam[$i]["pseudo"].'",';
        echo '"division":"'.$blueteam[$i]["division"].'",';
        echo '"palier":"'.$blueteam[$i]["palier"].'"';
        echo '},';
    }
    echo '{';
    echo '"champion":"'.$blueteam[sizeof($blueteam)-1]["champion"].'",';
    echo '"champ_name":"'.$blueteam[sizeof($blueteam)-1]["champion_name"].'",';
    echo '"champ_mastery":"'.$blueteam[sizeof($blueteam)-1]["champ_mastery"].'",';
    echo '"champ_points":"'.$blueteam[sizeof($blueteam)-1]["champ_points"].'",';
    echo '"level":'.$blueteam[sizeof($blueteam)-1]["level"].',';
    echo '"pseudo":"'.$blueteam[sizeof($blueteam)-1]["pseudo"].'",';
    echo '"division":"'.$blueteam[sizeof($blueteam)-1]["division"].'",';
    echo '"palier":"'.$blueteam[sizeof($blueteam)-1]["palier"].'"';
    echo '}';
    echo '],"red":[';
    for($i = 0 ; $i < sizeof($blueteam)-1 ; ++$i){
        echo '{';
        echo '"champion":"'.$redteam[$i]["champion"].'",';
        echo '"champ_name":"'.$redteam[$i]["champion_name"].'",';
        echo '"champ_mastery":"'.$redteam[$i]["champ_mastery"].'",';
        echo '"champ_points":"'.$redteam[$i]["champ_points"].'",';
        echo '"level":'.$redteam[$i]["level"].',';
        echo '"pseudo":"'.$redteam[$i]["pseudo"].'",';
        echo '"division":"'.$redteam[$i]["division"].'",';
        echo '"palier":"'.$redteam[$i]["palier"].'"';
        echo '},';
    }
    echo '{';
    echo '"champion":"'.$redteam[sizeof($blueteam)-1]["champion"].'",';
    echo '"champ_name":"'.$redteam[sizeof($blueteam)-1]["champion_name"].'",';
    echo '"champ_mastery":"'.$redteam[sizeof($blueteam)-1]["champ_mastery"].'",';
    echo '"champ_points":"'.$redteam[sizeof($blueteam)-1]["champ_points"].'",';
    echo '"level":'.$redteam[sizeof($blueteam)-1]["level"].',';
    echo '"pseudo":"'.$redteam[sizeof($blueteam)-1]["pseudo"].'",';
    echo '"division":"'.$redteam[sizeof($blueteam)-1]["division"].'",';
    echo '"palier":"'.$redteam[sizeof($blueteam)-1]["palier"].'"';
    echo '}],';
    foreach($gametype["type"] as $index => $name){
        if($match["gameQueueConfigId"] == $index){
            echo '"gametype":"'.$name.'",';
        }
    }
    echo '"map":"'.getQueueType($match["gameQueueConfigId"]).'"';
    echo "}";

	function updatePlayer($pseudo, $key, $reg){
        $pseudo = str_replace ( " " , "" , $pseudo);
        if (!file_exists('data/'.$reg.'/players/'.$pseudo)) {
            mkdir('data/'.$reg.'/players/'.$pseudo, 0777, true);
            $file = fopen("data/$reg/players/$pseudo/date.txt", "w");
            fwrite($file, "1990-01-01");
            fclose($file);
        }

        $lastMaj = file_get_contents('data/'.$reg.'/players/'.$pseudo.'/date.txt');
        $now = date("Y-m-d H:i");
        $datetime1 = new DateTime($lastMaj);
        $datetime2 = new DateTime($now);
        $interval = $datetime1->diff($datetime2);

        $sincelastupdate = ($interval->format("%a"))*24*60 + ($interval->h)*60 + ($interval->i);
		if ($sincelastupdate >= 120) {
	      	//Summoner
	        $result = file_get_contents('https://'.$reg.'.api.riotgames.com/lol/summoner/v4/summoners/by-name/'.$pseudo.'?api_key='.$key);
	        $file = fopen("data/$reg/players/$pseudo/summoner.json", "w");
	        fwrite($file, $result);
	        fclose($file);
	        $result = file_get_contents('data/'.$reg.'/players/'.$pseudo.'/summoner.json');
	        $profil = json_decode($result, true);
			
			$id = $profil["id"];
			$accountId = $profil["accountId"];

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
            
            sleep(0.5);
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
        updatePlayer($infos["summonerName"], $key, $reg);

        $result = file_get_contents('data/'.$reg.'/players/'.str_replace ( " " , "" , $infos["summonerName"]).'/summoner.json');
        $profil = json_decode($result, true);

        $result = file_get_contents('data/'.$reg.'/players/'.str_replace ( " " , "" , $infos["summonerName"]).'/masteries.json');
        $masteries = json_decode($result, true);

        $joueur = [];
        foreach($champions["data"] as $champname => $champ ){
			if($champ["key"] == $infos["championId"]){
                $joueur["champion"] = $champname;
                $joueur["champion_name"] = $champ["name"];
                $joueur["level"] = $profil["summonerLevel"];
                $joueur["pseudo"] = $infos["summonerName"];
			}
        }
        $bestrank = playerRank($infos["summonerName"], $key, $reg);
        $joueur["division"] = $bestrank[0]["tier"];
        $joueur["palier"] = $bestrank[0]["rank"];

        foreach($masteries as $index => $mastery){
            if($infos["championId"] == $mastery["championId"]){
                $joueur["champ_mastery"] = $mastery["championLevel"];
                $joueur["champ_points"] = $mastery["championPoints"];
            }
        }

        return $joueur;
	}
?>