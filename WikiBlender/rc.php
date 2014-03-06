<?php

$server = "https://" . $_SERVER["HTTP_HOST"] . "/wiki/"; 
if($_SERVER["HTTP_HOST"] == "mod-dev2.jsc.nasa.gov")
	$title = "DEVELOPMENT Wikis";
else
	$title = "MOD Semantic Wikis";
 
?><!DOCTYPE html>
<html>
  <head>
	<title><?php echo $title; ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<!--<script src="masonry.pkgd.min.js"></script>-->
	<script src="rc.js"></script>
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/cupertino/jquery-ui.min.css" rel="stylesheet" type="text/css" />
    <link href="rc.css" rel="stylesheet" type="text/css" />
	<script>
		$(".tooltip").tooltip({
			content: function() {
				return $(this).attr('title');
			}
		});
		
		// $(document).ready(function(){
			// var container = document.querySelector('#masonry-container');
			// var msnry = new Masonry( container, {
				// columnWidth: 250,
				// isFitWidth : true
			// });
		// });
    </script>
  </head>
  <body>
	<h1><?php echo $title; ?></h1>
    <div id="container">
		<table class="changes">
			<tr>
				<th></th>
				<th>Title</th>
				<th>User</th>
				<th>Time</th>
			</tr>
		</table>
	</div>
	<?php include dirname(__FILE__) . "/footer.php"; ?>
  </body><?php
  
?></html>