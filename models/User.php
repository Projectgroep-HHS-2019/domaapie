<?php
    class User{
        // DB STUFF
        private $conn;
        private $table = 'user';

        //User Properties
        public $id;
        public $name;
        public $failed_login_attemps;
        public $type_user;
        public $type_user_name;
        public $type_user_description;

        // Constructor with DB
        public function __construct($db) {
            $this->conn = $db;
        }

        // Register User
        public function register(){
            //Create query
            $query = 'INSERT INTO ' . 
                $this-> table . '
                SET 
                name = :name,
                password = :password,
                type_user = 1';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Clean data
            $this->name = htmlspecialchars(strip_tags($this->name));
            $this->password = htmlspecialchars(strip_tags($this->password));

            // Bind data
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':password', $this->password);

            // Execute Query
            if($stmt->execute()){
                return true;
            }

            // Print error if something goes wrong
            printf("Error: %s.\n", $stmt->error);

            return false;
        } 

        // Login User
        public function login(){
            //Create query
            $query = 'SELECT
                      u.id,
                      u.name,
                      u.type_user,
                      tu.name as type_user_name,
                      tu.description as type_user_description
                      FROM 
                      ' . $this->table . ' u
                      LEFT JOIN
                        type_user tu ON u.type_user = tu.id
                      WHERE u.name = :name
                      AND u.password = :password
                      LIMIT 0,1';

            // Prepare statement
            $stmt = $this->conn->prepare($query);    
            
            // Bind ID
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':password', $this->password);

             // Execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // Set properties
            $this->id = $row['id'];
            $this->name = $row['name'];
            $this->type_user = $row['type_user'];
            $this->type_user_name = $row['type_user_name'];
            $this->type_user_description = $row['type_user_description'];
        }
    }
?>