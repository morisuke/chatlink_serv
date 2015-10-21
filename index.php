<?php
namespace Application;
require './vendor/autoload.php';

use Opengraph;
$ogp = (new Opengraph\Reader)->parse(file_get_contents($_GET['url']))->getArrayCopy();

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');

echo json_encode([
	'url'         => $ogp['og:url'],
	'title'       => $ogp['og:title'],
	'description' => $ogp['og:description'],
	'image'       => current(current($ogp['og:image'])),
]);
