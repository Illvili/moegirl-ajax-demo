<?php

$is_win = 'WINNT' == PHP_OS;
$pjax = true;
if (!isset($_SERVER['HTTP_X_PJAX'])) {
	$pjax = false;
	echo <<< EOS
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Moegirl</title>
</head>
<body>
	<h1>Moegirl Ajax Load</h1>
	<a href="./Mainpage" pjax="on">Mainpage</a>
	<hr>
	
	<div id="pjax_container">
EOS;
}

$page = isset($_GET['page']) ? $_GET['page'] : 'Mainpage';
if ($is_win) $page = str_replace('__', ':', $page);

$url = 'http://zh.moegirl.org/' . $page . '?action=render';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERAGENT, 'Moegirl proxy alpha');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$content = curl_exec($ch);
curl_close($ch);

// TODO: cache here
echo $content;

if (!$pjax) {
		echo <<< EOS
	</div>
	
	<script src="js/jquery.js"></script>
	<script src="js/jquery.pjax.js"></script>
	<script>var is_win = {$is_win};</script>
	<script src="js/moegirl.js"></script>
</body>
</html>
EOS;
}