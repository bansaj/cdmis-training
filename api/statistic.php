<?php
    class Statistic
    {

        // Connection
        private $conx;

        // Table
        private $db_table = "statistics";

        // Columns
        public $id;
        public $population;
        public $male_population;
        public $female_population;
        public $household;
        public $ward_id;
        public $ward_title;
        public $municipality_id;

        // Db connection
        public function __construct($db)
        {
            $this->conx = $db;
        }

        // GET ALL
        public function getStatistics()
        {
            $sqlQuery = "SELECT 
                        statistics.id AS id,
                        statistics.population AS population,
                        statistics.male_population AS male_population,
                        statistics.female_population AS female_population,
                        statistics.household AS household,
                        statistics.ward_id AS ward_id,
                        ward.title AS ward_title,
                        ward.municipality_id AS municipality_id
                        FROM
                        statistics
                        INNER JOIN ward ON ward.id = statistics.ward_id";
            $stmt = $this->conx->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // READ single
        public function getStatistic()
        {
            $sqlQuery ="SELECT 
                        statistics.id AS id,
                        statistics.population AS population,
                        statistics.male_population AS male_population,
                        statistics.female_population AS female_population,
                        statistics.household AS household,
                        statistics.ward_id AS ward_id,
                        ward.title AS ward_title,
                        ward.municipality_id AS municipality_id
                        FROM
                        statistics
                        INNER JOIN ward ON ward.id = statistics.ward_id 
                        WHERE 
                        ward.title = :ward_id
                        and ward.municipality_id = :municiaplity_id
                        LIMIT 0,1";

            $stmt = $this->conx->prepare($sqlQuery);

            $stmt->bindParam(':ward_id', $this->ward, PDO::PARAM_STR);
            $stmt->bindParam(':municiaplity_id', $this->municipality, PDO::PARAM_STR);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $dataRow['id'];
            $this->population = $dataRow['population'];
            $this->male_population = $dataRow['male_population'];
            $this->female_population = $dataRow['female_population'];
            $this->household = $dataRow['household'];
            $this->ward_id = $dataRow['ward_id'];
            $this->ward_title = $dataRow['ward_title'];
            $this->municipality_id = $dataRow['municipality_id'];
        }
    }
