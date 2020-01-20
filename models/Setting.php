<?php
    class Setting{
        // DB STUFF
        private $conn;
        private $table = 'setting';

        //Setting Properties
        public $id;
        public $user_id;
        public $device_id;
        public $meas_time_interval;
        public $min_temperature;
        public $max_temperature;
        public $min_humidity;
        public $max_humidity;      

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

         // Get Device Settings by user
         public function getUserSettings(){
            //Create query
            $query = 'SELECT
                      id,
                      user_id,
                      device_id,
                      meas_time_interval,
                      min_temperature,
                      max_temperature,
                      min_humidity,
                      max_humidity
                      FROM 
                      ' . $this->table . '
                      WHERE user_id = :user_id';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Clean Data
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
            
        // Bind ID
        $stmt->bindParam(':user_id', $this->user_id);

        // Execute query
        $stmt->execute();

        return $stmt;
        }  

        // Get Setting
        public function getDeviceSetting(){
            //Create query
            $query = 'SELECT
                      id,
                      user_id,
                      device_id,
                      meas_time_interval,
                      min_temperature,
                      max_temperature,
                      min_humidity,
                      max_humidity
                      FROM 
                      ' . $this->table . '
                      WHERE device_id = :device_id
                      LIMIT 0,1';

            // Prepare statement
            $stmt = $this->conn->prepare($query);   
            
            // Clean Data
            $this->device_id = htmlspecialchars(strip_tags($this->device_id));
            
            // Bind ID
            $stmt->bindParam(':device_id', $this->device_id);

             // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set properties
            $this->id = $row['id'];
            $this->user_id = $row['user_id'];
            $this->device_id = $row['device_id'];
            $this->meas_time_interval = $row['meas_time_interval'];
            $this->min_temperature = $row['min_temperature'];
            $this->max_temperature = $row['max_temperature'];
            $this->min_humidity = $row['min_humidity'];
            $this->max_humidity = $row['max_humidity'];
        }

        // Create setting
        public function create(){
            //Create query
            $query = 'INSERT INTO ' . 
                $this-> table . '
                SET 
                user_id = :user_id,
                device_id = :device_id,
                meas_time_interval = :meas_time_interval,
                min_temperature = :min_temperature,
                max_temperature = :max_temperature,
                min_humidity = :min_humidity,
                max_humidity = :max_humidity';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->user_id = htmlspecialchars(strip_tags($this->user_id));
            $this->device_id = htmlspecialchars(strip_tags($this->device_id));
            $this->meas_time_interval = htmlspecialchars(strip_tags($this->meas_time_interval));
            $this->min_temperature = htmlspecialchars(strip_tags($this->min_temperature));
            $this->max_temperature = htmlspecialchars(strip_tags($this->max_temperature));
            $this->min_humidity = htmlspecialchars(strip_tags($this->min_humidity));
            $this->max_humidity = htmlspecialchars(strip_tags($this->max_humidity));

            // Bind data
            $stmt->bindParam(':user_id', $this->user_id);
            $stmt->bindParam(':device_id', $this->device_id);
            $stmt->bindParam(':meas_time_interval', $this->user_id);
            $stmt->bindParam(':min_temperature', $this->device_id);
            $stmt->bindParam(':max_temperature', $this->user_id);
            $stmt->bindParam(':min_humidity', $this->device_id);
            $stmt->bindParam(':max_humidity', $this->device_id);

            // Execute Query
            if($stmt->execute()){
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        // Update setting
        public function update(){
            //Create query
            $query = 'UPDATE ' . 
                $this-> table . '
                SET 
                    meas_time_interval = :meas_time_interval,
                    min_temperature = :min_temperature,
                    max_temperature = :max_temperature,
                    min_humidity = :min_humidity,
                    max_humidity = :max_humidity
                WHERE 
                    id = :id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->meas_time_interval = htmlspecialchars(strip_tags($this->meas_time_interval));
            $this->min_temperature = htmlspecialchars(strip_tags($this->min_temperature));
            $this->max_temperature = htmlspecialchars(strip_tags($this->max_temperature));
            $this->min_humidity = htmlspecialchars(strip_tags($this->min_humidity));
            $this->max_humidity = htmlspecialchars(strip_tags($this->max_humidity));
            $this->id = htmlspecialchars(strip_tags($this->id));

            // Bind data
            $stmt->bindParam(':meas_time_interval', $this->meas_time_interval);
            $stmt->bindParam(':min_temperature', $this->min_temperature);
            $stmt->bindParam(':max_temperature', $this->max_temperature);
            $stmt->bindParam(':min_humidity', $this->min_humidity);
            $stmt->bindParam(':max_humidity', $this->max_humidity);
            $stmt->bindParam(':id', $this->id);

            // Execute Query
            if($stmt->execute()){
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        }

        // Delete Setting
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