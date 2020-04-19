<?php

require_once __DIR__ . '/config.php';

$events_string = file_get_contents(__DIR__ . "/json/events.json");
$events = json_decode($events_string, true)["eventos"];

shuffle($events);
$top_events = array_slice($events, 0, 3);

echo $twig->render('home.twig', compact('top_events'));
