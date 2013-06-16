<?php
class cms {

  var $host;
  var $username;
  var $password;
  var $table;


    
  public function display_public() {
    $q = "SELECT * FROM cp_cms ORDER BY created DESC LIMIT 3";
    $r = mysql_query($q);

    if ( $r !== false && mysql_num_rows($r) > 0 ) {
      while ( $a = mysql_fetch_assoc($r) ) {
        $title = stripslashes($a['title']);
        $bodytext = stripslashes($a['bodytext']);

        $entry_display .= <<<ENTRY_DISPLAY

    <div class="postCMS">
        <h2>
    		$title
    	</h2>
	    <p>
	      $bodytext
	    </p>
	</div>

ENTRY_DISPLAY;
      }
    } else {
      $entry_display = <<<ENTRY_DISPLAY

    <h2> This Page Is Under Construction </h2>
    <p>
      No entries have been made on this page. 
      Please check back soon, or click the
      link below to add an entry!
    </p>

ENTRY_DISPLAY;
    }
    $entry_display .= <<<ADMIN_OPTION

    <p class="admin_link">
      <a href="{$_SERVER['PHP_SELF']}?page=login&admin=1">Add a New Entry</a>
    </p>

ADMIN_OPTION;

    return $entry_display;
  }

  public function display_admin() {
    return <<<ADMIN_FORM

    <form action="index.php?page=login" method="post">
    
      <label for="title">Title:</label><br />
      <input name="title" id="title" type="text" maxlength="150" />
      <div class="clearCMS"></div>
     
      <label for="bodytext">Body Text:</label><br />
     <textarea name="styled-textarea" id="styled" onfocus="this.value=''; setbg('#e5fff3');" onblur="setbg('white')">Enter your comment here...</textarea>
      <div class="clearCMS"></div>
      
      <label for="title">Author:</label><br />
      <input name="author" id="author" type="text" maxlength="20" />
      <div class="clearCMS"></div>
      
      <input type="submit" value="Create This Entry!" />
    </form>
    
    <br />
    
    <a href="index.php?page=login">Back to Home</a>

ADMIN_FORM;
  }

  public function write($p) {
    if ( $_POST['title'] )
      $title = mysql_real_escape_string($_POST['title']);
    if ( $_POST['bodytext'])
      $bodytext = mysql_real_escape_string($_POST['bodytext']);
    if ( $_POST['author'])
      $author = mysql_real_escape_string($_POST['author']);
 
 if ( $title && $bodytext ) {
      $created = time();
      $sql = "INSERT INTO cp_cms VALUES('$title','$bodytext','$created')";
      return mysql_query($sql) or die("Could not post a quaggan. " . mysql_error());
    } else {
      return false;
    }
  }
  
    public function login($p) {

  }
  
public function loginForm() {
    return <<<ADMIN_FORM

    <form action="index.php?page=login" method="post">
    
      <label for="title">Username:</label>
        <input type='text' name='username'><br>
     
      <label for="bodytext">Password:</label>
        <input type='password' name='password'><br>
     
      
      <input type="submit" value="Login!" />
    </form>
    
    <br />
    
    <a href="index.php?page=login">Back to Home</a>

ADMIN_FORM;
  }

  public function connect() {
    mysql_connect($this->host,$this->username,$this->password) or die("Could not connect. " . mysql_error());
    mysql_select_db($this->table) or die("Could not select database. " . mysql_error());

    return $this->buildDB();
  }

  private function buildDB() {
    $sql = <<<MySQL_QUERY
CREATE TABLE IF NOT EXISTS cp_cms (
title		VARCHAR(150),
bodytext	TEXT,
created		VARCHAR(100)
)
MySQL_QUERY;

    return mysql_query($sql);
  }

public function display_member() {
    $q = "SELECT * FROM cp_memberlist ORDER BY realname";
    $r = mysql_query($q);
       
        

    if ( $r !== false && mysql_num_rows($r) > 0 ) {
        while ( $a = mysql_fetch_assoc($r) ) {
            $username = stripslashes($a['username']);
            $realname = stripslashes($a['realname']);
            $ingamename = stripslashes($a['ingamename']);
            $races = stripslashes($a['races']);
            $professions = stripslashes($a['professions']);
            
               
    
        $entry_display .= <<<ENTRY_DISPLAY
            <tr>
                <td> $username </td>
                <td> $realname </td>
                <td> $ingamename </td>
                <td> $races </td>
                <td> $professions </td>
            </tr>




ENTRY_DISPLAY;
      }
    } 
    


    return $entry_display;
  }


}
?>