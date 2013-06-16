
<h1>
    <?php 
        echo ucfirst($page);
    ?>
</h1>
  <div class="row">
      <div class="span12 offset4">

                <?php
                    include_once('./config/function.php');
                    $cms = new cms();
                                 
                    $cms->host = 'obscureserver.com';
                    $cms->username = '';
                    $cms->password = '';
                    $cms->table = '';
                    $cms->connect();
                    
              
                    $url = 'http://obscureserver.com/ubec/forum/api/session';
                    $obj = json_decode(get_data($url));
                    
                    print_r($obj);
                    if(isset($_POST['submit'])) {
                        $cms->login($_POST);
                    } else {
                        echo $cms->loginForm();
                    }

                ?>
      </div>
</div>

<!-- include("/home/jaerocom/public_html/obscureserver/ubec/news2/show_news.php");  -->
