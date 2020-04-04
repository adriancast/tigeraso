<?php

require_once __DIR__ . '/config.php';

$events_string = file_get_contents(__DIR__ . "/json/events.json");
$events = json_decode($events_string, true);

echo $twig->render('results.twig', compact('events', 'events_string'));
