<?php
require "constants.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



//$dir    = '/usr/local/nginx/tmp/hls/';
$scanned_dir = array_diff(scandir(URL_REPLAY), array('..', '.'));
$replays = "";
$replays = preg_grep('~\.(mp4)$~',$scanned_dir);
$names="";

foreach($replays as $r)
{
	$val=substr($r, 0, strrpos($r, "."));
	$names = $names.$val.';';
}
 	echo $names;
?>
