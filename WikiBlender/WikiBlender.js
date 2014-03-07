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
				var userCounts = []
				for(var u in allusers) {
					userCounts.push( "<li>" + allusers[u].name + " : " + allusers[u].recenteditcount + "</li>" );
				}
				userCounts = userCounts.join("");
				userCounts = "<h4>User edits in last 30 days</h4><ol>" + userCounts + "</ol>";
				console.log(userCounts);
				
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
	},
	
};