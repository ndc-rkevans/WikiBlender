<?php
error_reporting( -1 );
ini_set( 'display_errors', 1 );
ini_set( 'log_errors', 1 );
ini_set( 'error_log', __DIR__ . '/php.log' );

$blenderTitle = "NASA Semantic Wikis";

$blenderServer = "https://fod2-dev.jsc.nasa.gov/wiki/";

$blenderScriptPath = '/Wiki/WikiBlender';

$blenderFavicon = '/wiki/wikis/meta/config/favicon.ico';

$blenderWikisDir = __DIR__ . '/../wikis';

$blenderHeaderWikiTitle = 'Open access wikis';
$blenderHeaderWikis = array( 'fod' );

$blenderMiddleWikiTitle = 'Closed access wikis';

$blenderFooterWikiTitle = false;
$blenderFooterWikis = array( 'meta' );

$blenderFooterLinks = array(
	"<a href='http://modspops.jsc.nasa.gov/mod/default.aspx'>FOD Home</a>",
	"<a href='http://www.jsc.nasa.gov/policies.html'>Web Policy</a>",
	"<span title='Responsible NASA Official'>RNO: <a href='mailto:timothy.a.hall@nasa.gov'>Tim Hall</a></span>",
);

$blenderAdmins = array(
	"edwin.j.montalvo@nasa.gov" => "James Montalvo",
	"lawrence.d.welsh@nasa.gov" => "Daren Welsh",
	"scott.wray-1@nasa.gov" => "Scott Wray",
	"stephanie.s.johnston@nasa.gov" => "Stephanie Johnston",
	"costa.mavridis@nasa.gov" => "Costa Mavridis",
	"brian.k.alpert@nasa.gov" => "Brian Alpert",
);
