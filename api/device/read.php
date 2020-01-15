<?php
    // headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Device.php';

    // Instantiate DB % connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Device
    $device = new Device($db);

    // Device query
    $result = $Device->read();

    // Get row count
    $num = $result->rowCount();

    // Check if any devices
    if($num > 0)
    {
        // device array
        $devices_arr = array();
        $devices_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $device_item = array(
                'id' => $id,
                'name' => $name,
                'description' => $description,
                'location_id' => $location_id,
                'location_name' => $location_name,
                'location_description' => $location_description,
                'location_type_location_id' => $location_type_location_id,
                'type_location_name' => $type_location_name,
                'type_location_description' => $type_location_description
            );
        }

            // Push to "data"
            array_push($devices_arr['data'], $device_item);
        }

        // Turn into JSON & output
        echo json_encode($devices_arr);

    } else {
        // No Measurements
        echo json_encode(
            array('message' => 'No Devices found')
        );
    }
?>