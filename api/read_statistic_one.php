<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// include database and object files
include_once 'database.php';
include_once 'statistic.php';
  
// get database connection
$database = new Database();
$conx = $database->getConnection();
  
// prepare statistic object
$statistic = new Statistic($conx);
  
// set ID property of record to read
$statistic->ward = isset($_GET['ward']) ? $_GET['ward'] : die();
$statistic->municipality = isset($_GET['municipality']) ? $_GET['municipality'] : die();
  
// read the details of statistic to be edited
$statistic->getStatistic();
  
if ($statistic->population!=null) {
    // create array
    $statistic_arr = array(
        "id" =>  $statistic->id,
        "population" => $statistic->population,
        "male_population" => $statistic->male_population,
        "female_population" => $statistic->female_population,
        "household" => $statistic->household,
        "ward_id" => $statistic->ward_id,
        "ward_title" => $statistic->ward_title,
        "municipality_id" => $statistic->municipality_id,
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($statistic_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user statistic does not exist
    echo json_encode(array("message" => "statistic does not exist."));
}
