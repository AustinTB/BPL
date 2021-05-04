<?php

// header('Access-Control-Allow-Origin: http://localhost:4200');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding');
header('Access-Control-Max-Age: 1000');  
header('Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT');

include('db-helpers.php');
// get the size of incoming data
// $content_length = (int) $_SERVER['CONTENT_LENGTH'];

// retrieve data from the request
$postdata = file_get_contents("php://input");

// process data

// Extract JSON to PHP array
$request = json_decode($postdata);

$data = [];

// $data[0]['length'] = $content_length;
foreach ($request as $k => $v) {
    // $temp = "$k => $v";

    if ($k == "stat_option") $stat_choice = $v;
    else if ($k == "lead_sum") $lead_sum_choice = $v;

    $data[0]['post_' .$k] = $v;
}
// $temp will have the last key-value pair of the array

if ($stat_choice == "Hits") $stat_arg = "hits";
else if ($stat_choice == "Misses") $stat_arg = "misses";
else $stat_arg = "called_cups";

$leader = null;
if ($lead_sum_choice == "leader") {
    $leader = getLeader($stat_arg);
    $stat = $leader[$stat_arg];
} else {
    $stat = getTotalStat($stat_arg);
}

if (isset($leader)) $data[0]['post_leader'] = $leader['player_name'];
$data[0]['post_stat'] = $stat;

$current_date = date("Y-m-d");

// Send response in JSON format back to the front end
echo json_encode(['content' => $data, 'response_on' => $current_date]);
?>