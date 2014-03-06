var WikiBlender = {

	getWikiStats : function( wikiIndex, articlesElement ) {
		
		var wikiPath = $(articlesElement).attr("wikipath");
	
		$.getJSON(
			WikiBlenderServer + wikiPath  + "/api.php",
			{
				action : "query",
				meta : "siteinfo",
				siprop : "statistics",
				format : "json"
			},
			function (response) {
				var stats = response.query.statistics;
				$(articlesElement).html(
					stats.articles + " articles, " + 
					stats.images + " uploaded files<br />" +
					stats.views + " views, " +
					stats.edits + " edits<br />" +
					stats.activeusers + " active contributors"
				);
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