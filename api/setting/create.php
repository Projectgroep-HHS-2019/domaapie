<?php
    // headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type,
            Access-Control-Allow-Methods, Authorization, X-Requested-With');

    include_once '../../config/Database.php';
    include_once '../../models/Setting.php';

    // Instantiate DB % connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Setting
    $setting = new Setting($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    $setting->user_id = $data->user_id;
    $setting->device_id = $data->device_id;
    $setting->meas_time_interval = $data->meas_time_interval;
    $setting->min_temperature = $data->min_temperature;
    $setting->max_temperature = $data->max_temperature;
    $setting->min_humidity = $data->min_humidity;
    $setting->max_humidity = $data->max_humidity;

    // Create setting
    if($setting->create()){
        echo json_encode(
            array('message' => 'Setting succesfully created')
        );
    } else {
        echo json_encode(
            array('message' => 'Setting not created')
        );
    }
?>
