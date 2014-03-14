<!DOCTYPE html>
<html>
  <head> 
    <?php echo WikiBlender::htmlHeader(); ?>
    <title><?php echo WikiBlender::get_title(); ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script src="WikiBlender/masonry.pkgd.min.js"></script>
	<script src="WikiBlender/WikiBlender.js"></script>
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/cupertino/jquery-ui.min.css" rel="stylesheet" type="text/css" />
    <link href="WikiBlender/WikiBlender.css" rel="stylesheet" type="text/css" />
	<script>
		$(document).ready(function(){
			WikiBlender.tooltipAllTitles();
		
			$(".num-articles").each( WikiBlender.getWikiStats );
			
			var container = document.querySelector('#masonry-container');
			var msnry = new Masonry( container, {
				columnWidth: 250,
				isFitWidth : true
			});

		});		
    </script>
  </head>
  <body>
	<h1><?php echo WikiBlender::get_title(); ?></h1>
	<h4><a href="?v=RecentChanges">Combined Recent Changes</a> <sup>(beta)</sup></h4>
    <div id="container">
		
		<div id="masonry-container">
		<?php	
			foreach (WikiBlender::get_wikis() as $wiki) {
				echo WikiBlender::getLandingPageWikiBlock( $wiki );
			}	
		?>
		</div>
		
		<?php echo WikiBlender::getFooter(); ?>
	</div>
  </body>
</html>