<?php
/**
 *  This setup file should be included in the <head> of any HTML documents
 *  in WikiBlender
 *
 *
 **/

if( ! file_exists( dirname(__FILE__) . "/../BlenderSettings.php" ) )
	die( "BlenderSettings.php file not found. Create one per the WikiBlender README.md file" );

require_once dirname(__FILE__) . "/../BlenderSettings.php";

?><script type="text/javascript">


</script>