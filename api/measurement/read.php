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

    // Measurement query
    $result = $measurement->read();

    // Get row count
    $num = $result->rowCount();

    // Check if any measurements
    if($num > 0)
    {
        // measurement array
        $measurements_arr = array();
        $measurements_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $measurement_item = array(
                'id' => $id,
                'device_id' => $device_id,
                'device_name' => $device_name,
                'date_time' => $date_time,
                'temperature' => $temperature,
                'humidity' => $humidity
            );

            // Push to "data"
            array_push($measurements_arr['data'], $measurement_item);
        }

        // Turn into JSON & output
        echo json_encode($measurements_arr);

    } else {
        // No Measurements
        echo json_encode(
            array('message' => 'No Measurements found')
        );
    }
?>