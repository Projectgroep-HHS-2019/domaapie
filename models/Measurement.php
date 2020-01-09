<?php
    class Measurement{
        // DB
        private $conn;
        private $table = 'measurement';

        //Measurement Properties
        public $id;
        public $device_id;
        public $device_name;
        public $timestamp;
        public $temperature;
        public $humidity;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Get Measurements
        public function read(){
            //Create query
            $query = 'SELECT
                      m.id,
                      m.device_id,
                      d.name as device_name,
                      m.date_time,
                      m.temperature,
                      m.humidity as humidity
                      FROM 
                      ' . $this->table . ' m
                      LEFT JOIN
                        device d ON m.device_id = d.id
                      ORDER BY 
                        m.date_time DESC';

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
                      m.id,
                      m.device_id,
                      d.name as device_name,
                      m.date_time,
                      m.temperature,
                      m.humidity as humidity
                      FROM 
                      ' . $this->table . ' m
                      LEFT JOIN
                        device d ON m.device_id = d.id
                      WHERE m.id = ?
                      LIMIT 0,1';

            // Prepare statement
            $stmt = $this->conn->prepare($query);    
            
            // Bind ID
            $stmt->bindParam(1, $this->id);

             // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set properties
            $this->id = $row['id'];
            $this->device_id = $row['device_id'];
            $this->device_name = $row['device_name'];
            $this->date_time = $row['date_time'];
            $this->temperature = $row['temperature'];
            $this->humidity = $row['humidity'];
        }

        // Create Measurement
        public function create(){
            //Create query
            $query = 'INSERT INTO ' . 
                $this-> table . '
                SET 
                device_id = :device_id,
                date_time = :date_time,
                temperature = :temperature,
                humidity = :humidity';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->device_id = htmlspecialchars(strip_tags($this->device_id));
            $this->date_time = htmlspecialchars(strip_tags($this->date_time));
            $this->temperature = htmlspecialchars(strip_tags($this->temperature));
            $this->humidity = htmlspecialchars(strip_tags($this->humidity));
        
            // Bind data
            $stmt->bindParam(':device_id', $this->device_id);
            $stmt->bindParam(':date_time', $this->date_time);
            $stmt->bindParam(':temperature', $this->temperature);
            $stmt->bindParam(':humidity', $this->humidity);

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
                    device_id = :device_id,
                    date_time = :date_time,
                    temperature = :temperature,
                    humidity = :humidity
                WHERE 
                    id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->device_id = htmlspecialchars(strip_tags($this->device_id));
            $this->date_time = htmlspecialchars(strip_tags($this->date_time));
            $this->temperature = htmlspecialchars(strip_tags($this->temperature));
            $this->humidity = htmlspecialchars(strip_tags($this->humidity));
            $this->id = htmlspecialchars(strip_tags($this->id));
        
            // Bind data
            $stmt->bindParam(':device_id', $this->device_id);
            $stmt->bindParam(':date_time', $this->date_time);
            $stmt->bindParam(':temperature', $this->temperature);
            $stmt->bindParam(':humidity', $this->humidity);
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