<!DOCTYPE html>
<?php 
    include('./config/config.php');
 ?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Legion of Ubec | Gate of Madness</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Le styles -->

    <link href="assets/css/bootstrap.css" rel="stylesheet">
	<style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
    <!--<link href="assets/css/custom.css" rel="stylesheet">-->
	<link href='http://fonts.googleapis.com/css?family=Rambla' rel='stylesheet' type='text/css'>
	
	
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="shortcut icon" href="/assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <a class="brand" href="#"> Legion of Ubec</a>
          <div class="nav-collapse collapse">
            <ul class="nav"> 
              <?php foreach ($menuList as $list): ?>
				  <li><a href="?page=<?php echo $list; ?>"><?php echo ucfirst($list); ?></a></li>
				<?php endforeach; ?>
            </ul>
			<!--
            <form class="navbar-form pull-right">
              <input class="span2" type="text" placeholder="Email">
              <input class="span2" type="password" placeholder="Password">
              <button type="submit" class="btn">Sign in</button>
            </form>
			-->
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
<div class="container">
	<div class="row">
		<div class="span10 offset1">
              <div id="myCarousel" class="carousel slide">
                <div class="carousel-inner">
                  <div class="item active">
                    <img src="assets/img/banner-december-2012.jpg" alt="">
                    <div class="carousel-caption">
                      <h4>Wintersday: The Wondrous Workshop of Toymaker Tixx</h4>
                       <p>The nights may be long and dark, but Tyrians of all races keep joy alive during the ancient holiday of Wintersday. While each race celebrates Wintersday in their own unique way, children all over Tyria share a common love of one thing: toys.</p>
                    </div>
                  </div>
                  <div class="item">
                    <img src="assets/img/banner-november-2012.jpg" alt="">
                    <div class="carousel-caption">
                      <h4>The Lost Shores</h4>
                     <p>Unravel a mystery of monstrous proportions in The Lost Shores, a massive one-time world event that will change Tyria forever!</p>
                    </div>
                  </div>
                  <div class="item">
                    <img src="assets/img/banner-october-2012.jpg" alt="">
                    <div class="carousel-caption">
                      <h4>Shadow of the Mad Kind</h4>
                       <p>Halloween has a long history in Tyria, and in times past was always marked by the spirit of Mad King Thorn cavorting among the people unleashing his own brand of insanity. However, it’s been over 250 years since he was last seen, and for most people he is merely a figure of folklore. Despite this, rumors persist among the populace that something wicked this way comes.</p>
					  </div>
                  </div>
                </div>
                <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
                <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
              </div>
          </div>
	</div>

	<div class="topspacer"></div>
	<div class="row">
	<?php 
		//require_once 'config/db.php';
		//include 'classes/calendar.php';
		
		
		$page = $_GET['page'];
		$action = $_GET['action'];
		$page = strtolower($page);
		if (!$page) { $page="home"; };
		if (!$action) { $action="index"; }
		

		
		$path .= "include/$page/$action.php";
		if (file_exists($path)) {
			if ( $page == 'enlist' ) {
				
				include("include/$page/$action.php");
			} else {
				include($path);
			}
		} else  {
		include("include/notfound/index.php");
		}
		
	?>
	</div>
     <!-- Footer
      ================================================== -->
	 <br>
	  <div class="botspacer span12"></div>
      <footer class="footer">
	 
        <p class="pull-right"><a href="#">Back to top</a></p><br>
        <p>&copy; 2012 ArenaNet, Inc. All rights reserved.<br>
        All other trademarks are the property of their respective owners.</p>
      </footer>

    </div><!-- /container -->
	
   <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
	<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="assets/js/bootstrap-scrollspy.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
    <script src="assets/js/bootstrap-tooltip.js"></script>
    <script src="assets/js/bootstrap-popover.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
    <script src="assets/js/bootstrap-carousel.js"></script>
    <script src="assets/js/bootstrap-typeahead.js"></script>
    <script src="assets/js/bootstrap.js"></script>
	
<!-- FancyBox Javascript -->
<!-- Add mousewheel plugin (this is optional) -->
<script type="text/javascript" src="assets/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

<!-- Add fancyBox -->
<link rel="stylesheet" href="assets/fancybox/source/jquery.fancybox.css?v=2.1.3" type="text/css" media="screen" />
<script type="text/javascript" src="assets/fancybox/source/jquery.fancybox.pack.js?v=2.1.3"></script>

<!-- Optionally add helpers - button, thumbnail and/or media -->
<link rel="stylesheet" href="assets/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="assets/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
<script type="text/javascript" src="assets/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.5"></script>

<link rel="stylesheet" href="assets/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css" media="screen" />
<script type="text/javascript" src="assets/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

	<script type="text/javascript" src="http://static-ascalon.cursecdn.com/current/js/syndication/tt.js"></script>
<script type="text/javascript">
    $("[rel=tooltip]").tooltip();
	$('.carousel').carousel();
	$(".fancybox").fancybox();
    $('#myModal').modal();
</script>

  </body>
</html>
