<!-- Test module -->
<?php
try 
{
  //create or open the database
  $database = new SQLiteDatabase('db/main.sqlite', 0666, $error);
}
catch(Exception $e) 
{
  die($error);
}

/*$query =    	  
'INSERT INTO screenshot (time, original, thumbnail, delete_link, ip, title)' . 
'VALUES (1355274520, "http://i.imgur.com/ImsMD.jpg", "http://i.imgur.com/ImsMDs.jpg", "http://imgur.com/delete/9JDWJZIzp9ivHSh", "70.178.181.241", "Title");' .
'INSERT INTO screenshot (time, original, thumbnail, delete_link, ip, title)' . 
'VALUES (1355274509, "http://i.imgur.com/68UAz.jpg", "http://i.imgur.com/68UAzs.jpg", "http://imgur.com/delete/YIQ6OnKTYetplK5", "70.178.181.241", "Title");' .
'INSERT INTO screenshot (time, original, thumbnail, delete_link, ip, title)' . 
'VALUES (1355274500, "http://i.imgur.com/wGRi8.jpg", "http://i.imgur.com/wGRi8s.jpg", "http://imgur.com/delete/bkDiEE4TgUl2x9t", "70.178.181.241", "Title");' .
'INSERT INTO screenshot (time, original, thumbnail, delete_link, ip, title)' . 
'VALUES (1355272870, "http://i.imgur.com/yN4MR.jpg", "http://i.imgur.com/yN4MRs.jpg", "http://imgur.com/delete/t1KbxUshNWnSH9C", "70.178.181.241", "Title");' .
'INSERT INTO screenshot (time, original, thumbnail, delete_link, ip, title)' . 
'VALUES (1355272049, "http://i.imgur.com/F22yO.jpg", "http://i.imgur.com/F22yOs.jpg", "http://imgur.com/delete/AYo6XewcOJ4GDep", "70.178.181.241", "Title");' .
'INSERT INTO screenshot (time, original, thumbnail, delete_link, ip, title)' . 
'VALUES (1355274528, "http://i.imgur.com/iMpdG.jpg", "http://i.imgur.com/iMpdGs.jpg", "http://imgur.com/delete/cwYEnLCULUoxAa1", "70.178.181.241", "Title");' .
'INSERT INTO screenshot (time, original, thumbnail, delete_link, ip, title)' . 
'VALUES (1355274534, "http://i.imgur.com/A6srt.jpg", "http://i.imgur.com/A6srts.jpg", "http://imgur.com/delete/L0buT1vbK6W40D7", "70.178.181.241", "Title");' .
'INSERT INTO screenshot (time, original, thumbnail, delete_link, ip, title)' . 
'VALUES (1355274540, "http://i.imgur.com/ZFyga.jpg", "http://i.imgur.com/ZFygas.jpg", "http://imgur.com/delete/Kx0XOHpjFpsr3Aj", "70.178.181.241", "Title");';


if(!$database->queryExec($query, $error))
{
  die($error);
}*/
/*$query = "SELECT * FROM screenshot";
if($result = $database->query($query, SQLITE_BOTH, $error))
{
  while($row = $result->fetch())
  {
    print(
			"time: {$row['time']} <br />" .
			"original: {$row['original']} <br />" .
			"thumbnail: {$row['thumbnail']} <br />" .
			"delete_link: {$row['delete_link']} <br />" .
			"ip: {$row['ip']} <br />".
			"title: {$row['title']} <br /><br />");
  }
}
else
{
  die($error);
}
*/

		// Create table
        //$database->query('CREATE TABLE user (id INT, user TEXT, password TEXT, PRIMARY KEY (id))');
		//Insert table
		//$query = 'INSERT INTO user (user, password) VALUES ("bahbi", "v33219");';

		//if(!$database->queryExec($query, $error))
		//{
		//  die($error);
		//}
?>


