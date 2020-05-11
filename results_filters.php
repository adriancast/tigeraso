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



// Filter tipo de venta
$filtered_events_by_is_sale = [];
$is_sale_product = $request['isSale'];

foreach ($filtered_events_by_tag as $event) {

    if($event['venta'] == $is_sale_product){
        array_push($filtered_events_by_is_sale, $event);
    }

}


$filtered_events_by_is_exhange = [];
$is_exhange_product = $request['isExchange'];
foreach ($filtered_events_by_is_sale as $event) {
    if($event['intercambio'] == $is_exhange_product){
        array_push($filtered_events_by_is_exhange, $event);
    }

}

$filtered_events = $filtered_events_by_is_exhange;


echo $twig->render('results_cards.twig', compact('filtered_events'));
