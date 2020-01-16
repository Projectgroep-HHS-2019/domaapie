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

    // GET ID
    $data = json_decode(file_get_contents("php://input"));

     // Set ID to read
    $component->id = $data->id;
 
    $component->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get Component
    $component->read_single();

    // Create array
    $component_arr = array(
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

    // Make JSON
    print_r(json_encode($component_arr));
?>