

<h1>
    <?php 
        echo ucfirst($page);
    ?>
</h1>
  </div>
<?
    if(!empty($_POST['username']) && !empty($_POST['ingamename']))
    {
        require_once 'config/db.php';
        //recieve the variables
        $username =  mysql_real_escape_string($_POST['username']);
        $realname =  mysql_real_escape_string($_POST['realname']);
        $ingamename =  mysql_real_escape_string($_POST['ingamename']);
        $races =  mysql_real_escape_string($_POST['races']);
        $professions =  mysql_real_escape_string($_POST['professions']);
        $timezone = mysql_real_escape_string($_POST['timezone']);
        
        //checking data
        $check = mysql_query("SELECT * FROM cp_memberlist WHERE username = '$username'");
        $row = mysql_num_rows($check);
        if(!$row) {
            //inserting data 
            $addlist = "INSERT INTO cp_memberlist (username, realname, ingamename, races, professions, timezone)VALUES('$username','$realname','$ingamename','$races','$professions','$timezone')";
            //declare in the order variable
            $result = mysql_query($addlist); 
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
        unset($realname);
        unset($ingamename);
        unset($races);
        unset($professions);
        unset($timezone);
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
          <legend>Legion of Ubec - Username & In-Game Names</legend>
          
                <div class="control-group">
                    <label class="control-label" for="username">Username</label>
                    <div class="controls">
                      <input type="text" class="input-xlarge" name="username" required="required" >
                      <p class="help-block">e.g. username.1234</p>
                    </div>
                </div> 
                <div class="control-group">
                    <label class="control-label" for="realname">Real name</label>
                    <div class="controls">
                      <input type="text" class="input-xlarge" name="realname" required="required" >
                      <p class="help-block"></p>
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
                      <input type="text" class="input-xlarge" name="timezone" required="required" size="15">
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
  
  
<?php endif; ?>








