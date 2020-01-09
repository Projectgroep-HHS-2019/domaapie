<?php
    // headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Measurement.php';

    // Instantiate DB % connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Measurement
    $measurement = new Measurement($db);

    // GET ID
    $measurement->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get measurement
    $measurement->read_single();

    // Create array
    $measurement_arr = array(
        'id' => $measurement->id,
        'device_id' => $measurement->device_id,
        'device_name' => $measurement->device_name,
        'date_time' => $measurement->date_time,
        'temperature' => $measurement->temperature,
        'humidity' => $measurement->humidity
    );

    // Make JSON
    print_r(json_encode($measurement_arr));

    ?>