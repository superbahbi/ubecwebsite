<?php
    function get_data($url)
    {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
	
	 function convert_gold($data) {
		$data_len= (int)strlen($data);
		$num = 10;
		
		for ( $i = 1; $i < $data_len - 1; $i++) {
			$num =  $num * 10;
		}
		
		$gold = (int)($data / 10000);
        $silver = (int)($data / 100 - ( $gold * 100));
        $copper = round($data % 100, 0, PHP_ROUND_HALF_DOWN);
		return array ( $gold, $silver, $copper );
	 }

	 function show_gold($data) {
		 if($data[0] > 0) { 
			echo $data[0] ; 
			echo '<a class="gw2gold">g</a> ';
		 }   
		 if($data[1] > 0) { 
			echo $data[1] ; 
			echo '<a class="gw2silver">s</a> ';
		 }  
		 if($data[2] > 0) { 
			echo $data[2] ; 
			echo '<a class="gw2copper">c</a> ';
		 }
	 }

?>