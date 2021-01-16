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

        // Db connection
        public function __construct($db)
        {
            $this->conx = $db;
        }

        // GET ALL
        public function getStatistics()
        {
            $sqlQuery = "SELECT * FROM " . $this->db_table . "";
            $stmt = $this->conx->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // READ single
        public function getStatistic()
        {
            $sqlQuery = "SELECT
                      *
                      FROM
                        ". $this->db_table ."
                    WHERE 
                       id = ?
                    LIMIT 0,1";

            $stmt = $this->conx->prepare($sqlQuery);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->population = $dataRow['population'];
            $this->male_population = $dataRow['male_population'];
            $this->female_population = $dataRow['female_population'];
            $this->household = $dataRow['household'];
            $this->ward_id = $dataRow['ward_id'];
        }
    }
