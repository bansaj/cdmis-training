<?php
include_once("config.php");
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

$reader = new Xlsx();
$reader->setReadDataOnly(true);
$reader->setLoadSheetsOnly(["DATA"]);
$spreadsheet = $reader->load("Population.xlsx");

$worksheet = $spreadsheet->getActiveSheet();

$worksheet_data = $worksheet->toArray();

$header = $worksheet_data[0];
unset($worksheet_data[0]);

$associativeArraySheet = array_map(static function ($row) use ($header) {
    return array_combine($header, $row);
}, $worksheet_data);

foreach ($associativeArraySheet as $population_data) {
    $district = trim(mysqli_real_escape_string($conx, $population_data["DISTRICT"]));
    $municipality = trim(mysqli_real_escape_string($conx, $population_data["GAPA/NAPA"]));
    $lg_id = trim(mysqli_real_escape_string($conx, $population_data["LGCODE"]));
    $ward = trim(mysqli_real_escape_string($conx, $population_data["WARD NO."]));

    // statiscs data
    $household = trim(mysqli_real_escape_string($conx, $population_data["HOUSEHOLD"]));
    $population  = trim(mysqli_real_escape_string($conx, $population_data["TOTAL Pop."]));
    $male_population  = trim(mysqli_real_escape_string($conx, $population_data["MALE Pop."]));
    $female_population  = trim(mysqli_real_escape_string($conx, $population_data["FEMALE Pop."]));
    if (!empty($district)) {
        // for district
        $sql = "SELECT * FROM District WHERE title='$district'";
        $result = mysqli_query($conx, $sql);
        // check if district exists or not
        if (!mysqli_fetch_row($result)) {
            $result = mysqli_query($conx, "INSERT INTO District(title) VALUES('$district')");
        }
        // for municipality
        $sql = "SELECT * FROM District INNER JOIN
                Municipality ON District.id = Municipality.district_id
                WHERE District.title = '$district' AND Municipality.title = '$municipality'";
        $result = mysqli_query($conx, $sql);
        if (!mysqli_fetch_row($result)) {
            $sql = "SELECT id FROM District WHERE title='$district'";
            $result = mysqli_query($conx, $sql);
            // check if district exists or not
            $district_id = mysqli_fetch_row($result);
            if ($district_id) {
                $result = mysqli_query($conx, "INSERT INTO Municipality(title, lg_id, district_id) VALUES('$municipality', '$lg_id', '$district_id[0]')");
            }
        }
        // for ward
        $sql = "SELECT * FROM Municipality INNER JOIN
                Ward ON Municipality.id = Ward.municipality_id
                WHERE Municipality.title = '$municipality' AND Ward.title = '$ward'";
        $result = mysqli_query($conx, $sql);
        if (!mysqli_fetch_row($result)) {
            $sql = "SELECT id FROM Municipality WHERE title='$municipality'";
            $result = mysqli_query($conx, $sql);
            // check if municipality exists or not
            $municipality_id = mysqli_fetch_row($result);
            if ($municipality_id) {
                $result = mysqli_query($conx, "INSERT INTO Ward(title, municipality_id) VALUES('$ward', '$municipality_id[0]')");
            }
        }
        // statistics
        $sql = "SELECT Ward.id FROM Ward INNER JOIN
                Municipality ON Municipality.id = Ward.municipality_id
                WHERE Municipality.title = '$municipality' AND Ward.title = '$ward'";
        $result = mysqli_query($conx, $sql);
        $ward_id = mysqli_fetch_row($result);
        if ($ward_id) {
            $sql = "SELECT * FROM Statistics WHERE population='$population'
            and male_population='$male_population' and female_population = '$female_population' and ward_id='$ward_id[0]'";
            $result = mysqli_query($conx, $sql);
            if (!mysqli_fetch_row($result)) {
                $result = mysqli_query($conx, "INSERT INTO Statistics(household, population, male_population, female_population, ward_id)
                  VALUES('$household', '$population', '$male_population', '$female_population', '$ward_id[0]')");
            }
        }
    }
}
echo "all record has been imported ...";
