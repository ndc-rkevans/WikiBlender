<?php



class WikiBlender {

	static $title = "Default Title";
	static $server;
	static $wikis;
	static $footer_links = array();
	static $admins = array();
	static $allowed_views = array(
		'Admin',
	);
	static $blenderFavicon;
	static $blenderWikisDir;

	static $blenderScriptPath = '/WikiBlender';

	static $blenderExcludeWikis = array();

	static $blenderHeaderWikiTitle = false;
	static $blenderHeaderWikis;

	static $blenderMiddleWikiTitle = false;

	static $blenderFooterWikiTitle = false;
	static $blenderFooterWikis = array();

	static $headerWikis;
	static $middleWikis;
	static $footerWikis;

	public static function execute () {

		// require_once __DIR__ . "/DefaultSettings.php";
		require_once __DIR__ . "/../BlenderSettings.php";

		if ( isset( $blenderTitle ) ) {
			self::$title = $blenderTitle;
		}

		if ( isset($blenderServer) ) {
			self::$server = $blenderServer;
		} else {
			die("Please add a server to your BlenderSettings file");
		}

		if ( isset( $blenderScriptPath ) ) {
			self::$blenderScriptPath = $blenderScriptPath;
		}

		if ( isset( $blenderFooterLinks ) ) {
			self::$footer_links = $blenderFooterLinks;
		}

		if ( isset( $blenderAdmins ) ) {
			self::$admins = $blenderAdmins;
		}

		if ( isset( $blenderFavicon ) ) {
			self::$blenderFavicon = $blenderFavicon;
		} else {
			self::$blenderFavicon = '';
		}

		if ( isset( $blenderExcludeWikis ) ) {
			self::$blenderExcludeWikis = $blenderExcludeWikis;
		}

		if ( isset( $blenderHeaderWikiTitle ) ) {
			self::$blenderHeaderWikiTitle = $blenderHeaderWikiTitle;
		}
		if ( isset( $blenderHeaderWikis ) ) {
			self::$blenderHeaderWikis = $blenderHeaderWikis;
		}

		if ( isset( $blenderMiddleWikiTitle ) ) {
			self::$blenderMiddleWikiTitle = $blenderMiddleWikiTitle;
		}

		if ( isset( $blenderFooterWikiTitle ) ) {
			self::$blenderFooterWikiTitle = $blenderFooterWikiTitle;
		}

		if ( isset( $blenderFooterWikis ) ) {
			self::$blenderFooterWikis = $blenderFooterWikis;
		}

		if ( isset( $blenderWikisDir ) ) {
			self::$blenderWikisDir = $blenderWikisDir;
			self::getWikiList();
		} else {
			die("Please consult README for setup: no wikis found.");
		}

		if ( isset($_GET['v']) && in_array($_GET['v'], self::$allowed_views) ) {
			require_once __DIR__ . '/' . $_GET['v'] . '.php';
		} else {
			require_once __DIR__ . '/Landing.php';
		}

	}


	public static function getWikiSiteName ( $wikiId ) {
		include self::$blenderWikisDir . "/$wikiId/config/preLocalSettings.d/base.php";

		// Maintain legacy meza version of getting sitename
		if ( ! isset( $wgSitename ) ) {
			include self::$blenderWikisDir . "/$wikiId/config/preLocalSettings.php";
		}

		if ( isset( $wgSitename ) ) {
			return $wgSitename;
		} else {
			return "No name";
		}
	}

	// public static function getWikiSiteInfo ( $wiki ) {
	// 	if ( ! is_dir( self::$blenderWikisDir . "/$wiki" ) ||
	// 		 ! is_dir( self::$blenderWikisDir . "/$wiki/config" )
	// 	) {
	// 		return false;
	// 	}

	// 	include self::$blenderWikisDir . "/$wiki/config/setup.php";
	// 	if ( isset( $wgSitename ) ) {
	// 		$name = $wgSitename;
	// 	} else {
	// 		$name = "No name";
	// 	}

	// 	return array(
	// 		'path' => $wiki,
	// 		'name' => $name,
	// 		'logo' => "../wikis/$wiki/config/logo.png"
	// 	);

	// }

	public static function getWikiList () {

		if ( ! isset( self::$blenderWikisDir ) ) {
			return false;
		}

		// get list of $blenderWikisDir, remove first two directories . and ..
		$wikiDirs = array_slice( scandir( self::$blenderWikisDir ), 2 );

		$dir = self::$blenderWikisDir;

		// keep only directories, not files, in $blenderWikisDir
		$wikiDirs = array_filter( $wikiDirs, function( $wiki ) use ( $dir ) {
			return is_dir( "$dir/$wiki" );
		} );

		$headerWikis = array();
		$middleWikis = array();
		$footerWikis = array();
		foreach( $wikiDirs as $wiki ) {
			if ( in_array( $wiki, self::$blenderExcludeWikis ) ) {
				continue;
			}
			$wikiInfo = array(
				'path' => $wiki,
				'name' => self::getWikiSiteName( $wiki ),
				'logo' => "wikis/$wiki/config/logo.png"
			);
			if ( in_array( $wiki, self::$blenderHeaderWikis ) ) {
				$headerWikis[] = $wikiInfo;
			} elseif ( in_array( $wiki, self::$blenderFooterWikis ) ) {
				$footerWikis[] = $wikiInfo;
			} else {
				$middleWikis[] = $wikiInfo;
			}
		}

		self::$headerWikis = $headerWikis;
		self::$middleWikis = $middleWikis;
		self::$footerWikis = $footerWikis;
	}


	public static function get_title() {  return self::$title; }
	public static function get_server() { return self::$server; }


	public static function getHeaderWikiInfo () {  return self::$headerWikis; }
	public static function getMiddleWikiInfo () {  return self::$middleWikis; }
	public static function getFooterWikiInfo () {  return self::$footerWikis; }
	public static function getAllWikis () {
		return array_merge(
			self::getHeaderWikiInfo(),
			self::getMiddleWikiInfo(),
			self::getFooterWikiInfo()
		);
	}
	// public static function getHeaderWikiBlocks () {  return self::$headerWikis; }
	// public static function getMiddleWikiBlocks () {  return self::$middleWikis; }
	// public static function getFooterWikiBlocks () {  return self::$footerWikis; }
	public static function getWikiBlocks ( $section ) {
		if ( $section === 'header' ) {
			$wikis = self::getHeaderWikiInfo();
		} elseif ( $section === 'middle' ) {
			$wikis = self::getMiddleWikiInfo();
		} elseif ( $section === 'footer' ) {
			$wikis = self::getFooterWikiInfo();
		} else {
			die( 'Section must be header, middle, or footer' );
		}
		$output = '';
		foreach ( $wikis as $wiki ) {
			$output .= WikiBlender::getLandingPageWikiBlock( $wiki );
		}
		return $output;
	}


	public static function htmlHeader () {
		$server = self::$server;

		$js_wiki = array();
		foreach( self::getAllWikis() as $wiki ) {
			$path = $wiki["path"];
			$wiki_js_obj[] = "'$path':{}";
		}
		$wiki_js_obj = "{".implode(",",$wiki_js_obj)."}";

		return
			"<script type='text/javascript'>
				var WikiBlenderServer = '$server';
				var WikiBlenderWikis = $wiki_js_obj;
			</script>";
	}

	public static function getLandingPageWikiBlock ( $wiki ) {

		$path = $wiki['path'];
		$name = $wiki['name'];
		$logo = $wiki['logo'];

		return
			"<table class='wiki-block'>
				<tr><td>
					<a href='$path'>
						<img src='$logo' />
						<h3>$name</h3>
					</a>
				</td></tr>
				<tr><td class='num-articles' wikipath='$path'>Loading wiki data...</td></tr>
			</table>";
	}

	public static function getSectionTitle ( $section ) {
		if ( $section === 'header' ) {
			$sectionTitle = self::$blenderHeaderWikiTitle;
		} elseif ( $section === 'middle' ) {
			$sectionTitle = self::$blenderMiddleWikiTitle;
		} elseif ( $section === 'footer' ) {
			$sectionTitle = self::$blenderFooterWikiTitle;
		} else {
			die( 'Section title must be header, middle, or footer' );
		}

		if ( $sectionTitle ) {
			return "<h2 style='clear:both;'>$sectionTitle</h2>";
		} else {
			return '';
		}
	}


	public static function getFooter () {
		if ( count(self::$footer_links) == 0 )
			return "";

		$links = self::$footer_links;

		if ( count(self::$admins) !== 0 )
			$links[] = self::getAdminEmails();

		$links = implode(' | ', $links);

		return "<div id='footer'>$links</div>";
	}

	public static function getAdminEmails () {
		foreach (self::$admins as $email => $fullname) {
			$adminEmails[] = $email;
			$adminNames[] = $fullname;
		}
		$adminEmails = implode(';', $adminEmails);
		$adminNames = implode('<br />', $adminNames);
		return "<a href='mailto:$adminEmails' title='$adminNames'>Administrators</a>";
	}

	public static function getFavicon () {
		if ( self::$blenderFavicon ) {
			echo '<link rel="shortcut icon" href="' . self::$blenderFavicon . '">';
		} else {
			echo '';
		}
	}

	public static function getResource ( $file ) {
		$scriptPath = self::$blenderScriptPath;

		if ( pathinfo( $file, PATHINFO_EXTENSION ) === 'css' ) {
			return "<link href=\"$scriptPath/lib/$file\" rel=\"stylesheet\" type=\"text/css\" />";
		} else {
			return "<script src=\"$scriptPath/lib/$file\" type=\"text/javascript\"></script>";
		}
	}

}
