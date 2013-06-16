
<h1>
    <?php 
        echo ucfirst($page);
    ?>
</h1>
  <div class="row">
      <div class="span12">

                <?php
                    include_once('./config/function.php');
                    $cms = new cms();
                    
                    $cms->host = '.com';
                    $cms->username = '';
                    $cms->password = '';
                    $cms->table = '';
                    $cms->connect();
            
                    echo '<table cellpadding="0" cellspacing="0" class="db-table" align="center">';
                    echo '<tr><th>Username</th><th>Real name</th><th>In-Game name</th><th>Race</th><th>Profession</th></tr>';
                    echo $cms->display_member();
                    echo '</table>';
                ?>
      </div>
</div>

<!-- include("/home/jaerocom/public_html/obscureserver/ubec/news2/show_news.php");  -->
