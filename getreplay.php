<?php
require "constants.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$ReplayCount = 0;

$scanned_dir = array_diff(scandir(URL_REPLAY), array('..', '.'));
$replays = "";
$replays = preg_grep('~\.(mp4)$~',$scanned_dir);
$ReplayCount = count($replays);
echo $ReplayCount;
?>

