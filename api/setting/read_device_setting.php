<?php
    // headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Setting.php';

    // Instantiate DB % connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate Setting
    $setting = new Setting($db);

    // GET ID
    $data = json_decode(file_get_contents("php://input"));

     // Set ID to read
    $setting->device_id = isset($data->device_id) ?$data->device_id : die();

    // Get setting
    $setting->readDeviceSetting();

    // Create array
    $setting_arr = array(
        'id' => $setting->id,
        'user_id' => $setting->user_id,
        'device_id' => $setting->device_id,
        'meas_time_interval' => $setting->meas_time_interval,
        'min_temperature' => $setting->min_temperature,
        'max_temperature' => $setting->max_temperature,
        'min_humidity' => $setting->min_humidity,
        'max_humidity' => $setting->max_humidity        
    );

    // Make JSON
    print_r(json_encode($setting_arr));
?>