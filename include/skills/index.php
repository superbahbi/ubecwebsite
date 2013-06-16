<?php
include_once('./classes/skills.class.php');	
$skills = new skills();

	//$skills->url = 'http://www.gw2db.com/json-api/skills?guid=C38CAEB9-8CF4-4BC2-95C8-D53D1227590B';
	$skills->get_api_skills();

?>