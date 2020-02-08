<?php
require "constants.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);




$scanned_dir = array_diff(scandir(URL_HLS), array('..', '.'));
$streams = "";
$streams = preg_grep('~\.(m3u8)$~',$scanned_dir);
$names="";

foreach($streams as $s)
{
	$val=substr($s, 0, strrpos($s, "."));
	 $names = $names.$val.';';
}
 	echo $names;
?>
