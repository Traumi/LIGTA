<?php
	require_once("parts/init.php");
?>
<html>
	<head>
		<title>Icon Builder</title>
		<meta property="og:title" content="Icon Builder By Traumination" />
		<meta property="og:description" content="Build your ranked icon easily" />
		<meta property="og:image" content="http://89.156.31.147/ligta/images/rank/ranks_glow/challenger.png" />
		<meta name="theme-color" content="#992A2A">
		<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
	    <!--<link href="V/css/style.css" rel="stylesheet">-->
	    <script src="bootstrap/js/jquery-3.2.1.min.js"></script>
		<script src="bootstrap/js/bootstrap.js"></script>
	    <script>
			$(function () {
				$('[data-toggle="tooltip"]').tooltip()
			})
		</script>
		<style>
			.switch2 {
			  position: relative;
			  display: inline-block;
			  width: 45px;
			  height: 25.5px;
			}

			/* Hide default HTML checkbox */
			.switch2 input {
			  opacity: 0;
			  width: 0;
			  height: 0;
			}

			/* The slider */
			.slider2 {
			  position: absolute;
			  cursor: pointer;
			  top: 0;
			  left: 0;
			  right: 0;
			  bottom: 0;
			  background-color: #ccc;
			  -webkit-transition: .4s;
			  transition: .4s;
			}

			.slider2:before {
			  position: absolute;
			  content: "";
			  height: 19.5px;
			  width: 19.5px;
			  left: 3px;
			  bottom: 3px;
			  background-color: white;
			  -webkit-transition: .4s;
			  transition: .4s;
			}

			input:checked + .slider2 {
			  background-color: #2196F3;
			}

			input:focus + .slider2 {
			  box-shadow: 0 0 1px #2196F3;
			}

			input:checked + .slider2:before {
			  -webkit-transform: translateX(19.5px);
			  -ms-transform: translateX(19.5px);
			  transform: translateX(19.5px);
			}

			/* Rounded sliders */
			.slider2.round2 {
			  border-radius: 25.5px;
			}

			.slider2.round2:before {
			  border-radius: 50%;
			}
		</style>
		<style>
			body.dark{
				background: #333;
				color:white;
			}

			*{
				vertical-align: middle;
			}

			#download-link{
				display:none;
				background:#ccc;
				padding:5px;
				border:solid black 1px;
				border-radius:5px;
				color: black;
				text-decoration: none;
				margin-top: 15px;
			}

			/*.select label{
				display: inline-block;
				width:80px;
				text-align: left;

			}*/

			select:active, select:hover,select:focus, button:focus {
			  outline: none
			}
			.select{
				display:inline-block;
			}
			.select select{
				display: inline-block;
				width:150px;
				font-size:16px;
				text-align:center;
				text-align-last:center;
				border-radius:50px;
				padding:4px;
				-webkit-appearance: none;
				-moz-appearance: none;
				appearance: none;
				overflow: hidden;
				text-align:center;
				color:black;
			    /*background: url(./images/dropdown.png) no-repeat right transparent;*/
			}

			canvas{
				border:solid lightgrey 1px;
				border-radius:10px;
				margin:15px;
			}

			.btn-val{
				background:#AAA;
				color:black;
				font-weight:600;
				font-size:16px;
				border:solid #888 2px;
				border-radius:5px;
				padding:5px;
				transition: 1s all;
			}

			.btn-val:hover{
				background:#828282;
				border:solid #5f5f5f 2px;
				transition: 1s all;
				/*transform:scale(1.1, 1.1);;*/
			}

			progress {
				/* ici les styles généraux */
			}
			progress::-webkit-progress-bar { 
				/* ici les styles généraux pour Webkit */
			}
			progress::-webkit-progress-value {  
				/* styles de barre d'avancement pour Webkit */
			}  
			progress::-moz-progress-bar { 
				/* styles de barre d'avancement pour Firefox */
			}
		</style>
	</head>
	<body>
		<?php require_once("parts/$lang/header.php"); ?>
		<?php require_once("parts/$lang/footer.php"); ?>
		<div style="width:500px;margin:auto;text-align:center;">
			<div style="display:inline-block;width:100%;">
				<h2>General</h2>
				<div class="select">
					<select id="rank" onchange="isDiv()">
						<option value="" disabled selected>Rang</option>
						<option value="challenger">Challenger</option>
						<option value="grandmaster">GrandMaster</option>
						<option value="master">Master</option>
						<option value="diamond">Diamond</option>
						<option value="platinum">Platinum</option>
						<option value="gold">Gold</option>
						<option value="silver">Silver</option>
						<option value="bronze">Bronze</option>
						<option value="iron">Iron</option>
					</select>
				</div>
				<div id="division-group" class="select">
					<select id="division">
						<option value="" disabled selected>Division</option>
						<option>1</option>
						<option>2</option>
						<option>3</option>
						<option>4</option>
					</select>
				</div>
				<div class="select">
					<select id="type">
						<option value="" disabled selected>Type</option>
						<option value="normal">Normal</option>
						<option value="open">Open</option>
						<option value="sword">Sword</option>
						<option value="glowing">Glowing</option>
						<option value="shining">Shining</option>
						<option value="burning">Burning</option>

					</select>
				</div>
			</div>
			<div style="display:inline-block;width:100%;">
					<h2>Splits</h2>
					<div style="display:inline-block;width:30%;">
						<label for="sr1" style="font-size:18px;margin-bottom:5px;display:block;">Split 1</label>
						<label class="switch2">
						  <input type="checkbox" id="sr1" name="sr1" checked>
						  <span class="slider2 round2"></span>
						</label>
						
					</div>
					<div style="display:inline-block;width:30%;">
						<label for="sr2" style="font-size:18px;margin-bottom:5px;display:block;">Split 2</label>
						<label class="switch2">
						  <input type="checkbox" id="sr2" name="sr2" checked>
						  <span class="slider2 round2"></span>
						</label>
					</div>
					<div style="display:inline-block;width:30%;">
						<label for="sr3" style="font-size:18px;margin-bottom:5px;display:block;">Split 3</label>
						<label class="switch2">
						  <input type="checkbox" id="sr3" name="sr3" checked>
						  <span class="slider2 round2"></span>
						</label>
					</div>
			</div>
			
			<div style="margin-top:30px;">
				<button class="btn-val" onclick="update(true)">Valider</button>
			</div>
			
			<div>
				<canvas id="tempo" style="display:none;" width="300" height="340">

				</canvas>
				<canvas id="icon" width="300" height="340">

				</canvas>
				<h4 id="text-status" style="display:none;"></h4>
				<h5 id="percent">0%</h5>
				<div><progress id="progress" max="100" value="100"> 100% </progress></div>
				
				<div>
					<a id="download-link" href="" download>Download</a>
				</div>
			</div>
		</div>
	</body>
</html>

<script>
	function draw(path){
		var canvas = document.getElementById('icon');
	    var context = canvas.getContext('2d');
	    var imageObj = new Image();

	    imageObj.onload = function() {
	    	context.drawImage(imageObj, 0, 0, canvas.width, canvas.height);
	    };
	    imageObj.src = path;//'./images/rank/project/parts/iron/iron_base.png';
	}
	function drawText(text){
		var canvas = document.getElementById('icon');
	    var ctx = canvas.getContext('2d');
	    ctx.font = "18px Georgia";
	    ctx.fillStyle = "white";
		ctx.textAlign = "center";
		ctx.fillText(text, 150, 260);
	}
	function drawAvatar(path){
		var canvas = document.getElementById('icon');
	    var context = canvas.getContext('2d');
	    var imageObj = new Image();

	    imageObj.onload = function() {
	    	context.drawImage(imageObj, 75, 95, 150, 150);
	    };
	    imageObj.src = path;
	}
	function drawVoice(path){
		var canvas = document.getElementById('icon');
	    var context = canvas.getContext('2d');
	    var imageObj = new Image();

	    imageObj.onload = function() {
	    	context.drawImage(imageObj, 0, 0, canvas.width, canvas.height);
	    };
	    imageObj.src = path;//'./images/rank/project/parts/iron/iron_base.png';
	}
	function clear(){
		var canvas = document.getElementById('icon');
	    var context = canvas.getContext('2d');
	    context.clearRect(0, 0, canvas.width, canvas.height);
	}
	function sleep(ms) {
	  return new Promise(resolve => setTimeout(resolve, ms));
	}
</script>
<script>
	var romans = ["0", "I", "II", "III", "IV"];
	function isDiv(){
		var rank = document.getElementById("rank").value;
		if(rank == "challenger" || rank == "master" || rank == "grandmaster"){
			document.getElementById("division").value = 1;
			document.getElementById("division-group").style.display = "none";
		}else{
			document.getElementById("division-group").style.display = "inline-block";
		}
	}
	function f_progress(val){
		progress.value = val;
		document.getElementById("percent").innerHTML = val+"%";
	}
	async function update(bool){
		var sleeptime = 25;
		if(!bool){
			document.getElementById("tempo").style.display = "none";
			document.getElementById("icon").style.display = "inline-block";
			document.getElementById("text-status").style.display = "block";
			document.getElementById("text-status").innerHTML = "building icon...";
		}else{
			document.getElementById("tempo").style.display = "inline-block";
			document.getElementById("icon").style.display = "none";
			document.getElementById("text-status").style.display = "block";
			document.getElementById("text-status").innerHTML = "downloading images...";
			sleeptime = 50;
		}

		clear();
		document.getElementById("download-link").style.display = "none";
		var rank = document.getElementById("rank").value;
		var div = document.getElementById("division").value;
		var type = document.getElementById("type").value;



		var sr1 = document.getElementById("sr1").checked;
		var sr2 = document.getElementById("sr2").checked;
		var sr3 = document.getElementById("sr3").checked;

		

		var progress = document.getElementById("progress");
		progress.value = 0;
		if(rank == "" || div == "" || type == ""){document.getElementById("text-status").style.display = "none";return;}
		switch(type){
			case "normal" :

				if(sr3){
					draw('./images/rank/project/parts/'+rank+'/'+rank+'_sr3.png');
					f_progress(17);
					await sleep(sleeptime);
				}

				if(sr2){
					draw('./images/rank/project/parts/'+rank+'/'+rank+'_sr2.png');
					f_progress(33);
					await sleep(sleeptime);
				}

				if(sr1){
					draw('./images/rank/project/parts/'+rank+'/'+rank+'_sr1.png');
					f_progress(50);
					await sleep(sleeptime);
				}

				draw('./images/rank/project/parts/'+rank+'/'+rank+'_base.png');
				f_progress(67);
				await sleep(sleeptime);

				draw('./images/rank/project/parts/'+rank+'/'+rank+'_face.png');
				f_progress(83);
				await sleep(sleeptime);

				draw('./images/rank/project/parts/'+rank+'/'+rank+'_crown_d'+div+'.png');
				f_progress(100);

				break;
			case "open" :

				if(sr3){
					draw('./images/rank/project/parts/'+rank+'/'+rank+'_sr3.png');
					f_progress(14);
					await sleep(sleeptime);
				}

				if(sr2){
					draw('./images/rank/project/parts/'+rank+'/'+rank+'_sr2.png');
					f_progress(29);
					await sleep(sleeptime);
				}

				if(sr1){
					draw('./images/rank/project/parts/'+rank+'/'+rank+'_sr1.png');
					f_progress(43);
					await sleep(sleeptime);
				}

				drawAvatar('./images/rank/project/parts/icon.png');
				f_progress(57);
				await sleep(sleeptime);

				draw('./images/rank/project/parts/'+rank+'/'+rank+'_base.png');
				f_progress(71);
				await sleep(sleeptime);

				draw('./images/rank/project/parts/'+rank+'/'+rank+'_plate.png');
				f_progress(86);
				await sleep(sleeptime);

				draw('./images/rank/project/parts/'+rank+'/'+rank+'_crown_d'+div+'.png');
				f_progress(100);
				await sleep(sleeptime);

				drawText(romans[div]);

				break;
			case "glowing" :

				if(sr3){
					draw('./images/rank/project/parts/'+rank+'/'+rank+'_sr3.png');
					f_progress(14);
					await sleep(sleeptime);
				}

				if(sr2){
					draw('./images/rank/project/parts/'+rank+'/'+rank+'_sr2.png');
					f_progress(29);
					await sleep(sleeptime);
				}

				if(sr1){
					draw('./images/rank/project/parts/'+rank+'/'+rank+'_sr1.png');
					f_progress(43);
					await sleep(sleeptime);
				}

				draw('./images/rank/project/parts/'+rank+'/'+rank+'_base.png');
				f_progress(57);
				await sleep(sleeptime);

				draw('./images/rank/project/parts/'+rank+'/'+rank+'_face.png');
				f_progress(71);
				await sleep(sleeptime);

				draw('./images/rank/project/parts/'+rank+'/'+rank+'_crown_d'+div+'.png');
				f_progress(86);
				document.getElementById("percent").innerHTML = "86%";
				await sleep(sleeptime);

				drawVoice('./images/rank/project/parts/'+rank+'/voice_'+rank+'.png');
				f_progress(100);

				break;
			case "shining":

				if(sr3){
					draw('./images/rank/project/parts/'+rank+'/'+rank+'_sr3_sheeng.png');
					f_progress(17);
					await sleep(sleeptime);
				}

				if(sr2){
					draw('./images/rank/project/parts/'+rank+'/'+rank+'_sr2_sheeng.png');
					f_progress(33);
					await sleep(sleeptime);
				}

				if(sr1){
					draw('./images/rank/project/parts/'+rank+'/'+rank+'_sr1_sheeng.png');
					f_progress(50);
					await sleep(sleeptime);
				}

				draw('./images/rank/project/parts/'+rank+'/'+rank+'_base_sheeng.png');
				f_progress(67);
				await sleep(sleeptime);

				draw('./images/rank/project/parts/'+rank+'/'+rank+'_face_sheeng.png');
				f_progress(83);
				await sleep(sleeptime);

				draw('./images/rank/project/parts/'+rank+'/'+rank+'_crown_d'+div+'_sheeng.png');
				f_progress(100);

				break;
			case "burning":

				if(sr3){
					draw('./images/rank/project/parts/'+rank+'/'+rank+'_sr3_hotg.png');
					f_progress(17);
					await sleep(sleeptime);
				}

				if(sr2){
					draw('./images/rank/project/parts/'+rank+'/'+rank+'_sr2_hotg.png');
					f_progress(33);
					await sleep(sleeptime);
				}

				if(sr1){
					draw('./images/rank/project/parts/'+rank+'/'+rank+'_sr1_hotg.png');
					f_progress(50);
					await sleep(sleeptime);
				}

				draw('./images/rank/project/parts/'+rank+'/'+rank+'_base_hotg.png');
				f_progress(67);
				await sleep(sleeptime);

				draw('./images/rank/project/parts/'+rank+'/'+rank+'_face_hotg.png');
				f_progress(83);
				await sleep(sleeptime);

				draw('./images/rank/project/parts/'+rank+'/'+rank+'_crown_d'+div+'_hotg.png');
				f_progress(100);

				break;

			case "sword" :
				draw('./images/rank/project/parts/'+rank+'/'+rank+'_sr3.png');
				f_progress(100);
				break;
		}
		await sleep(sleeptime*3);
		var canvas = document.getElementById('icon');
		var img    = canvas.toDataURL("image/png");
		document.getElementById("download-link").href = img;
		document.getElementById("download-link").download = type+'_'+rank+'_'+div;
		document.getElementById("download-link").style.display = "inline-block";
		document.getElementById("text-status").style.display = "none";
    	//document.write('<img src="'+img+'"/>');
		//document.getElementById("download-button").innerHTML = '<button onclick="downloadCanvas(this, \'icon\', \''+rank+division+'.png\');">Download</button>';
		if(bool){
			update(false);
		}
	}
	update();
</script>