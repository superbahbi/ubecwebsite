<!-- Home module -->
<?php
		//include_once('./classes/mysql.class.php');	
		//$db = new mysql();
		
		//$db->host = 'bahbi.db';
        //$db->username = 'superbahbi';
        //$db->password = 'qo9ikci2';
        //$db->table = 'ubec';

                    
		
	 if(!empty($_FILES['userfile']['tmp_name'])) {
		$api_key = "45761c42f83c1da94fab462d1ed1e70e";
		
		$filename = $_FILES['userfile']['tmp_name'];
		$handle = fopen($filename, "r");
		$data = fread($handle, filesize($filename));

		// $data is file data
		$pvars   = array('image' => base64_encode($data), 'key' => $api_key);
		$timeout = 30;
		$curl    = curl_init();

		curl_setopt($curl, CURLOPT_URL, 'http://api.imgur.com/2/upload.json');
		curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($curl, CURLOPT_POST, 1);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);

		$img = curl_exec($curl);
		
		curl_close ($curl);
		$img = json_decode($img);
		
		$time = time();
		$original = $img->upload->links->original;
		$thumbnail = $img->upload->links->small_square;
		$delete_page = $img->upload->links->delete_page;
		$ip = $_SERVER['REMOTE_ADDR'];
		$title =  $_POST['title'];
		
		try 
		{
		  $database = new SQLiteDatabase('./db/main.sqlite', 0666, $error);
		}
		catch(Exception $e) 
		{
		  die($error);
		}
			$result = $database->queryExec("INSERT INTO screenshot (time, original, thumbnail, delete_link, ip, title) VALUES ('$time','$original','$thumbnail','$delete_page','$ip','$title')", $error);
			if(!$result)
			{
			  die($error);
			} else {
						 echo '<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
							echo '<div class="modal-header">';
							  echo '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>';
							  echo '<h3 id="myModalLabel">Added.</h3>';
							echo '</div>';
							echo '<div class="modal-body">';
							  echo '<center><img src="' . $img->upload->links->small_square . '" /><br>';
							  echo '<a href=" ' . $img->upload->links->delete_page . '">Click here to delete</a></center>';
							echo '</div>';
							echo '<div class="modal-footer">';
							echo '</div>';
						  echo '</div>';
					}
} 
?>
<h1>
    <?php 
        echo ucfirst($page);
	?>	
</h1>	

<div class="row span12 well">

		<div class="span3 well">
			<h3><span class="entypo-megaphone"> Mumble</span></h3>
			<p>Address:  chicago.mumblefrag.com <br>
			Port:  4054<br>
			</p>
			<a href="http://ubec.obscureserver.com/index.php?page=forum#/discussion/1/mumble-voice-chat" class="btn btn-danger">Read more</a>
		</div>	
	
		<div class="span3 well">
			<h3><span class="entypo-vcard"> Guild information</span></h3>
			<p>Guild name:  Legion of Ubec<br>
			Server:  Gate of Madness [US]<br>
			Location:  Philippines<br>
			Activities:  WvW<br>
			Recruitment is <i class="text-success">Open</i>
			</p>
		</div>	
	

		<div class="span4 well">
			<h3><span class="fontawesome-picture"> Upload a Screenshot</span></h3>
			<!--<script type="text/javascript" src="http://form.jotform.us/jsform/23445630228147"></script>-->
				<form enctype="multipart/form-data" method="POST">
				<input name="title" type="text" value="Title"  maxlength="120" /> (max length: 120)
				<input name="userfile" type="file" /><br />
				<button type="submit" class="btn btn-danger">Upload</button>

			</form>
		</div>
</div><br>
<div class="row span12 well">
		<div class="span3 well" >
				<h3><span class="brandico-twitter-bird"> Twitter Feed</span></h3>
				<p>
					<a class="twitter-timeline" href="https://twitter.com/GuildWars2" data-widget-id="278097414529875968">Tweets by @GuildWars2</a>
					<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
				</p>
		</div>
		<div class="span7 well">
			<h3><span class="entypo-newspaper"></span> News</h3>
				<?php
					include './admin/news.php';
				?>
		</div>
</div><br>	
<!--
<div class="row span12 well">
	<div class="offset1">
		<h3><span class="entypo-calendar"> Upcoming events</span></h3>
			//<?php
			//$event = $db->db_get_event();
			//?>
	</div>
</div><br>	
-->
 <!-- Imgur upload json response
 object(stdClass)#1 (1) {
	["upload"]=> object(stdClass)#2 (2) { 
		["image"]=> object(stdClass)#3 (13) { 
			["name"]=> NULL 
			["title"]=> NULL 
			["caption"]=> NULL 
			["hash"]=> string(5) "Yyozx" 
			["deletehash"]=> string(15) "uDRLNP69hygx0Jg" 
			["datetime"]=> string(19) "2012-12-11 00:35:27" 
			["type"]=> string(10) "image/jpeg"
			["animated"]=> string(5) "false" 
			["width"]=> int(500) 
			["height"]=> int(369) 
			["size"]=> int(39909) 
			["views"]=> int(0) 
			["bandwidth"]=> int(0) 
		}
		["links"]=> object(stdClass)#4 (5) { 
			["original"]=> string(28) "http://i.imgur.com/Yyozx.jpg" 
			["imgur_page"]=> string(22) "http://imgur.com/Yyozx" 
			["delete_page"]=> string(39) "http://imgur.com/delete/uDRLNP69hygx0Jg" 
			["small_square"]=> string(29) "http://i.imgur.com/Yyozxs.jpg" 
			["large_thumbnail"]=> string(29) "http://i.imgur.com/Yyozxl.jpg" 
		} 
	} 
} 
 -->
