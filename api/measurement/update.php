<?php
    // headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
            Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Measurement.php';

    // Instantiate DB % connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Measurement
    $measurement = new Measurement($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to update
    $measurement->id = $data->id;

    $measurement->device_id = $data->device_id;
    $measurement->date_time = $data->date_time;
    $measurement->temperature = $data->temperature;
    $measurement->humidity = $data->humidity;

    // Create measurement
    if($measurement->update()){
        echo json_encode(
            array('message' => 'Measurement succesfully updated')
        );
    } else {
        echo json_encode(
            array('message' => 'Measurement not updated')
        );
    }
?>
