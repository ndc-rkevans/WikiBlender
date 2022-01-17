 <!DOCTYPE html>
<html>
  <head>
    <?php echo WikiBlender::htmlHeader(); ?>
    <title><?php echo WikiBlender::get_title(); ?></title>
    <?php echo WikiBlender::getResource( 'jquery.min.js' ); ?>
    <?php echo WikiBlender::getResource( 'jquery-ui.min.js' ); ?>
    <?php echo WikiBlender::getResource( 'masonry.pkgd.min.js' ); ?>
    <?php echo WikiBlender::getResource( 'WikiBlender.js' ); ?>
    <?php echo WikiBlender::getResource( 'underscore-min.js' ); ?>
	<link rel="shortcut icon" href="<?php echo WikiBlender::$blenderFavicon; ?>">
    <?php echo WikiBlender::getResource( 'jquery-ui.min.css' ); ?>
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
  	<?php

		if ( isset( $_GET['invalidwiki'] ) ) {
			$invalidWiki = $_GET['invalidwiki'];
			echo "<div style='font-size: 24px; text-align: center; line-height: 600%; color: #a94442; background-color: #f2dede; border-radius: 4px; margin: 40px;'>
					Sorry, but \"$invalidWiki\" is not a valid wiki. Please try one of the wikis below.
				</div>";
		}
  	?>
	<h1 id="first-heading"><?php echo WikiBlender::get_title(); ?></h1>
	<p id="subtitle" style='font-size: 2.1em;'>
		<a href='https://revansx.net/social/'><span style='font-weight:bold;border:1px solid #e0e0e0;border-radius:9px;background-color:#f0f0f0;padding:3px 12px 3px 12px;'>./Social</span></a>
		&nbsp;
		<a href='https://revansx.net/photos/'><span style='font-weight:bold;border:1px solid #e0e0e0;border-radius:9px;background-color:#f0f0f0;padding:3px 12px 3px 12px;'>./Photos</span></a>
		&nbsp;
	  	<a href='https://revansx.net/learn/'><span style='font-weight:bold;border:1px solid #e0e0e0;border-radius:9px;background-color:#f0f0f0;padding:3px 12px 3px 12px;'>./Learing</span></a>
		&nbsp;
		<span style='font-weight:bold;border:1px solid #e0e0e0;border-radius:9px;padding:3px 12px 3px 12px;'>./Wikis (see below)</span>
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
