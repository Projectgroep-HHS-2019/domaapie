<?php
    // headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
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

    $device->name = $data->name;
    $device->description = $data->description;

    // Create device
    if($device->create()){
        echo json_encode(
            array('message' => 'Device succesfully created')
        );
    } else {
        echo json_encode(
            array('message' => 'Device not created')
        );
    }
?>
