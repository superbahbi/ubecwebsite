<h1>
    <?php 
        echo ucfirst($page);
    ?>
</h1>
  </div>
<?php
    
    if ( !$hideForm ) {
            if(!empty($_POST['pass']))
            {
        
                //recieve the variables
        
                $pass =  mysql_real_escape_string($_POST['pass']);
                
                //checking data
                $check = mysql_query("SELECT * FROM cp_event WHERE pass = '$pass'");
                $row = mysql_num_rows($check);
                
                if($row) {
                    //Get  data 
                    $check = mysql_query("SELECT id, name, event, location, time, info, month, day, year FROM cp_event WHERE pass = '$pass'");
                    $result=mysql_fetch_object($check) or die(mysql_error());
                    $hideForm = 2;
                } 
                else 
                {
                    $hideForm = 1;
                    echo '<div class="span4 offset4">';
                      echo '<div class="alert alert-error">';
                        echo '<strong>Error</strong> Change a few things up and try submitting again. Wrong password.';
                      echo '</div>';
                      echo '<a class="btn btn-primary"  onClick="history.go(-1);return true;">Go Back</a>';
                    echo '</div>';
        
                }    
                
                unset($pass);
                mysql_close();
               
            }
    } 
    if($hideForm == 2) {
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
    
                //inserting data 
                //SET `email`='new_mail@domain.net'
                //$add = "UPDATE cp_event  (name, event, location, info, time, month, day, year, pass)VALUES('$name','$event','$location','$info','$time','$month','$day','$year','$pass')";
    
                $edit = "UPDATE cp_event SET name='$name' , event='$event' , location='$location' , info='$info' , time='$time' , month='$month' , day='$day' , year='$year' , pass='$pass' WHERE id='$result->id'";
               //declare in the order variable
                $result = mysql_query($edit) or die(mysql_error());
      
            
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
    }

?>
<?php if($hideForm == 2): ?>
  <div class="row">
    <div class="span7 offset2">
      <form class="form-horizontal well" method="post">
        <fieldset>
          <legend>Edit event</legend> 
                <div class="control-group">
                    <label class="control-label" for="event">Name :</label>
                    <div class="controls">
                      <?php echo '<input type="text" class="input-xlarge" name="name" required="required" maxlength="25" value=' . $result->name . '>'; ?>
                      <p class="help-block">e.g Armeia Denzi or raijinn.9146</p>
                    </div>
                </div>   
                <div class="control-group">
                    <label class="control-label" for="event">Event Name :</label>
                    <div class="controls">
                      <?php echo '<input type="text" class="input-xlarge" name="event" required="required" maxlength="50" value=' . $result->event . '>'; ?>
                      <p class="help-block">e.g Fractal, CoF, WvW</p>
                    </div>
                </div>   
                <div class="control-group">
                    <label class="control-label" for="location">Location :</label>
                    <div class="controls">
                      <?php echo '<input type="text" class="input-xlarge" name="location" required="required" maxlength="50" value=' . $result->location . '>'; ?>
                      <p class="help-block"></p>
                    </div>
                </div> 
                <div class="control-group">
                    <label class="control-label" for="info">Information :</label>
                    <div class="controls">
                      <?php echo '<textarea name="info" class="input-xlarge" rows="6">' . $result->info . '</textarea>'; ?>
                    </div>
                </div>
                <div class="control-group">    
                    <label class="control-label" for="time">Time(<a  target=\"_blank\" title="Time is based on server time.">?</a>) : </label>
                    <div class="controls">
                        <?php echo '<input value="00:00" type="time" class="input-xlarge" name="time" value=' . $result->time . '>'; ?>
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
                      </select>
                    </div> 
                </div> 
                <div class="control-group">    
                    <label class="control-label" for="year">Year</label>
                    <div class="controls">
                        <?php
                            echo $year;
                        ?>
                      </select>
                    </div> 
                </div> 
                <div class="control-group">
                    <label class="control-label" for="pass">Password :</label>
                    <div class="controls">
                      <?php echo '<input type="password" class="input-xlarge" name="pass" required="required" maxlength="20"  value=' . $result->pass . '>'; ?>
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
                </div> 
                
        </fieldset>
        
      </form>
     </div>
    <!--<h6> Pro tip: Make sure everything is correct, you can not modify it later. </h6>-->
    <!--<iframe src="https://docs.google.com/spreadsheet/embeddedform?formkey=dF9QbmpVSkF1S20tSWhQMDJRMmFzdEE6MQ" width="760" height="1257" frameborder="0" marginheight="0" marginwidth="0">Loading...</iframe>-->
      
  
<?php endif; ?>



<?php if(!$hideForm): ?>
  <div class="row">
    <div class="span7 offset2">
      <form class="form-horizontal well" method="post">
        <fieldset>
          <legend>Edit event</legend> 
                <div class="control-group">
                    <label class="control-label" for="event">Passphrass :</label>
                    <div class="controls">
                      <input type="password" class="input-xlarge" name="pass" required="required" maxlength="25">
                      <p class="help-block"></p>
                    </div>
                </div>   

   
                <div class="control-group">    
                  </div>
                  <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <input type="button" value="Go back" onClick="history.go(-1);return true;" class="btn btn-primary">
                  </div>
                  
                </div> 
                
        </fieldset>
      </form>
     </div>   
<?php endif; ?>





