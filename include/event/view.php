<?php

$id =  mysql_real_escape_string($_GET['id']);

$check = mysql_query("SELECT id, name, event, location, time, info, month, day, year FROM cp_event WHERE id = '$id'");
$result=mysql_fetch_object($check);

?>
<h1>
    <?php 
        echo ucfirst($page);
    ?>
</h1>
<div class="span4 offset4 well">
		<dl class="dl-horizontal">
            <dt><span class="typicons-user active"></span><strong> Name </strong> </dt><dd><?php echo stripslashes($result->name); ?> </dd>
            <dt><span class="fontawesome-flag"><strong> Event Name </strong></dt><dd><?php echo stripslashes($result->event); ?> </dd>
            <dt><span class="fontawesome-time"></span><strong> Time </strong></dt><dd><?php echo stripslashes($result->time); ?> PST </dd>
            <dt><span class="fontawesome-map-marker"></span><strong> Location </strong></dt><dd><?php echo stripslashes($result->location); ?> </dd>
            <dt><span class="entypo-info"></span><strong> Information </strong></dt><dd><?php echo stripslashes($result->info); ?> </dd>
            <dt><span class="entypo-calendar"></span><strong> Date </strong></dt><dd><?php echo $result->month; ?> / <?php echo $result->day; ?> / <?php echo $result->year; ?> </dd>
         </dl>  
            <a class="btn btn-primary" href="/index.php?page=event&action=edit">Edit event</a>
            <a class="btn btn-primary" href="/index.php?page=event&action=delete">Delete event</a>
            <a class="btn btn-primary"  onClick="history.go(-1);return true;">Go Back</a>
</div>

<!-- include("/home/jaerocom/public_html/obscureserver/ubec/news2/show_news.php");  -->
