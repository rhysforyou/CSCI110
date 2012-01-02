<?php

function handleError() {
  header("Location: errors.html");
}

// Ensure the user submitted valid data
$cats  = $_POST["categories"];
$vals  = $_POST["values"];
$title = $_POST["title"];

if (empty($cats) || empty($vals) || empty($title)) {
  handleError();
}

$categories = split("\n", $cats);
$values     = split("\n", $vals);

$numc = count($categories);
$numv = count($values);

// We should have a value for each category
if ($numc != $numv) {
  handleError();
}

// No more than 10 entries
if ($numc < 1 || $numc > 10) {
  handleError();
}

// Check the values with regexes
$numpat = '/^[0-9]+\.?[0-9]*$/';
$catpat = '/^[A-Za-z0-9 ]+$/';

for ($i = 0; $i < $numc; $i++) {
  $tmpc = rtrim($categories[$i]);
  $tmpv = rtrim($values[$i]);
  if(!preg_match($catpat, $tmpc)) { handleError(); }
  if(!preg_match($numpat, $tmpv)) { handleError(); }
}

$titlepat = '/^[A-Za-z0-9;, ]+$/';
if (!preg_match($titlepat, $title)) {
  handleError();
}

header("Content-type: image/png");
$width = 1000;
$height = 700;
$im = imagecreate($width, $height);
imageantialias($im, true);

$white = imagecolorallocate($im, 255, 255, 255);
$black = imagecolorallocate($im, 0, 0, 0);

$color[] = imagecolorallocate($im, 220, 50, 47);
$color[] = imagecolorallocate($im, 211, 54, 130);
$color[] = imagecolorallocate($im, 108, 113, 196);
$color[] = imagecolorallocate($im, 38, 139, 210);
$color[] = imagecolorallocate($im, 42, 161, 152);
$color[] = imagecolorallocate($im, 133, 153, 0);
$color[] = imagecolorallocate($im, 0, 43, 54);
$color[] = imagecolorallocate($im, 147, 161, 161);
$color[] = imagecolorallocate($im, 181, 137, 0);
$color[] = imagecolorallocate($im, 203, 75, 22);

$fd = "/Library/Fonts/Tahoma.ttf";

$titlex = 10;
$titley = 50;
$titleangle = 0;
$ftsize = 32;

imagettftext($im, $ftsize, $titleangle, $titlex, $titley, $black, $fd, $title);

$total = 0;
for ($i = 0; $i < $numv; $i++) {
  $tmpv = rtrim($values[$i]);
  $total += $tmpv;
}

$angles = array();
for ($i = 0; $i < $numv; $i++) {
  $tmpv = rtrim($values[$i]);
  $anangle = ($tmpv * 360) / $total;
  $angles[] = $anangle;
}

$cx = 250;
$cy = 250;
$cwidth = 255;
$cheight = 255;
$startangle = 0;

for ($i = 0; $i < $numv; $i++) {
  $endangle = $startangle + $angles[$i];
  $arccolor = $color[$i];
  imagefilledarc($im, $cx, $cy, $cwidth, $cheight, $startangle, $endangle, $arccolor, IMG_ARC_PIE);
  $startangle = $endangle;
}

$left = 450;
$top  = 120;
$step = 36;
$ptsize = 20;
$angle = 0;

for ($i = 0; $i < $numc; $i++) {
  $str = rtrim($categories[$i]);
  $txtcolor = $color[$i];
  imagettftext($im, $ptsize, $angle, $left, $top, $txtcolor, $fd, $str);
  $top += $step;
}

imagepng($im);
imagedestroy($im);

?>
