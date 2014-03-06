<!DOCTYPE html>
<html>
  <head>
    <?php echo WikiBlender::htmlHeader(); ?>
	<title><?php echo WikiBlender::get_title(); ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<!--<script src="masonry.pkgd.min.js"></script>-->
	<script src="WikiBlender/rc.js"></script>
	<script src="WikiBlender/WikiBlender.js"></script>

    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/cupertino/jquery-ui.min.css" rel="stylesheet" type="text/css" />
    <link href="WikiBlender/rc.css" rel="stylesheet" type="text/css" />
	<link href="WikiBlender/WikiBlender.css" rel="stylesheet" type="text/css" />

	<script>

		$(document).ready(function(){
			WikiBlender.tooltipAllTitles();
		
			// $(".tooltip").tooltip({
				// content: function() {
					// return $(this).attr('title');
				// }
			// });
		
			// $(".num-articles").each( WikiBlender.getWikiStats );
			
			// var container = document.querySelector('#masonry-container');
			// var msnry = new Masonry( container, {
				// columnWidth: 250,
				// isFitWidth : true
			// });

		});		

    </script>
  </head>
  <body>
	<h1><?php echo WikiBlender::get_title(); ?></h1>
	<h2>Recent Changes</h2>
    <div id="container">
		<table class="changes">
			<tr>
				<th></th>
				<th>Title</th>
				<th>User</th>
				<th>Time</th>
			</tr>
		</table>
		<?php echo WikiBlender::getFooter(); ?>
	</div>
  </body><?php
  
?></html>