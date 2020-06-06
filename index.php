<?php

require_once __DIR__ . '/config.php';

$events_string = file_get_contents(__DIR__ . "/json/events.json");
$events = json_decode($events_string, true)["eventos"];

shuffle($events);
$top_events = array_slice($events, 0, 3);

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

echo $twig->render('home.twig', compact('top_events', 'obj_carrito'));
