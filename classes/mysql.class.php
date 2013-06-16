<?php
class mysql {

	var $host;
	var $username;
	var $password;
	var $table;
	
	public function connect() {
		$this->connection = mysql_connect($this->host,$this->username,$this->password) or die("Could not connect. " . mysql_error());
		mysql_select_db($this->table) or die("Could not select database. " . mysql_error());

		return;
	}
	
	public function db_get_imgur_link() {
		$sql = "SELECT * FROM cp_imgur_upload ORDER BY time";
		$r = mysql_query($sql) or die("Could not get a quaggan. " . mysql_error());
    
		if ( $r !== false && mysql_num_rows($r) > 0 ) {
			while ( $a = mysql_fetch_object($r) ) {
				$original = stripslashes($a->original);
				$thumbnail = stripslashes($a->thumbnail);
				$title = stripslashes($a->title);
				
				echo '<div class="span1 well">';
					echo '<a title="'. $title .'" class="fancybox" rel="group" href="'.  $original .'"><img src="' . $thumbnail . '" alt="" /></a>';
				echo '</div> ';
			}
		} 
	}	
	
	public function db_add_imgur_link($link1,$link2,$link3,$ip,$title) {
		$time = time();

			$ip = mysql_real_escape_string($ip);
		if ( $link1 && $link2 && $link3 ) {
			$sql = "INSERT INTO cp_imgur_upload VALUES('$time','$link1','$link2','$link3','$ip','$title')";
			return mysql_query($sql) or die("Could not post a quaggan. " . mysql_error());
		} else {
			return false;
		}
	}

	public function db_get_event() {
		$sql = "SELECT * FROM cp_event ORDER BY id DESC LIMIT 4";
		$r = mysql_query($sql) or die("Could not get a quaggan. " . mysql_error());
    
		if ( $r !== false && mysql_num_rows($r) > 0 ) {
			while ( $a = mysql_fetch_object($r) ) {
				$id = stripslashes($a->id);
				$name = stripslashes($a->name);
				$event = stripslashes($a->event);
				$location = stripslashes($a->location);
				$time = stripslashes($a->time);
				$month = stripslashes($a->month);
				$day = stripslashes($a->day);
				$year = stripslashes($a->year);
						
				echo '<div class="span2 well">';
					echo '<h4>'. $event .'</h4>';
					echo '<p><span class="typicons-user active"></span> '. $name .'<br>';
					echo '<p><span class="fontawesome-time"></span> '. $month . '/' . $day .' '. $time .'PST<br>';
					echo '<p><span class="fontawesome-map-marker"></span> '. $location .'<br>';
					echo '</p>';
					echo '<a href="http://ubec.obscureserver.com/index.php?page=event&action=view&id='. $id .'" class="btn btn-danger">Read more</a>';
				echo '</div>';
			}
		} 

	}
	
}
?>