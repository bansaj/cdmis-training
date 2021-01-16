<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');
  
// include database and object files
include_once 'database.php';
include_once 'institution.php';
  
// get database connection
$database = new Database();
$conx = $database->getConnection();
  
// prepare instituion object
$institution = new Institution($conx);
  
// set ID property of record to read
$institution->id = isset($_GET['id']) ? $_GET['id'] : die();
  
// read the details of instituion to be edited
$institution->getInstitution();
  
if ($institution->title!=null) {
    // create array
    $institution_arr = array(
        "id" =>  $institution->id,
        "title" => $institution->title,
        "type" => $institution->type,
        "lat" => $institution->lat,
        "long" => $institution->long,
        "ward_id" => $institution->ward_id
  
    );
  
    // set response code - 200 OK
    http_response_code(200);
  
    // make it json format
    echo json_encode($institution_arr);
} else {
    // set response code - 404 Not found
    http_response_code(404);
  
    // tell the user instituion does not exist
    echo json_encode(array("message" => "instituion does not exist."));
}
