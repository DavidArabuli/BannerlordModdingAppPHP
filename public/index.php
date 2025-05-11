<?php

require '../core/Router.php';

$router = new Router;
$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_SERVER['REQUEST_METHOD'];
require '../views/routes.php';

$router->route($uri, $method);

// require '../views/unitsForm.php';
// function render($template, $data = [])
// {
//     extract($data);
//     require $template;
// }
// $xml = file_get_contents(__DIR__ . '/../assets/spnpccharacters.xml');
// $xmlObject = simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA);
// $json = json_encode($xmlObject);
// $array = json_decode($json, true);
// render('../views/unitsForm.php', ['array' => $array]);

// foreach ($array['NPCCharacter'] as $unit) {
//     echo '<pre>';
//     echo $unit['@attributes']['id'];
//     echo '</pre>';
// }
// foreach ($array as $unit) {
//     echo '<pre>';
//     print_r($unit['id']);
//     echo '</pre>';
// }

// foreach ($array['NPCCharacter'] as $unit) {
//     echo '<pre>';
//     print_r($unit);
//     echo '</pre>';
// }