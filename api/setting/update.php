<?php
    // headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
            Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Setting.php';

    // Instantiate DB % connect
    $database = new Database();
    $db = $database->connect();
6
    // Instantiate Setting
    $setting = new Setting($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    // Set ID to update
    $setting->id = $data->id;

    $setting->meas_time_interval = $data->meas_time_interval;
    $setting->min_temperature = $data->min_temperature;
    $setting->max_temperature = $data->max_temperature;
    $setting->min_humidity = $data->min_humidity;
    $setting->max_humidity = $data->max_humidity;

    // Create setting
    if($setting->update()){
        echo json_encode(
            array('message' => 'Setting succesfully updated')
        );
    } else {
        echo json_encode(
            array('message' => 'Setting not updated')
        );
    }
?>
