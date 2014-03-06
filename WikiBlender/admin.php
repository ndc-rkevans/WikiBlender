<!DOCTYPE html>
<html>
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/cupertino/jquery-ui.min.css" rel="stylesheet" type="text/css" />
	<script>
		$(document).tooltip({
			content: function() {
				return $(this).attr('title');
			}
		});
		
		$(document).ready(function(){

			var host = "https://mod-dev2.jsc.nasa.gov/wiki/";
			var wikis = ["eva","robo","missionsystems","adco","mod"];
			var api = "/api.php";

			for (var i=0; i<wikis.length; i++) {
			
				$.getJSON(
					host + wikis[i] + api,
					{
						action : "query",
						meta : "siteinfo",
						format : "json"
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
						
						
						var content = $("<td class='wiki-info'>").html(
							info.sitename + ": " + info.generator + " (" + git + ")" 
							+ "<br />"
							+ "<small>" + specialVersion + "</small>"
						);
			
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
	<style>
		body { font-family: sans-serif; }
		#container { text-align: center; min-width: 768px;}
		h1 {}
		h2 {}
		h3 { margin:0;}
		h4 { margin:0; font-weight:normal; }
		
		
		a {
			text-decoration: none;
		}
		a:link, a:visited, a:hover, a:active, .fakelink {color:#0645AD; border:none;}
		img { border:none; }
		a:hover, .fakelink:hover { text-decoration:underline;}
		a.nounderline:hover { text-decoration:none; }
		a table:hover {
			background-color: #EEE;
		}
		
		p.num-articles { font-style:italic; font-size:80%; }
		p { margin: 0; }
		.wiki-title { text-align:center; }
		.logo-title-group div, .logo-title-group img, .logo-title-group h1 {
			display: inline-block;
			vertical-align: middle;
			margin: 0 10px 0 10px;
		}
		#container h1 {
		}
		#footer {
			margin-top: 50px;
			font-size:11px;
			font-weight:normal;
		}
		.ui-tooltip {
			font-size: 12px;
		}
		table#versions {
			margin:0 auto 0 auto;
			
		}
		table#versions td {
			padding: 10px;
			text-align: center;
		}
		
		table#versions {
			width : 500px;
			margin : 10px auto;
		}
		td.hash-color {
			height : 50px;
			width : 50px;
			margin : 5px;
		}
		td.wiki-info {
			text-align : left;
		}
	</style>
  </head>
  <body>
    <div id="container">
		
		<h2>MediaWiki Installations</h2>
		<table id="versions"></table>
		
		<?php include dirname(__FILE__) . "/footer.php"; ?>
		
		<div style="text-align:left; margin-top: 40px;">
			<?php phpinfo(); ?>
		</div>
		
	</div>
	<!-- 
		<div class="wiki-title">
	-->
  </body><?php
  
?></html>