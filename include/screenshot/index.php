<h1>
    <?php 
    echo ucfirst($page);
    ?>
</h1>

<div class="span12">

 
 <?php
 try 
{
  //create or open the database
  $database = new SQLiteDatabase('./db/main.sqlite', 0666, $error);
}
catch(Exception $e) 
{
  die($error);
}


$query = "SELECT * FROM screenshot";
if($result = $database->query($query, SQLITE_BOTH, $error))
{
  while($row = $result->fetch())
  {
		$title = $row['title'];
		$original = $row['original'];
		$thumbnail = $row['thumbnail'];
		echo '<div class="span1 well">';
		echo '<a title="'. $title .'" class="fancybox" rel="group" href="'.  $original .'"><img src="' . $thumbnail . '" alt="" /></a>';
		echo '</div> ';
  }
}
else
{
  die($error);
}
 ?>
</div>	
