<?php

require_once __DIR__ . '/config.php';

$events_string = file_get_contents(__DIR__ . "/json/events.json");
$events = json_decode($events_string, true)["eventos"];

shuffle($events);
$top_events = array_slice($events, 0, 4);

$autoverde_string = file_get_contents(__DIR__ . "/json/AutoVerde.json");
$autoverde = json_decode($autoverde_string, true)["AutoVerde"];

shuffle($autoverde);
$top_autoverde = array_slice($autoverde, 0, 2);

$top_autoverde_p = [];
foreach ($top_autoverde as $autoverde) {
   $autoverde['url'] = sprintf("https://alumnes-ltim.uib.es/~tm2003/hoja-producto.html?type=AutoVerde&id=%s", $auto['identificador']);
   array_push($top_autoverde_p, $autoverde);
}


$autos_string = file_get_contents(__DIR__ . "/json/ObjetosAutomocion.json");
$autos = json_decode($autos_string, true)["Automoción"];

shuffle($autos);
$top_autos = array_slice($autos, 0, 2);

$top_autos_p = [];
foreach ($top_autos as $auto) {
   $auto['url'] = sprintf("https://alumnes-ltim.uib.es/~tm2010/Producto/producto.html?file=ObjetosAutomocion&id=%s", $auto['identificador']);
   array_push($top_autos_p, $auto);
}

$id = $_GET['id'];
$selected_event = null;
foreach ($events as $event) {
    if (strval($event['identificador']) == $id) {
        
       $selected_event = $event;
        break;
       
   };
}

$top_vehicles = array_merge($top_autos_p, $top_autoverde_p);
shuffle($top_vehicles);

// Weather 
$curl = curl_init();
$url_params = array(
   "lat" => $selected_event['geo1']['lat'],
   "lon"=> $selected_event['geo1']['long'],
   "appid"=> "86c1057fe89870513bbbe6459dc3e11e",
);
$url = "api.openweathermap.org/data/2.5/weather?" . http_build_query($url_params);

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
));

$weather = curl_exec($curl);

curl_close($curl);
//echo $weather;

echo $twig->render('product.twig', compact('top_events', 'top_vehicles', 'selected_event'));

//$autoverdes_string = file_get_contents(__DIR__ . "/json/AutoVerde.json");
//$autoverdes = json_decode($autoverdes_string, true)["autoverdes"];

//$id_1 = $_GET['id'];
//$selected_autos = null;
//foreach ($autoverdes as $auto) {
//    if (strval($auto['identificador']) == $id_1) {
        
//       $selected_autos = $auto;
//        break;
       
//   };
//}

//shuffle($autoverdes);
//$top_autos = array_slice($autos, 0, 4);

//echo $twig->render('product.twig', compact('top_autos', 'selected_auto'));
