<?php
include 'config.php';

if(!mysql_query("SELECT * FROM news")) {
	$csql = "CREATE TABLE `news` (
		`id` int(30) unsigned NOT NULL,
		`Title` varchar(64) NOT NULL,
		`Author` varchar(32) NOT NULL,
		`Content` varchar(4096) NOT NULL,
		`Date` datetime NOT NULL
  )";
  if(mysql_query($csql) === TRUE) {
    mysql_query("ALTER TABLE `news` ADD PRIMARY KEY (`id`)");
		mysql_query("ALTER TABLE `news` MODIFY `id` int(30) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11");
  } else {
		header('Content-type: text/plain');
		print ("Error: ".mysql_error);
		exit();
  }
}

if(!mysql_query("SELECT COUNT(*) FROM news")) {
  $counterror = "No news was found in the database.";
} else {
  $counterror = null;
  $max = 5;
  
  $countnews = mysql_query("SELECT COUNT(*) AS total FROM articles");
  $total = mysql_result($countnews, 0, 'total');
  
  $pages = (($total % $By['Page']) > 0) ? (int)($total / $max) + 1 : ($total / $max);
  
  if($total > 0) {
    for($totalp = 1; $totalp <= $pages; $totalp++) {
      $page = $totalp;
    }
  }
}
?>
<html>
  <head>
    <title>Simple Bootpag Pagination</title>
    
    <!-- Stylesheets -->
    <link rel="stylesheet" href="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">
    
    <!-- JQuery Bootpag -->
    <script src="//raw.github.com/botmonster/jquery-bootpag/master/lib/jquery.bootpag.min.js"></script>
  </head>
  <body>
    <div class="container">
      <h1 id="loading" style="display:none">Loading...</h1>
      <div class="blog-post" id="news">
        <h2 class="blog-post-title">Sample blog post</h2>
        <p class="blog-post-meta">January 1, 2014 by <a href="#">Mark</a></p>
        <p>This blog post shows a few different types of content that's supported and styled with Bootstrap. Basic typography, images, and code are all supported.</p>
        <hr>&copy; Llann Arcanist</hr>
      </div>
      <div id="pagination"></div>
    </div>
    
    <!-- JQuery AND Bootstrap -->
    <script src="http://code.jquery.com/jquery-2.1.3.min.js"></script>
    <script src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

    <!-- Bootpag Settings -->
    <script> 
      $("#news").load("paginate.php");
      $('#pagination').bootpag({
        total: '<?php echo($page); ?>',
        maxVisible:5,
        leaps: false,    
        firstLastUse: true,
        first: '←',
        last: '→',
        wrapClass: 'pagination',
        activeClass: 'active',
        disabledClass: 'disabled',
        nextClass: 'next',
        prevClass: 'prev',
        lastClass: 'last',
        firstClass: 'first'
      }).on("page", function(event, num){
        event.preventDefault();
        $("#news").hide();
        $("#loading").show();
        $("#pagination").hide();
        $("#news").load("paginate.php?page=" + num, function() {
          $(this).ready(function(){
            $("#loading").hide();
            $("#news").show();
            $("#pagination").show();
          });
        });
      });
    </script>
  </body>
</html>
