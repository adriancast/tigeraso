<?php

require_once __DIR__ . '/config.php';

$events_string = file_get_contents(__DIR__ . "/json/events.json");
$events = json_decode($events_string, true)["eventos"];

$id = $_GET['id'];
$selected_event = null;
foreach ($events as $event) {
    if (strval($event['identificador']) == $id) {
        
       $selected_event = $event;
        break;
       
   };
}

shuffle($events);
$top_events = array_slice($events, 0, 4);

echo $twig->render('product.twig', compact('top_events', 'selected_event'));

$autoverdes_string = file_get_contents(__DIR__ . "/json/AutoVerde.json");
$autoverdes = json_decode($autoverdes_string, true)["autoverdes"];

$id_1 = $_GET['id'];
$selected_autos = null;
foreach ($autoverdes as $auto) {
    if (strval($auto['identificador']) == $id_1) {
        
       $selected_autos = $auto;
        break;
       
   };
}

shuffle($autoverdes);
$top_autos = array_slice($autos, 0, 4);

echo $twig->render('product.twig', compact('top_autos', 'selected_auto'));
