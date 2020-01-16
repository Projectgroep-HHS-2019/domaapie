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

    // GET ID
    $data = json_decode(file_get_contents("php://input"));

     // Set ID to read
    $device->id = $data->id;
 
    $device->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get device
    $device->read_single();

    // Create array
    $device_arr = array(
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

    // Make JSON
    print_r(json_encode($device_arr));
?>