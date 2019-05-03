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
