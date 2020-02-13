<?php
require "constants.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$LivesCount = 0;

$scanned_dir = array_diff(scandir(URL_HLS), array('..', '.'));
$streams = "";
$streams = preg_grep('~\.(m3u8)$~',$scanned_dir);
$LivesCount = count($streams);
echo $LivesCount;
?>

