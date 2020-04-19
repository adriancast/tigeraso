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



echo $twig->render('results.twig', compact('events', 'tags'));
