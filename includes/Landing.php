<!DOCTYPE html>
<html>
  <head>
    <?php echo WikiBlender::htmlHeader(); ?>
    <title><?php echo WikiBlender::get_title(); ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <?php echo WikiBlender::getResource( 'masonry.pkgd.min.js' ); ?>
    <?php echo WikiBlender::getResource( 'WikiBlender.js' ); ?>
    <?php echo WikiBlender::getResource( 'underscore-min.js' ); ?>
	<link rel="shortcut icon" href="/wiki/wikis/meta/config/favicon.ico">
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/cupertino/jquery-ui.min.css" rel="stylesheet" type="text/css" />
    <?php echo WikiBlender::getResource( 'WikiBlender.css' ); ?>
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
    <div id="container">

    	<?php echo WikiBlender::getSectionTitle( 'header' ); ?>
		<div style="clear:both;" id='top-wikis'>
			<?php echo WikiBlender::getWikiBlocks( 'header' ); ?>
		</div>

    	<?php echo WikiBlender::getSectionTitle( 'middle' ); ?>
		<div style="clear:both;" id="masonry-container">
			<?php echo WikiBlender::getWikiBlocks( 'middle' ); ?>
		</div>

    	<?php echo WikiBlender::getSectionTitle( 'footer' ); ?>
		<div style="clear:both;" id='bottom-wikis'>
			<?php echo WikiBlender::getWikiBlocks( 'footer' ); ?>
		</div>

		<?php echo WikiBlender::getFooter(); ?>
	</div>
  </body>
</html>