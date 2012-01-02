<!DOCTYPE html>
<html>
<head>
	<title>Fortunes Lol</title>
	<?php
	$fortunes = array(
		"Lol fortune",
		"We're officially broken up for 10 minutes, we can speak again after  11:15:05 AM.",
		"<pre> _____ \n( FML )\n ----- \n        o   ^__^\n         o  (oo)\_______\n            (__)\       )\/\\\n                ||----w |\n                ||     ||</pre>",
		"<img src=\"http://i.imgur.com/o0GQK.gif\" />"
	);

	$numFortunes = count($fortunes);

	function todaysFortune()
	{
		global $numFortunes;
		global $fortunes;

		$which = rand(0, $numFortunes-1);
		return $fortunes[$which];
	}
	?>
</head>
<body>
	<h1>G'day</h1>
	<p>Did you know this?</p>
	<?php
	$msg = todaysFortune();
	echo "<p>" . $msg . "</p>";
	?>
</body>
</html>