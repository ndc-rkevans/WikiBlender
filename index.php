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
	<script src="masonry.pkgd.min.js"></script>

    <link href="jquery-ui.css" rel="stylesheet" type="text/css" />
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
	<style>
		body { font-family: sans-serif; }
		#container { text-align: center; }
		#masonry-container { text-align: center; margin: 50px auto 30px auto; }
		h1 { text-align:center; }
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
			margin-bottom: 50px;
			font-size:11px;
			font-weight:normal;
			clear:left;
		}
		.ui-tooltip {
			font-size: 12px;
		}
		table {
			margin:0 auto 0 auto;
			
		}
		table td {
			padding: 10px;
			text-align: center;
		}
		.wiki-block {
			width: 250px;
			height: 250px;
			display: inline-block;
			float: left;
		}
	</style>
  </head>
  <body>
	<h1><?php echo $title; ?></h1>
    <div id="container">
		
		<div id="masonry-container">

			<?php
				$wikis = array(
					array(
						"path"     => "mod", 
						"name"     => "MOD", 
						"articles" => 999
					),
					array(
						"path"     => "eva", 
						"name"     => "EVA", 
						"articles" => 2000
					),
					array(
						"path"     => "MissionSystems", 
						"name"     => "Mission Systems", 
						"articles" => 1000
					),
					array(
						"path"     => "ROBO", 
						"name"     => "ROBO", 
						"articles" => 600
					),
				);
				$jscmod_path = "extensions/JSCMOD/Groups";
				foreach($wikis as $wiki):
					$path = $wiki['path'];
					$name = $wiki['name'];
					$articles = $wiki['articles'];
			?>
			<div class='wiki-block'>
				<a href="<?php echo $path; ?>"><img src="<?php echo "$path/$jscmod_path/$path/logo.png"; ?>" /></a>
				<a href="<?php echo $path; ?>"><h3><?php echo $name; ?></h3></a>
				<p class="<?php echo $path; ?>-num-articles num-articles">Loading wiki data...</p><script>
					$.getJSON(
						"<?php echo $server . $path; ?>/api.php",
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

		
		<!--<span style="font-style:italic;">
			More wikis to come...<span class="fakelink" style="font-weight:bold;" title="Other groups have expressed interest in having their own Semantic Wikis. Right now we're trying to perfect the model before further expansion.">maybe...</span>
		</span>-->
		
		<div id="footer">
			<a href="http://modspops.jsc.nasa.gov/mod/default.aspx">MOD Home</a> | 
			<a href="http://www.jsc.nasa.gov/policies.html">Web Policy</a> |
			<span title="Responsible NASA Official">RNO: <a href="mailto:timothy.a.hall@nasa.gov">Tim Hall</a></span> |
			<a href="mailto:edwin.j.montalvo@nasa.gov;lawrence.d.welsh@nasa.gov;scott.wray-1@nasa.gov;brian.k.alpert@nasa.gov;costa.mavridis@nasa.gov;stephanie.s.johnston@nasa.gov" title="James Montalvo<br />Daren Welsh<br />Scott Wray<br />Stephanie Johnston<br />Costa Mavridis<br />Brian Alpert">Administrators</a>
		</div>
		
	</div>
	<!-- 
		<div class="wiki-title">
	-->
  </body><?php
  
?></html>