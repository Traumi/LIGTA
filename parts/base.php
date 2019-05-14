<?php 
	$rank_trad = ["UNRANKED" => $translations["UNRANKED"], "IRON" => $translations["IRON"], "BRONZE" => $translations["BRONZE"], "SILVER" => $translations["SILVER"], "GOLD" => $translations["GOLD"], "PLATINUM" => $translations["PLATINUM"], "DIAMOND" => $translations["DIAMOND"], "MASTER" => $translations["MASTER"], "GRANDMASTER" => $translations["GRANDMASTER"], "CHALLENGER" => $translations["CHALLENGER"]]; 
	$roman_trade = ["V" => "_5", "IV" => "_4", "III" => "_3", "II" => "_2", "I" => "_1", "" => ""];
?>
<div style="text-align:center;width:33%;display:inline-block;">
	<?php
	$rank = "UNRANKED";
	$division = "";
	$lp = 0;
	foreach($ranks as $cle => $value){
		if($value->queueType == "RANKED_FLEX_SR"){
			$rank = $value->tier;
			$division = $value->rank;
			$lp = $value->leaguePoints;
		}
	}
	echo '<img style="width:80%" src="images/rank/ranks_glow/'.$rank.$roman_trade[$division].'.png" />';
	echo '<div>'.$rank_trad[$rank].' '.$division.'</div>';
	echo '<div>'.$lp.' LP</div>';
	?>
	<div style="font-size:20px;">Flex 5v5</div>
</div>

<div style="text-align:center;width:33%;display:inline-block;">
	<?php 
	$rank = "UNRANKED";
	$division = "";
	$lp = 0;
	foreach($ranks as $cle => $value){
		if($value->queueType == "RANKED_SOLO_5x5"){
			$rank = $value->tier;
			$division = $value->rank;
			$lp = $value->leaguePoints;
		}
	} 
	//var_dump($value);
	echo '<img style="width:80%" src="images/rank/ranks_glow/'.$rank.$roman_trade[$division].'.png" />';
	echo '<div>'.$rank_trad[$rank].' '.$division.'</div>';
	echo '<div>'.$lp.' LP</div>';
	?>
	<div style="font-size:20px;">Solo/Duo</div>
</div>

<div style="text-align:center;width:33%;display:inline-block;">
	<?php 
	$rank = "UNRANKED";
	$division = "";
	$lp = 0;
	foreach($ranks as $cle => $value){
		if($value->queueType == "RANKED_FLEX_TT"){
			$rank = $value->tier;
			$division = $value->rank;
			$lp = $value->leaguePoints;
		}
	}
	echo '<img style="width:80%" src="images/rank/ranks_glow/'.$rank.$roman_trade[$division].'.png" />';
	echo '<div>'.$rank_trad[$rank].' '.$division.'</div>';
	echo '<div>'.$lp.' LP</div>';
	?>
	<div style="font-size:20px;">Flex 3v3</div>
</div>
<hr style="width:100%;border:solid lightgrey 1px;"/>
<div style="text-align:center;width:33%;margin-left:33%;">
	<img style="width:80%;left:0;" src="images/prestige/Level_<?php echo $index_lvl ?>_Prestige_Emote.png" />
	<div style="font-size:20px;margin-bottom:25px;"><?php echo $translations["PRESTIGE"] ?></div>
</div>