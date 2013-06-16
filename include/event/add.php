<h1>
    <?php 
        echo ucfirst($page);
    ?>
</h1>
<?php
    if(!empty($_POST['name']) || !empty($_POST['event']) || !empty($_POST['location']) ||
        !empty($_POST['info']) || !empty($_POST['time']) || !empty($_POST['month']) ||
        !empty($_POST['day']) || !empty($_POST['year']) || !empty($_POST['pass']) )
    {

        //recieve the variables
        $name =  mysql_real_escape_string($_POST['name']);
        $event =  mysql_real_escape_string($_POST['event']);
        $location =  mysql_real_escape_string($_POST['location']);
        $info =  mysql_real_escape_string($_POST['info']);
        $time =  mysql_real_escape_string($_POST['time']);
        $month =  mysql_real_escape_string($_POST['month']);
        $day =  mysql_real_escape_string($_POST['day']);
        $year =  mysql_real_escape_string($_POST['year']);
        $pass =  mysql_real_escape_string($_POST['pass']);
        
        //checking data
        $check = mysql_query("SELECT * FROM cp_event WHERE pass = '$pass'");
        $row = mysql_num_rows($check);
        if(!$row) {
            //inserting data 
            $add = "INSERT INTO cp_event  (name, event, location, info, time, month, day, year, pass)VALUES('$name','$event','$location','$info','$time','$month','$day','$year','$pass')";
            //declare in the order variable
            $result = mysql_query($add) or die(mysql_error());  
        } 
        else 
        {
            $hideForm = 1;
            echo '<div class="span7 offset2">';
              echo '<div class="alert alert-error">';
                echo '<strong>Error</strong> Change a few things up and try submitting again.';
              echo '</div>';
              echo '<a class="btn btn-primary"  onClick="history.go(-1);return true;">Go Back</a>';
            echo '</div>';
        }    
        
        unset($name);
        unset($event);
        unset($location);
        unset($info);
        unset($time);
        unset($month);
        unset($day);
        unset($year);
        unset($pass);
        mysql_close();
       
    }

 
    if($result) {
        $hideForm = 1;
        echo '<div class="span4 offset4">';
          echo '<div class="alert alert-success">';
            echo '<strong>Success</strong> You have successfully an event.';
          echo '</div>';
        echo '</div>';
    }

$months=array('','January','February','March','April','May','June','July','August',
'September','October','November','December');
$month="<select name=\"".$name."month\">";
 for($i=1;$i<=12;$i++)
 {
    $month.="<option value='$i'>$months[$i]</option>";
 }
$month.="</select> ";

$day.="<select name=\"".$name."day\">";
 for($i=1;$i<=31;$i++)
 {
    $day.="<option value='$i'>$i</option>";
 }
 $day.="</select> ";

$startyear = date("Y")-1;
$endyear= date("Y")+5;

 $year.="<select name=\"".$name."year\">";
 for($i=$startyear;$i<=$endyear;$i++)
 {
   $year.="<option value='$i'>$i</option>";
 }
 $year.="</select> "; 

?>
<?php if(!$hideForm): ?>
    <div class="span7 offset2">
      <form class="form-horizontal well" method="post">
        <fieldset>
          <legend>Add event</legend> 
                <div class="control-group">
                    <label class="control-label" for="event">Name :</label>
                    <div class="controls">
                      <input type="text" class="input-xlarge" name="name" required="required" maxlength="25">
                      <p class="help-block">e.g Armeia Denzi or raijinn.9146</p>
                    </div>
                </div>   
                <div class="control-group">
                    <label class="control-label" for="event">Event Name :</label>
                    <div class="controls">
                      <input type="text" class="input-xlarge" name="event" required="required" maxlength="50">
                      <p class="help-block">e.g Fractal, CoF, WvW</p>
                    </div>
                </div>   
                <div class="control-group">
                    <label class="control-label" for="location">Location :</label>
                    <div class="controls">
                      <input type="text" class="input-xlarge" name="location" required="required" maxlength="50">
                      <p class="help-block"></p>
                    </div>
                </div> 
                <div class="control-group">
                    <label class="control-label" for="info">Information :</label>
                    <div class="controls">
                      <textarea name="info" class="input-xlarge" rows="6"></textarea>
                    </div>
                </div>
                <div class="control-group">    
                    <label class="control-label" for="time">Time(<a  target=\"_blank\" title="Time is based on server time.">?</a>) : </label>
                    <div class="controls">
                        <input value="00:00" type="time" class="input-xlarge" name="time">
                    </div>
                </div>
                <div class="control-group">    
                    <label class="control-label" for="month">Month</label>
                    <div class="controls">
                        <?php
                            echo $month;
                         ?>
                    </div>
                </div>   
                <div class="control-group">    
                    <label class="control-label" for="day">Day</label>
                    <div class="controls">
                        <?php
                            echo $day;
                        ?>
                    </div> 
                </div> 
                <div class="control-group">    
                    <label class="control-label" for="year">Year</label>
                    <div class="controls">
                        <?php
                            echo $year;
                        ?>
                    </div> 
                </div> 
                <div class="control-group">
                    <label class="control-label" for="pass">Password :</label>
                    <div class="controls">
                      <input type="password" class="input-xlarge" name="pass" required="required" maxlength="20">
                      <p class="help-block">Password used for event deletion. Don't use your game password.</p>
                    </div>
                </div>   


                
   
                <div class="control-group">    
                  </div>
                  <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="reset" class="btn">Cancel</button>
                  </div>
                  <input type="button" value="Go back" onClick="history.go(-1);return true;" class="btn btn-primary">
               
                
			</fieldset>
        
		</form>
	</div>

<?php endif; ?>








