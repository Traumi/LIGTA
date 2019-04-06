<div style="font-size:30px;text-align:center;margin:20px;">Liste des champions</div>
<?php 
	foreach($champions->data as $key => $value){ 
		$act_champ = json_decode(file_get_contents('./ddragon/'.$version.'/data/'.$lang.'/champion/'.$key.'.json'));
?>
	<div style="margin-bottom:20px;padding:0;text-align:center;" class="col-md-1 col-xs-2 champs" >
		<style>
			.champs a{
				color:#222;
				font-size:18px;
			}

			.champs a:hover{
				text-decoration: none;
				color:#222;
			}

			body.dark .champs a{
				color:#ccc;
			}

			body.dark .champs a:hover{
				color:#ccc;
			}
		</style>
		<a href="champ.php?c=<?php echo $key ?>">
			<img style="width:75%;text-align:center;max-width:125px;" src="./ddragon/<?php echo $version; ?>/img/champion/<?php echo $value->image->full; ?>"/>
			<div style="height:30px;"><?php echo $value->name ?></div>
		</a>
	</div>
<?php } ?>