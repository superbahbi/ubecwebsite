<?php
class trading {
	var $item_id;
	var $url;
	var $itemname;
	
	public function get_api_data() {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch,CURLOPT_URL,$this->url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        $data = curl_exec($ch);
        curl_close($ch);
		$data = json_decode($data);
		
		if (!$data) {
			throw new Exception('get_api_data: No data found. ');
		}
        return $data;
    }
	
	private function convert_gold($data) {
		$data_len= (int)strlen($data);
		$num = 10;
		
		for ( $i = 1; $i < $data_len - 1; $i++) {
			$num =  $num * 10;
		}
		if (!$data) {
			throw new Exception('convert_gold: No data found.');
		}
        return $data;
		$gold = (int)($data / 10000);
        $silver = (int)($data / 100 - ( $gold * 100));
        $copper = round($data % 100, 0, PHP_ROUND_HALF_DOWN);
		
		
		return array ( $gold, $silver, $copper );
	 }

	 public function show_gold($data) {
		 if($data[0] > 0) { 
			echo $data[0] . '<a class="gw2gold">g</a> ';
		 }   
		 if($data[1] > 0) { 
			echo $data[1] . '<a class="gw2silver">s</a> ';
		 }  
		 if($data[2] > 0) { 
			echo $data[2] . '<a class="gw2copper">c</a> ';
		 }
	 }	
	 
	public function show_data($data) {
		echo '<ul>';
			echo '<li> <img src="' . $data->result->img . '"/> <a href="http://www.gw2db.com/items/' . $data->result->gw2db_external_id . ' " class="btn btn-inverse" >'. $data->result->name . '</a>';
				echo '<ul>';
					echo '<li>Sale Price:'; echo show_gold(convert_gold($data->result->min_sale_unit_price)); echo '</li>';
					echo '<li>Buy Price:'; echo show_gold(convert_gold($data->result->max_offer_unit_price)); echo '</li>';
					echo '<li>Supply:' . $data->result->sale_availability . '</li>';
					echo '<li>Demand:' . $data->result->offer_availability . '</li>';
				echo '</ul>';
			echo '</li>';
		echo '</ul>';
    }

	
}
?>