<?php
    class Institution
    {

        // Connection
        private $conx;

        // Table
        private $db_table = "institution";

        // Columns
        public $id;
        public $title;
        public $lat;
        public $long;
        public $type;
        public $ward_id;

        // Db connection
        public function __construct($db)
        {
            $this->conx = $db;
        }

        // GET ALL
        public function getInstitutions()
        {
            $sqlQuery = "SELECT * FROM " . $this->db_table . "";
            $stmt = $this->conx->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // READ single
        public function getInstitution()
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

            $this->id = $dataRow['id'];
            $this->title = $dataRow['title'];
            $this->lat = $dataRow['lat'];
            $this->long = $dataRow['long'];
            $this->type = $dataRow['type'];
            $this->ward_id = $dataRow['ward_id'];
        }
    }
