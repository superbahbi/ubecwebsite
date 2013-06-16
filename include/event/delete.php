<h1>
    <?php 
        echo ucfirst($page);
    ?>
</h1>
<?php
    if(!empty($_POST['pass']))
    {

        //recieve the variables

        $pass =  mysql_real_escape_string($_POST['pass']);
        
        //checking data
        $check = mysql_query("SELECT * FROM cp_event WHERE pass = '$pass'");
        $row = mysql_num_rows($check);
        
        if($row) {
            //deleteing  data 
            $del = "DELETE FROM cp_event WHERE pass = '$pass'";
            //declare in the order variable
            $result = mysql_query($del) or die(mysql_error());  
        } 
        else 
        {
            $hideForm = 1;
            echo '<div class="span4 offset4">';
              echo '<div class="alert alert-error">';
                echo '<strong>Error</strong> Change a few things up and try submitting again.';
              echo '</div>';
              echo '<a class="btn btn-primary"  onClick="history.go(-1);return true;">Go Back</a>';
            echo '</div>';

        }    
        
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



?>
<?php if(!$hideForm): ?>
  <div class="row">
    <div class="span7 offset2">
      <form class="form-horizontal well" method="post">
        <fieldset>
          <legend>Delete event</legend> 
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








