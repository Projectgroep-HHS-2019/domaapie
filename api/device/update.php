<?php
    // headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
            Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Device.php';

    // Instantiate DB % connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Device
    $device = new Device($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to update
    $device->id = $data->id;

    $device->name = $data->name;
    $device->description = $data->description;

    // Create device
    if($device->update()){
        echo json_encode(
            array('message' => 'Device succesfully updated')
        );
    } else {
        echo json_encode(
            array('message' => 'Device not updated')
        );
    }
?>
