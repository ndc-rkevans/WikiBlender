var totalArticles = 0,
	totalImages = 0;
	totalViews = 0,
	totalEdits = 0,
	totalActiveUsers = [];

var WikiBlender = {

	getWikiStats : function( wikiIndex, articlesElement ) {

		var wikiPath = $(articlesElement).attr("wikipath");

		$.getJSON(
			WikiBlenderServer + wikiPath  + "/api.php",
			{
				// site statistics
				action : "query",
				meta : "siteinfo",
				siprop : "statistics",

				// active users
				list : "allusers",
				auactiveusers : "",
				aulimit : 500,

				format : "json"
			},
			function (response) {
				var compareUserActions = function (a,b) {
					if (a.recenteditcount < b.recenteditcount)
						return 1;
					if (a.recenteditcount > b.recenteditcount)
						return -1;
					return 0;
				};

				var stats = response.query.statistics;
				var allusers = response.query.allusers;

				allusers.sort( compareUserActions );
				var userCounts = [];
				for(var u in allusers) {
					userCounts.push( "<li>" + allusers[u].name + " : " + allusers[u].recenteditcount + " edits</li>" );
					if (userCounts.length > 9)
						break;
				}
				userCounts = userCounts.join("");
				userCounts = "<h4>Most active users - last 30 days</h4><ol>" + userCounts + "</ol>";

				$(articlesElement)
					.attr("title", userCounts)
					.html(
						stats.articles + " articles, " +
						stats.images + " uploaded files<br />" +
						stats.views + " views, " +
						stats.edits + " edits<br />" +
						allusers.length + " active contributors"
					)
					.tooltip({
						content : function() { return userCounts; }
					});

				totalArticles += stats.articles;
				totalImages += stats.images;
				totalViews += stats.views;
				totalEdits += stats.edits;

				for(var u in allusers) {
					totalActiveUsers.push( allusers[u].name );
				}
				totalActiveUsers = _.uniq( totalActiveUsers );

				$("#subtitle").html(
					"Across all wikis: " +
					totalArticles + " articles, " +
					totalImages + " uploaded files, " +
					totalViews + " views, " +
					totalEdits + " edits, " +
					totalActiveUsers.length + " unique editors in last 30 days"
				);


					// .append(
						// $("<span title='" + userCounts + "'>" + allusers.length + " active contributors<span>").tooltip({
							// content : function() { return userCounts; }
						// })
					// );
			}
		);

	},

	tooltipAllTitles : function () {
		$(document).tooltip({
			content: function() {
				return $(this).attr('title');
			}
		});
	}

};