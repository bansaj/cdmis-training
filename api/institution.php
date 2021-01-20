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
        public $ward_title;
        public $municipality_id;

        // Db connection
        public function __construct($db)
        {
            $this->conx = $db;
        }

        // GET ALL
        public function getInstitutions()
        {
            $sqlQuery = "SELECT
                        institution.id AS id,
                        institution.title AS title,
                        institution.lat AS lat,
                        institution.`long` AS `long`,
                        institution.type AS type,
                        institution.ward_id AS ward_id,
                        ward.title AS ward_title,
                        ward.municipality_id AS municipality_id
                        FROM
                        " . $this->db_table . "
                        INNER JOIN ward ON ward.id = institution.ward_id";
            $stmt = $this->conx->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // READ single
        public function getInstitution()
        {
            $sqlQuery ="SELECT
                        institution.id AS id,
                        institution.title AS title,
                        institution.lat AS lat,
                        institution.`long` AS `long`,
                        institution.type AS type,
                        institution.ward_id AS ward_id,
                        ward.title AS ward_title,
                        ward.municipality_id AS municipality_id
                        FROM
                        institution
                        INNER JOIN ward ON ward.id = institution.ward_id
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
            $this->title = $dataRow['title'];
            $this->lat = $dataRow['lat'];
            $this->long = $dataRow['long'];
            $this->type = $dataRow['type'];
            $this->ward_id = $dataRow['ward_id'];
            $this->ward_title = $dataRow['ward_title'];
            $this->municiaplity_id = $dataRow['municipality_id'];
        }
    }
