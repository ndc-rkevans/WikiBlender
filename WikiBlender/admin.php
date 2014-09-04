<!DOCTYPE html>
<html>
  <head>
    <?php echo WikiBlender::htmlHeader(); ?>
    <title><?php echo WikiBlender::get_title(); ?></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/cupertino/jquery-ui.min.css" rel="stylesheet" type="text/css" />
	<link href="WikiBlender/WikiBlender.css" rel="stylesheet" type="text/css" />

	<script>
		$(document).tooltip({
			content: function() {
				return $(this).attr('title');
			}
		});
		
		$(document).ready(function(){

			var wikis = [];
			for(var w in WikiBlenderWikis) {
				wikis.push(w);
			}
			
			var api = "/api.php";

			for (var i=0; i<wikis.length; i++) {
			
				$.getJSON(
					WikiBlenderServer + wikis[i] + api,
					{
						action : "query",
						meta : "siteinfo",
						format : "json",
						siprop : "general|statistics"
					},
					function(response) {
						var info = response.query.general;
						
						var color = $("<td class='hash-color'>").css({
							"background-color" : "#" + info["git-hash"].slice(0,6)
						});
						
						
						var specialVersion = "<a href='" 
							+ info.server + info.script + "?title=Special:Version"
							+ "'>Special:Version</a>";
						
						var git = "<a href='https://git.wikimedia.org/commit/mediawiki%2Fcore.git/" 
							+ info["git-hash"] + "'>" + info["git-hash"].slice(0,6) + "</a>";
										
						var content = info.sitename + ": " + info.generator + " (" + git + ")" 
							+ "<br />"
							+ "<small>" + specialVersion;
						if (response.query.statistics.jobs > 0)
							content += "<br />Job Queue: " + response.query.statistics.jobs;
						content += "</small><br />";
						content = $("<td class='wiki-info'>").html(content);
			
						$("#versions").append(
							$("<tr>")
								.append(color)
								.append(content)
						);
					}
				);
			}
			
		});
    </script>
  </head>
  <body>
    <div id="container">
		<h1><?php echo WikiBlender::get_title(); ?></h1>
		<h2>MediaWiki Installations</h2>
		<table id="versions"></table>
		
		<?php echo WikiBlender::getFooter(); ?>
		
		<div style="text-align:left; margin-top: 40px;">
			<?php phpinfo(); ?>
		</div>
		
	</div>
	<!-- 
		<div class="wiki-title">
	-->
  </body><?php
  
?></html>