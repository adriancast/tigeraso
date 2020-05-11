<?php

require_once __DIR__ . '/config.php';

$events_string = file_get_contents(__DIR__ . "/json/events.json");
$events = json_decode($events_string, true)["eventos"];

$request_string = file_get_contents('php://input');
$request = json_decode($request_string, TRUE);
// Filtrar por tag
$selected_tags = $request['selectedTags'];
if(sizeof($selected_tags) > 0){
$filtered_events_by_tag = [];
foreach ($events as $event) {
    $event_tags = $event['tags-propios'];
    if (sizeof(array_intersect($selected_tags, $event_tags))){
        array_push($filtered_events_by_tag, $event);
    };

}
}else{
    $filtered_events_by_tag = $events;
}

$filtered_events_by_sale_type = [];
$is_sale_product = $request['isSale'];
$is_exhange_product = $request['isExchange'];

foreach ($filtered_events_by_tag as $event) {

    if($event['venta'] == $is_sale_product || $event['intercambio'] == $is_exhange_product){
        array_push($filtered_events_by_sale_type, $event);
    }

}

$filtered_events = $filtered_events_by_sale_type;


echo $twig->render('results_cards.twig', compact('filtered_events'));
