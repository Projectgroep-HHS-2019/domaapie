<?php
    class Measurement{
        // DB STUFF
        private $conn;
        private $table = 'device';

        //Measurement Properties
        public $id;
        public $name;
        public $description;
        public $location_id;
        public $location_name;
        public $location_description;
        public $location_type_location_id;
        public $type_location_name;
        public $type_location_description;
        

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Measurements
        public function read(){
            //Create query
            $query = 'SELECT
                      d.id,
                      d.name,
                      d.description,
                      d.location_id,
                      l.name as location_name,
                      l.description as location_description,
                      l.type_location as location_type_location_id,
                      tl.name as type_location_name,
                      tl.description as type_location_description
                      FROM 
                      ' . $this->table . ' d
                      LEFT JOIN
                        location l ON d.location_id = l.id
                      LEFT JOIN
                        type_location tl ON l.type_location = tl.id
                      ORDER BY 
                        d.name DESC';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Execute query
        $stmt->execute();

        return $stmt;
        }  

        // Get single Measurement
        public function read_single(){
            //Create query
            $query = 'SELECT
                      d.id,
                      d.name,
                      d.description,
                      d.location_id,
                      l.name as location_name,
                      l.description as location_description,
                      l.type_location as location_type_location_id,
                      tl.name as type_location_name,
                      tl.description as type_location_description,
                      FROM 
                      ' . $this->table . ' d
                      LEFT JOIN
                        location l ON d.location_id = l.id
                      LEFT JOIN
                        type_location tl ON l.type_location = tl.id
                      WHERE d.id = :id
                      LIMIT 0,1';

            // Prepare statement
            $stmt = $this->conn->prepare($query);   
            
            // Clean Data
            $this->id = htmlspecialchars(strip_tags($this->id));
            
            // Bind ID
            $stmt->bindParam(':id', $this->id);

             // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set properties
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->description = $row['description'];
            $this->location_id = $row['location_id'];
            $this->location_name = $row['location_name'];
            $this->location_description = $row['location_description'];
            $this->location_type_location_id = $row['location_type_location_id'];
            $this->type_location_name = $row['type_location_name'];
            $this->type_location_description = $row['type_location_description'];
        }

        // Create Measurement
        public function create(){
            //Create query
            $query = 'INSERT INTO ' . 
                $this-> table . '
                SET 
                name = :name,
                description = :description';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->description = htmlspecialchars(strip_tags($this->description));

            // Bind data
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':description', $this->description);

            // Execute Query
            if($stmt->execute()){
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        // Update Measurement
        public function update(){
            //Create query
            $query = 'UPDATE ' . 
                $this-> table . '
                SET 
                    name = :name,
                    description = :description
                WHERE 
                    id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->description = htmlspecialchars(strip_tags($this->description));
            $this->id = htmlspecialchars(strip_tags($this->id));
        
            // Bind data
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':id', $this->id);

            // Execute Query
            if($stmt->execute()){
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        // Delete Measurement
        public function delete(){
            //Create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':id', $this->id);

            // Execute Query
            if($stmt->execute()){
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }
    }
?>