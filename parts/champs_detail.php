<?php 
	$value = $champion->data->$idchampignon;
	$key = $idchampignon;
?>
<div style="border:solid black 2px;margin-bottom:10px;padding:0;" class="col-md-12 col-xs-12" >
	<div class="col-md-1 col-xs-2" style="padding:0;text-align:center;">
		<h3 style="margin:0;margin-top:5px;"><?php echo $value->name; ?></h3>
		<h6 style="margin:0;margin-top:2px;margin-bottom:5px;">"<?php echo $value->title; ?>"</h6>
		<img style="width:75%;text-align:center;" src="http://ddragon.leagueoflegends.com/cdn/<?php echo $version; ?>/img/champion/<?php echo $value->image->full; ?>"/>
	</div>
	
	<style>
		.xpbar{
			display:inline-block;
			height:16px;
			width:200px;
			background:#7F7F7F;
			border-radius:100px;
			overflow:hidden;
			position:relative;
		}
		.valueDisplay{
			height:100%;
			position:absolute;
			top:0;
			width:100%;
			font-size:12px;
			color:#F2F2F2;
			text-align:center;
			font-weight:bold;
		}
	</style>
	
	<div class="col-md-11 col-xs-10">
		<div style="margin-top:20px;">
			<?php echo $champion->data->$key->lore; ?>
		</div>
		<div style="margin-top:20px;">
			<div style="display:inline-block;width:100px;font-size:18px">
				<?php echo $translations["ATK"]; ?> : 
			</div>
			<div class="xpbar">
				<div style="height:16px;width:<?php echo ($value->info->attack/10)*100; ?>%;background:#A00;"></div>
				<div class="valueDisplay"><?php echo $value->info->attack; ?>/10</div>
			</div>
		</div>
		<div>
			<div style="display:inline-block;width:100px;font-size:18px">
				<?php echo $translations["DEF"]; ?> : 
			</div>
			<div class="xpbar">
				<div style="height:16px;width:<?php echo ($value->info->defense/10)*100; ?>%;background:#0A0;"></div>
				<div class="valueDisplay"><?php echo $value->info->defense; ?>/10</div>
			</div>
		</div>
		<div>
			<div style="display:inline-block;width:100px;font-size:18px">
				<?php echo $translations["MAG"]; ?> : 
			</div>
			<div class="xpbar">
				<div style="height:16px;width:<?php echo ($value->info->magic/10)*100; ?>%;background:#44C;"></div>
				<div class="valueDisplay"><?php echo $value->info->magic; ?>/10</div>
			</div>
		</div>
		<div>
			<div style="display:inline-block;width:100px;font-size:18px">
				<?php echo $translations["DIF"]; ?> : 
			</div>
			<div class="xpbar">
				<div style="height:16px;width:<?php echo ($value->info->difficulty/10)*100; ?>%;background:#A07;"></div>
				<div class="valueDisplay"><?php echo $value->info->difficulty; ?>/10</div>
			</div>
		</div>
	</div>

	

	<div class="col-md-12 col-xs-12" style="margin-top:25px;margin-bottom:25px;">
		<div>
			<?php
				echo '<h4>'.$translations["TIPS_AS"].' '.$champion->data->$key->name.'</h4>'; 
				echo '<ul>';
				foreach($champion->data->$key->allytips as $aaa => $content){
					echo '<li>'.$content.'</li>';
				};
				echo '</ul>';
			?>
		</div>
		<div>
			<?php 
				echo '<h4>'.$translations["TIPS_AGAINST"].' '.$champion->data->$key->name.'</h4>'; 
				echo '<ul>';
				foreach($champion->data->$key->enemytips as $aaa => $content){
					echo '<li>'.$content.'</li>';
				};
				echo '</ul>';
			?>
		</div>
		<style>
		.ap{
			color:#00FF00;
		}
		.ad{
			color:#FF0000;
		}
		font{
			font-size:14px;
			color:black;
		}
		</style>
		<div>
			<?php 
				echo '<div style="border:solid black 2px;width:100%;padding:0;margin:0;">';
				echo '<span style="padding:4px;border-bottom:solid black 2px;border-right:solid black 2px;">Passive</span>';
				echo '<div style="margin-left:10px;margin-top:5px;"><img src="./ddragon/'.$version.'/img/passive/'.$champion->data->$key->passive->image->full.'" style="margin-top:10px;width:64px;"/>';
				echo '<h4 style="position:relative;display:inline-block;margin-left:10px;top:6px;">'.$champion->data->$key->passive->name.'</h4></div>';
				echo '<h5 style="margin-left:10px;">'.$champion->data->$key->passive->description.'</h5>';
				echo '</div>';
				echo '<br/>';
				foreach($champion->data->$key->spells as $aaa => $content){
					switch($aaa){
						case 0 :
							$touche = "Q";
							break;
						case 1 :
							$touche = "W";
							break;
						case 2 :
							$touche = "E";
							break;
						default :
							$touche = "R";
							break;
					}

					echo '<div style="border:solid black 2px;">';
					echo '<span style="padding:4px;border-bottom:solid black 2px;border-right:solid black 2px;">'.$touche.' Spell</span>';
					echo '<div style="margin-left:10px;margin-top:5px;"><img src="./ddragon/'.$version.'/img/spell/'.$content->image->full.'" style="margin-top:10px;width:64px;"/>';
					echo '<h4 style="position:relative;display:inline-block;margin-left:10px;top:6px;">'.$content->name.'</h4></div>';
					echo '<h5 style="margin-left:10px;">'.$content->description.'</h5>';
					echo '</div>';
					echo '<br/>';
				};
			?>
		</div>
		<hr style="border:solid black 1px;"/>
		<div style="font-size:20px;margin-bottom:20px;">Skins :</div>
		<?php foreach($champion->data->$key->skins as $key2 => $value2){ ?>
			<div class="col-md-2 col-xs-4" style="margin-bottom:5px;">
				<style>
					.skin:hover{
						opacity:0.7;
						transition:1s all;
					}
				</style>
				<img class="skin" style="width:100%;padding:4px;border:solid lightgrey 1px;border-radius:4px;max-height:300px;cursor:pointer;transition:1s all;overflow:hidden;" alt="<?php echo $value2->name ?>" src="<?php echo "./ddragon/img/champion/splash/".$key."_".$value2->num.".jpg" ?>" onclick='display("<?php echo "./ddragon/img/champion/splash/".$key."_".$value2->num.".jpg" ?>")'/>
			</div>
			
		<?php } ?>
	</div>
</div>
<div class="text-center">
	<button class="btn btn-success" onclick="history.back()"><?php echo $translations["BACK"]; ?></button>
</div>