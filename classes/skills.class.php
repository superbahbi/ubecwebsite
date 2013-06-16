<?php
class skills {
	var $url;
	
	public function get_api_skills() {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, 'http://www.gw2db.com/json-api/recipes?guid=C38CAEB9-8CF4-4BC2-95C8-D53D1227590B');
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        $data = curl_exec($ch);
        curl_close($ch);
		$data = json_decode($data);
		echo 'XD';
		echo $data ? 1 : 2;
	}
}
?>