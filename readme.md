# LIGTA
This is a LoL API Based module that aim to gather data on LoL Players
## Install
- Add a ddragon folder and put the desired patch content in it with the following link https://ddragon.leagueoflegends.com/cdn/dragontail-9.6.1.tgz where 9.6.1 can be replaced by the desired version
- Paste this code in a init.php placed in parts folder
```PHP
<?php
	$key = "YOUR_API_KEY";
	$version = json_decode(file_get_contents('data/version.json'))->version;
	$ver_log = json_decode(file_get_contents('data/version.json'))->ver_log;
	isset($_COOKIE["lang"]) ? $lang = $_COOKIE["lang"] : $lang = "fr_FR"; 
?>
```
## Run
You just have to run an Apache server with that project
