<?php
    // headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
            Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Component.php';

    // Instantiate DB % connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Component
    $component = new Component($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to update
    $component->id = $data->id;

    $component->name = $data->name;
    $component->description = $data->description;
    $component->status = $data->status;

    // Create Component
    if($component->update()){
        echo json_encode(
            array('message' => 'Component succesfully updated')
        );
    } else {
        echo json_encode(
            array('message' => 'Component not updated')
        );
    }
?>
