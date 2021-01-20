<?php
    include_once 'database.php';
    include_once("institution.php");

    // instantiate database and product object
    $database = new Database();
    $conx = $database->getConnection();

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    $items = new Institution($conx);
    $items->municipality = isset($_GET['municipality']) ? $_GET['municipality'] : die();


    $institution_data = $items->getInstitutions();
    $itemCount = $institution_data->rowCount();

    if ($itemCount > 0) {
        $institutionArr = array();
        $institutionArr["count"] = $itemCount;
        $institutionArr["results"] = array();

        while ($row = $institution_data->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $e = array(
                "id" => $id,
                "title" => $title,
                "type" => $type,
                "lat" => $lat,
                "long" => $long,
                "ward_id" => $ward_id,
                "ward_title" => $ward_title,
                "municipality_id" => $municipality_id,
            );

            array_push($institutionArr["results"], $e);
        }
        echo json_encode($institutionArr);
    } else {
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
