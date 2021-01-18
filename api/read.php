<?php
    include_once 'database.php';
    include_once("statistic.php");

    // instantiate database and product object
    $database = new Database();
    $conx = $database->getConnection();

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");

    $items = new Statistic($conx);


    $statistic_data = $items->getStatistics();
    $itemCount = $statistic_data->rowCount();

    if ($itemCount > 0) {
        $statisticArr = array();
        $statisticArr["count"] = $itemCount;
        $statisticArr["results"] = array();

        while ($row = $statistic_data->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $e = array(
                "id" => $id,
                "population" => $population,
                "male_population" => $male_population,
                "female_population" => $female_population,
                "household" => $household,
                "ward_id" => $ward_id,
                "ward_title" => $ward_title,
                "municipality_id" => $municipality_id,
            );
            array_push($statisticArr["results"], $e);
        }
        echo json_encode($statisticArr);
    } else {
        http_response_code(404);
        echo json_encode(
            array("message" => "No record found.")
        );
    }
