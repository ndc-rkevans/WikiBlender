/* 

ORDER OF OPERATIONS:
1) See if they are able to view the wiki
2) Pull the namespaces for that wiki
3) Pull the changes for that wiki

*/

var combinedRecentChanges = {
	
	initiate : function () {
		
		for (var dir in WikiBlenderWikis) {
			this.getSiteInfo( dir );
		}
		
	},
	
	getSiteInfo : function ( siteDirectory ) {
		var self = this;
		
		$.getJSON(
			WikiBlenderServer + siteDirectory + "/api.php",
			{
				action : "query",
				meta : "siteinfo",
				siprop : "general|namespaces",
				format : "json"
			},
			function ( response ) {
				WikiBlenderWikis[siteDirectory].namespaces = response.query.namespaces;
				WikiBlenderWikis[siteDirectory].mainpage = response.query.general.mainpage;
				WikiBlenderWikis[siteDirectory].sitename = response.query.general.sitename;
				WikiBlenderWikis[siteDirectory].server = response.query.general.server;
				WikiBlenderWikis[siteDirectory].articlepath = response.query.general.articlepath;
				self.getSiteRecentChanges( siteDirectory );
			}
		);
	
	},
	
	// FIXME: Doesn't correct for GMT offset...
	getCurrentTimestampString : function () {
		var todayStart = new Date();
		
		var year = todayStart.getFullYear().toString();
		
		var month = todayStart.getMonth()+1;
		if (month < 10)
			month = "0"+month;
		else
			month = month.toString();
		
		var day = todayStart.getDate();
		if (day < 10)
			day = "0"+day;
		else
			day = day.toString();
		
		return year + month + day + "000000";
		
	},
	
	getSiteRecentChanges : function ( siteDirectory ) {
		var self = this;
		
		$.getJSON(
			WikiBlenderServer + siteDirectory + "/api.php",
			{
				action : "query",
				list : "recentchanges",
				rcprop : "user|comment|parsedcomment|timestamp|title|ids|sha1|sizes|redirect|patrolled|loginfo|flags",
				format : "json",
				rcend : this.getCurrentTimestampString(), // FIXME: Doesn't correct for GMT offset...
				rclimit : 150
			},
			function( response ) {
				self.handleSiteRecentChanges( response, siteDirectory );
			}
		);
	
	},
	
	handleSiteRecentChanges : function ( jsonResponse, siteDirectory ) {
	
		var c, title, user, ns, timestamp, comment;
		var changes = jsonResponse.query.recentchanges;
		var wiki = WikiBlenderWikis[siteDirectory];
		
		for (var i=0; i<changes.length; i++) {
			// c = changes[i];
			
			// title = $("<a>")
				// .text(c.title)
				// .attr("href",wiki.server+wiki.articlepath.replace( "$1", c.title.replace(" ","_") ) );
			// user = c.user;
			// timestamp = c.timestamp;
			// comment = c.comment;


			var rows = $("tr.change-row");
		
			// var newRow = $("<tr><td>" + wiki.sitename + "</td><td>" + title + "</td><td>" + user + "</td><td class='timestamp'>" + timestamp + "</td><td>" + comment + "</td></tr>");
			var newRow = this.buildChangesRow(changes[i], siteDirectory);
	
			if (rows.size() > 0) {
				rows.each(function(index,element){
					var rowTime = $(element).find('.timestamp').first().attr("timestamp");
					
					// c is newer than this row
					if ( changes[i].timestamp > rowTime ) {
						$(element).before( newRow );
						return false; // break out of $.each
					}
					// this is the last row, so insert after
					else if ( index === rows.size() - 1) {
						// console.log( 'last row insert' );
						$(element).after( newRow );
						return false;
					}
					else
						return true; //continue $.each
				});
			}
			else {
				$(".changes").append( newRow );
			}
		}
	
	
	},
	
	buildChangesRow : function ( change, siteDirectory ) {
		
		var wiki = WikiBlenderWikis[siteDirectory];
		
		// if (change.type != "edit")
			// console.log(change.type);
			
		var titleTD = $("<td>").append(
			$("<div>")
				.text( wiki.sitename )
				.addClass( "sitename" )
		);
			
		if (change.type == "new")
			titleTD.append(
				$("<span>new page</span>")
					.addClass('change-type-text')
			);
			
		titleTD.append(		
			$("<a>")
				.text(change.title)
				.addClass("article")
				.attr(
					"href",
					wiki.server + wiki.articlepath.replace(
						"$1",
						encodeURIComponent( change.title.replace(/ /gi,"_") )
					)
				)
		);
		
		if (change.comment)
			titleTD.append(
				$("<span class='comment'>")
					.text(change.comment.length>50 ? change.comment.slice(0,50)+". . . " : change.comment)
			);
	
		var commentLength = 50;
		var commentTD = $("<td>").addClass("comment");
		
		// if (change.comment.length > commentLength) {
			// var shortComment = change.comment.slice(0,commentLength) + " . . . ";
			// commentTD.append(
				// $("<span>").text( shortComment ),
				// $("<a href='javascript:void(0);'>").text("more").addClass("show-hide-comment").click(function(){
					// if ( $(this).text() == "more" ) {
						// $(this).prev().text( change.comment );
						// $(this).text( "less" );
					// }
					// else {
						// $(this).prev().text( shortComment );
						// $(this).text("more");
					// }
				// })
			// );
		// }
		// else {
			// commentTD.text( change.comment );
		// }
		
		var tooltip = "";
		for (var c in change) {
			tooltip += "<strong>" + c + ":</strong> " + change[c] + "<br />";
		}
		
	
		return $("<tr>")
			.append(
				$("<td>").addClass("color"),
				titleTD,
				$("<td>").text(change.user),
				$("<td>").text( this.timeDiff(change.timestamp) ).addClass("timestamp").attr("timestamp", change.timestamp)
				//,commentTD
			)
			.addClass(siteDirectory + " change-row change-type-" + change.type)
			.attr("title", tooltip) //change.comment || "no comment")
			.tooltip({
				track : true,
				content: function() {
					return $(this).attr('title');
				}
			});
	
	


	},
	
	timeDiff : function(dateString) {
		var units = [
			{ unit : "millisecond", singulararticle : "a",  mod : 1000 }, // mod => modulus
			{ unit : "second",      singulararticle : "a",  mod : 60   },
			{ unit : "minute",      singulararticle : "a",  mod : 60   },
			{ unit : "hour",        singulararticle : "an", mod : 24   },
			{ unit : "day",         singulararticle : "a",  mod : 365  },
			{ unit : "year",        singulararticle : "a",  mod : 1000 }  // mod of 1000 arbitrarily big
		];

		var diff = Date.now() - Date.parse(dateString);

		for (var t=0; t<units.length; t++) {
			units[t].val = diff % units[t].mod;
			diff = Math.floor(diff / units[t].mod);
			if (diff == 0)
				break;
		}
		if (t == units.length)
			t = units.length - 1;
		// units.endedOn = t;
		// console.log(units);
		
		if ( t > 1 ) {
			var out = 
				  (units[t].val == 1 ? units[t].singulararticle : units[t].val)
				+ " " 
				+ (units[t].val > 1 ? units[t].unit+"s" : units[t].unit) 
				+ " ago";
		}
		else
			var out = "less than a minute ago";
		
		return out;
	},
	
	timeDiffRefresh : function() {
		var self = this;
		$(".timestamp").each(function(index,element){
			$(element).text( self.timeDiff($(element).attr("timestamp")) );
		});
	}

};


$(document).ready(function(){

	combinedRecentChanges.initiate();

});