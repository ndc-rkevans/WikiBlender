<?php



class WikiBlender {

	static $title = "Default Title";
	static $server;
	static $wikis;
	static $footer_links = array();
	static $admins = array();
	static $allowed_views = array(
		'RecentChanges',
		'Admin',
	);


	public static function execute () {

		require_once dirname(__FILE__) . "/../BlenderSettings.php";

		if ( isset($blenderTitle) )
			self::$title = $blenderTitle;

		if ( isset($blenderServer) )
			self::$server = $blenderServer;
		else
			die("Please add a server to your BlenderSettings file");

		if ( isset($blenderWikis) )
			self::$wikis = $blenderWikis;
		else
			die("Please add at least one wiki to your BlenderSettings file");

		if ( isset($blenderFooterLinks) )
			self::$footer_links = $blenderFooterLinks;

		if ( isset($blenderAdmins) )
			self::$admins = $blenderAdmins;

		if ( isset($_GET['v']) && in_array($_GET['v'], self::$allowed_views) ) {
			require_once dirname(__FILE__) . '/' . $_GET['v'] . '.php';
		}
		else {
			require_once dirname(__FILE__) . '/Landing.php';
		}

	}

	public static function get_title() {  return self::$title; }
	public static function get_server() { return self::$server; }
	public static function get_wikis() {  return self::$wikis; }


	public static function htmlHeader () {
		$server = self::$server;

		$js_wiki = array();
		foreach(self::get_wikis() as $wiki) {
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

	public static function getWikiSiteInfo ( $wiki ) {
		if ( ! is_dir( __DIR__ . "/../wikis/$wiki" ) ||
			 ! is_dir( __DIR__ . "/../wikis/$wiki/config" )
		) {
			return false;
		}


		include __DIR__ . "/../wikis/$wiki/config/setup.php";
		if ( isset( $wgSitename ) ) {
			$name = $wgSitename;
		} else {
			$name = "No name";
		}

		return array(
			'path' => $wiki,
			'name' => $name,
			'logo' => "wikis/$wiki/config/logo.png"
		);

	}


}