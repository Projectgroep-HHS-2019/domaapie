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
    $component->id = isset($data->id) ? $data->id : die();

    // Get Component
    $component->read_single();

    // Create array
    $component_arr = array(
        'id' => $component->id,
        'name' => $component->name,
        'description' => $component->description,
        'status' => $component->status,
        'location_id' => $component->location_id,
        'location_name' => $component->location_name,
        'location_description' => $component->location_description,
        'location_type_location_id' => $component->location_type_location_id,
        'type_location_name' => $component->type_location_name,
        'type_location_description' => $component->type_location_description,
        'device_id' => $component->device_id,
        'device_name' => $component->device_name,
        'device_description' => $component->device_description
        
    );

    // Make JSON
    print_r(json_encode($component_arr));
?>