<?php
    // headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Component.php';

    // Instantiate DB % connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Component
    $component = new Component($db);

    // Component query
    $result = $Component->read();

    // Get row count
    $num = $result->rowCount();

    // Check if any Component
    if($num > 0)
    {
        // component array
        $components_arr = array();
        $components_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $component_item = array(
                'id' => $id,
                'name' => $name,
                'description' => $description,
                'status' => $status,
                'location_id' => $location_id,
                'location_name' => $location_name,
                'location_description' => $location_description,
                'location_type_location_id' => $location_type_location_id,
                'type_location_name' => $type_location_name,
                'type_location_description' => $type_location_description,
                'device_id' => $device_id,
                'device_name' => $device_name,
                'device_description' => $device_description
            );
        

            // Push to "data"
            array_push($components_arr['data'], $component_item);
        }

        // Turn into JSON & output
        echo json_encode($component_arr);

    } else {
        // No Component
        echo json_encode(
            array('message' => 'No Component found')
        );
    }
?>