<!DOCTYPE html>
<html>
  <head>
    <?php echo WikiBlender::htmlHeader(); ?>
    <title><?php echo WikiBlender::get_title(); ?></title>
    <?php echo WikiBlender::getResource( 'jquery.min.js' ); ?>
    <?php echo WikiBlender::getResource( 'jquery-ui.min.js' ); ?>
    <?php echo WikiBlender::getResource( 'jquery-ui.min.css' ); ?>
    <?php echo WikiBlender::getResource( 'WikiBlender.css' ); ?>

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
							content += "<span style='font-weight: bold; color: red;'><br />Job Queue: " + response.query.statistics.jobs + "</span>";

						//begin table of people
						//begin 1st list of people
						content += "<div>";

						//begin list of admins
						content += "<div style='width: 50%; float: left;' id='adminlist-" + info.wikiid + "'>";
						content += "<br />Admins:<br />";
						content += "</div>";

						//query API for admins
						var apiURL = info.server + info.scriptpath + "/api.php"
						$.getJSON(
							apiURL,
							{
								action:  "query",
								list:    "allusers",
								augroup: "sysop",
								aulimit: 500,
								format:  "json"

							},
							function( response ) {
								var members = response.query.allusers;
						        var userList = '';
						        var userString;
						        var wikiID = "#adminlist-" + info.wikiid;
								for(var i = 0; i < members.length; i++) {
									userString = members[i].name + " (User #" + members[i].userid + ")";
						            userList += "<li>" + userString + "</li>";
						        }
								$(wikiID).append( "<ul style='margin: 0px;'>" + userList + "</ul>" );
							}
						);//end list of admins

						//begin list of bureaucrats
						content += "<div style='margin-left: 50%;' id='bureaucratlist-" + info.wikiid + "'>";
						content += "<br />Bureaucrats:<br />";
						content += "</div>";

						//query API for bureaucrats
						var apiURL = info.server + info.scriptpath + "/api.php"
						$.getJSON(
							apiURL,
							{
								action:  "query",
								list:    "allusers",
								augroup: "bureaucrat",
								aulimit: 500,
								format:  "json"

							},
							function( response ) {
								var members = response.query.allusers;
						        var userList = '';
						        var userString;
						        var wikiID = "#bureaucratlist-" + info.wikiid;
								for(var i = 0; i < members.length; i++) {
									userString = members[i].name + " (User #" + members[i].userid + ")";
						            userList += "<li>" + userString + "</li>";
						        }
								$(wikiID).append( "<ul style='margin: 0px;'>" + userList + "</ul>" );
							}
						);//end list of bureaucrats

						//end 1st list of people
						content += "</div>";
						//begin 2nd list of people
						content += "<div>";

						//begin list of curators
						content += "<div style='width: 50%; float: left;'  id='curatorlist-" + info.wikiid + "'>";
						content += "</div>";

						//query API for curators
						var apiURL = info.server + info.scriptpath + "/api.php"
						$.getJSON(
							apiURL,
							{
								action:  "query",
								list:    "allusers",
								augroup: "Curator",
								aulimit: 500,
								format:  "json"

							},
							function( response ) {
								var members = response.query.allusers;
						        var userList = '';
						        var userString;
						        var wikiID = "#curatorlist-" + info.wikiid;
								for(var i = 0; i < members.length; i++) {
									userString = members[i].name + " (User #" + members[i].userid + ")";
						            userList += "<li>" + userString + "</li>";
						        }
						        if( response.warnings ){ } else {
						        	if ( userString.length > 0 ){
						        		$(wikiID).append( "<br />Curators:<br /><ul style='margin: 0px;'>" + userList + "</ul>" );
						        	}
						        };
							}
						);//end list of curators

						//begin list of beta-testers
						content += "<div style='margin-left: 50%;'  id='beta-testerslist-" + info.wikiid + "'>";
						content += "</div>";

						//query API for beta-testers
						var apiURL = info.server + info.scriptpath + "/api.php"
						$.getJSON(
							apiURL,
							{
								action:  "query",
								list:    "allusers",
								augroup: "Beta-tester",
								aulimit: 500,
								format:  "json"

							},
							function( response ) {
								var members = response.query.allusers;
						        var userList = '';
						        var userString;
						        var wikiID = "#beta-testerslist-" + info.wikiid;
								for(var i = 0; i < members.length; i++) {
									userString = members[i].name + " (User #" + members[i].userid + ")";
						            userList += "<li>" + userString + "</li>";
						        }
						        if( response.warnings ){ } else {
						        	$(wikiID).append( "<br />Beta-Testers:<br /><ul style='margin: 0px;'>" + userList + "</ul>" );
						        };
							}
						);//end list of beta-testers

						//end 2nd list of people
						content += "</div>";
						//end table of people

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
