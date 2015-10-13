<!DOCTYPE html>
<html>
  <head>
    <?php echo WikiBlender::htmlHeader(); ?>
    <title><?php echo WikiBlender::get_title(); ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script src="WikiBlender/masonry.pkgd.min.js"></script>
	<script src="WikiBlender/WikiBlender.js"></script>
	<script src="WikiBlender/underscore-min.js"></script>
	<link rel="shortcut icon" href="/wiki/wikis/meta/config/favicon.ico">
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/cupertino/jquery-ui.min.css" rel="stylesheet" type="text/css" />
    <link href="WikiBlender/WikiBlender.css?nocache=1" rel="stylesheet" type="text/css" />
	<script>
		$(document).ready(function(){
			WikiBlender.tooltipAllTitles();

			$(".num-articles").each( WikiBlender.getWikiStats );

			var container = document.querySelector('#masonry-container');
			var msnry = new Masonry( container, {
				columnWidth: 250,
				isFitWidth : true
			});

			var containerBottom = document.querySelector('#bottom-wikis');
			var msnryBottom = new Masonry( containerBottom, {
				columnWidth: 250,
				isFitWidth : true
			});

			var containerTop = document.querySelector('#top-wikis');
			var msnryTop = new Masonry( containerTop, {
				columnWidth: 250,
				isFitWidth : true
			});


		});
    </script>
  </head>
  <body>
	<h1 id="first-heading"><?php echo WikiBlender::get_title(); ?></h1>
	<p id="subtitle">Loading data...</p>
	<!-- <h4><a href="?v=RecentChanges">Combined Recent Changes</a> <sup>(beta)</sup></h4> -->
	<!-- <h4>This page is being updated to house more wikis. It may occasionally display some errors.</h4> -->
    <div id="container">

    	<h2>Open access wikis</h2>
		<div id='top-wikis'>
		<?php
			echo WikiBlender::getLandingPageWikiBlock( WikiBlender::getWikiSiteInfo( 'fod' ) );
		?>
		</div>

		<h2 style="clear:both;">Closed access wikis</h2>
		<div id="masonry-container">
		<?php
			foreach (WikiBlender::get_wikis() as $wiki) {
				echo WikiBlender::getLandingPageWikiBlock( $wiki );
			}
		?>
		</div>

		<div style="clear:both;" id='bottom-wikis'>
		<?php
			echo WikiBlender::getLandingPageWikiBlock( WikiBlender::getWikiSiteInfo( 'meta' ) );
		?>
		</div>

		<?php echo WikiBlender::getFooter(); ?>
	</div>
  </body>
</html>