<?php

require_once __DIR__ . '/config.php';

$events_string = file_get_contents(__DIR__ . "/json/events.json");
$events = json_decode($events_string, true);

$id = $_GET['id'];
$selected_event = null;
foreach ($events as $event) {
    if (strval($event['identificador']) == $id) {
        
       $selected_event = $event;
       
   };
}

shuffle($events);
$top_events = array_slice($events, 0, 4);

echo $twig->render('product.twig', compact('top_events', 'selected_event'));
