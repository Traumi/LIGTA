<?php
	$key = "YOUR_API_KEY";
	$version = json_decode(file_get_contents('data/version.json'))->version;
	$ver_log = json_decode(file_get_contents('data/version.json'))->ver_log;
	isset($_COOKIE["lang"]) ? $lang = $_COOKIE["lang"] : $lang = "fr_FR"; 
?>