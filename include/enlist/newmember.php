<h1>
    <?php 
        echo ucfirst($page);
    ?>
</h1>
  </div>
<?php
    if(!empty($_POST['username']))
    {
        require_once 'config/db.php';
        //implode array
        $multiAct = implode(", ", $_POST['multiActivities']);
        $multiHear = implode(", ", $_POST['multiHear']);
        
        //recieve the variables
        $username =  mysql_real_escape_string($_POST['username']);
        $ingamename =  mysql_real_escape_string($_POST['ingamename']);
        $races =  mysql_real_escape_string($_POST['races']);
        $professions =  mysql_real_escape_string($_POST['professions']);
        $timezone = mysql_real_escape_string($_POST['timezone']);     
        $optionsServer =  mysql_real_escape_string($_POST['optionsServer']);
        $ageGroup = mysql_real_escape_string($_POST['ageGroup']);
        $multiAct = mysql_real_escape_string($multiAct);
        $multiHear = mysql_real_escape_string($multiHear);
        
        //checking data
        $check = mysql_query("SELECT * FROM cp_enlist WHERE username = '$username'");
        $row = mysql_num_rows($check);
        if(!$row) {
            //inserting data 
            $addlist = "INSERT INTO cp_enlist  (username, ingamename, races, professions, timezone, optionsServer, agegroup, activities, aboutus )VALUES('$username','$ingamename','$races','$professions','$timezone','$optionsServer','$ageGroup','$multiAct','$multiHear')";
            //declare in the order variable
            $result = mysql_query($addlist) or die(mysql_error());  
        } 
        else 
        {
            $hideForm = 1;
            echo '<div class="span4 offset4">';
              echo '<div class="alert alert-error">';
                echo '<strong>Error</strong> Change a few things up and try submitting again. User is already registered.';
              echo '</div>';
            echo '</div>';
        }    
        
        unset($username);
        unset($ingamename);
        unset($races);
        unset($professions);
        unset($timezone);
        unset($optionsServer);
        unset($ageGroup);
        unset($multiAct);
        unset($multiHear);
        mysql_close();
       
    }

 
    if($result) {
        $hideForm = 1;
        echo '<div class="span4 offset4">';
          echo '<div class="alert alert-success">';
            echo '<strong>Success</strong> You have successfully added your information.';
          echo '</div>';
        echo '</div>';
    }

?>


<?php if(!$hideForm): ?>
  <div class="row">
    <div class="span7 offset2">
      <form class="form-horizontal well" method="post">
        <fieldset>
          <legend>Application Form</legend> 
                <div class="control-group">
                    <label class="control-label" for="username">Username</label>
                    <div class="controls">
                      <input type="text" class="input-xlarge" name="username" required="required" >
                      <p class="help-block">e.g. username.1234</p>
                    </div>
                </div>   
                <div class="control-group">    
                    <label class="control-label" for="ingamename">In-Game name</label>
                    <div class="controls">
                      <input type="text" class="input-xlarge" name="ingamename" required="required" size="50">
                      <p class="help-block"></p>
                    </div>
                </div> 
                <div class="control-group">
                    <label class="control-label" for="timezone">Time zone</label>
                    <div class="controls">
                      <input type="text" class="input-xlarge" name="timezone" required="required" size="10">
                      <p class="help-block"></p>
                    </div>
                </div>  
                <div class="control-group">    
                    <label class="control-label" for="races">Race</label>
                    <div class="controls">
                      <select name="races">
                        <option>Asura</option>
                        <option>Syvari</option>
                        <option>Human</option>
                        <option>Norm</option>
                        <option>Charr</option>
                      </select>
                    </div>
                </div>   
                <div class="control-group">    
                    <label class="control-label" for="professions">Profession</label>
                    <div class="controls">
                      <select name="professions">
                        <option>Engineer</option>
                        <option>Necromancer</option>
                        <option>Thief</option>
                        <option>Elementalist</option>
                        <option>Warrior</option>
                        <option>Ranger</option>
                        <option>Mesmer</option>
                        <option>Guardian</option>
                      </select>
                    </div> 
                </div> 
                
                <div class="control-group">
                    <label class="control-label" for="optionsServer">Is your home server "Gate of Madness"?</label>
                    <div class="controls">
                        <input class="radio" type="radio" name="optionsServer" value="Yes" checked /> Yes <br>
                        <input class="radio" type="radio" name="optionsServer" value="No" /> No
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="ageGroup">Age group</label>
                    <div class="controls">
                        <input class="radio" type="radio" name="ageGroup" value="under15"  checked /> Under 15 <br>
                        <input class="radio" type="radio" name="ageGroup" value="15 - 18"  /> 15 - 18 <br>
                        <input class="radio" type="radio" name="ageGroup" value="19 - 24"  /> 19 - 24 <br>
                        <input class="radio" type="radio" name="ageGroup" value="25 - 43"  /> 25 - 43 <br>
                        <input class="radio" type="radio" name="ageGroup" value="35+" /> 35+
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="multiActivities">Activities</label>
                    <div class="controls">
                      <select multiple="multiple" name="multiActivities[]" value="0">
                        <option selected>WvW</option>
                        <option>sPvp</option>
                        <option>PvE</option>
                        <option>Other</option>
                      </select>
                    </div>

                
                <div class="control-group">
                    <label class="control-label" for="multiHear">How did you hear about us?</label>
                    <div class="controls">
                      <select multiple="multiple" name="multiHear[]" value="0">
                        <option selected>In-Game</option>
                        <option>Facebook</option>
                        <option>Guild website</option>
                        <option>Guild Wars 2 forum</option>
                        <option>Friend</option>
                        <option>Other game forum</option>
                      </select>
                    </div>
                </div>

                
   
                <div class="control-group">    
                  </div>
                  <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="reset" class="btn">Cancel</button>
                  </div>
                </div> 
        </fieldset>
      </form>
     </div>
    <!--<h6> Pro tip: Make sure everything is correct, you can not modify it later. </h6>-->
    <!--<iframe src="https://docs.google.com/spreadsheet/embeddedform?formkey=dF9QbmpVSkF1S20tSWhQMDJRMmFzdEE6MQ" width="760" height="1257" frameborder="0" marginheight="0" marginwidth="0">Loading...</iframe>-->
      
  
<?php endif; ?>








