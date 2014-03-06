<!DOCTYPE html>
<html>
  <head> 
    <?php require_once dirname(__FILE__) . "/WikiBlender/setup.php"; ?>
    <title><?php echo $blenderTitle; ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script src="masonry.pkgd.min.js"></script>
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/cupertino/jquery-ui.min.css" rel="stylesheet" type="text/css" />
    <link href="WikiBlender/WikiBlender.css" rel="stylesheet" type="text/css" />
	<script>
		$(document).tooltip({
			content: function() {
				return $(this).attr('title');
			}
		});
		
		$(document).ready(function(){
			var container = document.querySelector('#masonry-container');
			var msnry = new Masonry( container, {
				columnWidth: 250,
				isFitWidth : true
			});
		});
    </script>
  </head>
  <body>
	<h1><?php echo $blenderTitle; ?></h1>
    <div id="container">
		
		<div id="masonry-container">

			<?php
				
			foreach($blenderWikis as $wiki):
				$path = $wiki['path'];
				$name = $wiki['name'];
				$logo = $wiki['logo'];
			?>
			<div class='wiki-block'>
				<a href="<?php echo $path; ?>"><img src="<?php echo $logo; ?>" /></a>
				<a href="<?php echo $path; ?>"><h3><?php echo $name; ?></h3></a>
				<p class="<?php echo $path; ?>-num-articles num-articles">Loading wiki data...</p><script>
					$.getJSON(
						"<?php echo $blenderServer . $path; ?>/api.php",
						{
							action : "query",
							meta : "siteinfo",
							siprop : "statistics",
							format : "json"
						},
						function (response) {
							var stats = response.query.statistics;
							var path = "<?php echo $path; ?>";
							$("." + path + "-num-articles").html(
								stats.articles + " articles, " + 
								stats.images + " uploaded files<br />" +
								stats.views + " views, " +
								stats.edits + " edits<br />" +
								stats.activeusers + " active contributors"
							);
						}
					);
				</script>
			</div>
			<?php endforeach; ?>
		</div>
		<?php include dirname(__FILE__) . "/WikiBlender/footer.php"; ?>
	</div>
  </body>
</html>