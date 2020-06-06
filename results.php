<?php

require_once __DIR__ . '/config.php';

$events_string = file_get_contents(__DIR__ . "/json/events.json");
$events = json_decode($events_string, true)["eventos"];

$tags = [];
foreach ($events as $event) {
    $event_tags = $event['tags-propios'];
    for ($x = 0; $x < sizeof($event_tags); $x++) {
        $tag = $event_tags[$x];
        array_push($tags, $tag);
    }

}
$tags = array_unique($tags);

$carrito = [];
if(isset($_COOKIE['carrito'])){
   $carrito = json_decode($_COOKIE['carrito'], true);
}else {
   setcookie('carrito', '[]', time() + (86400 * 30), "/");
}
$obj_carrito = [];
foreach ($carrito as $elem_carrito) {
   foreach ($events as $event) {
      if (strval($event['identificador']) == strval($elem_carrito)) {
         array_push($obj_carrito, $event);
      }   
   }
}

echo $twig->render('results.twig', compact('events', 'tags', 'obj_carrito'));
