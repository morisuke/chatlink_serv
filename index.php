<?php
require './vendor/autoload.php';

const TITLE = 'og:title';
const URL   = 'og:url';
const DESC  = 'og:description';
const IMAGE = 'og:image';

// URLがカラの場合はカラjsonを返す
if (empty($_GET['url']))
{
	echo json_encode([]);
	exit;
}

// OGPを取得して返す処理
$ogp = [];
$document = (new Goutte\Client)->request('GET', $_GET['url'])->filter('meta');
$document->each(function($node) use (&$ogp) {
	
	$property = $node->attr('property');
	$value    = $node->attr('content');

	if ($property === TITLE) $ogp['title']       = $value;
	if ($property === URL)   $ogp['url']         = $value;
	if ($property === DESC)  $ogp['description'] = $value;
	if ($property === IMAGE) $ogp['image']       = $value;

});

header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json; charset=utf-8');
echo json_encode($ogp);
