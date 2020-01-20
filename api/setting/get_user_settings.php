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

    // Setting query
    $result = $setting->getUserSettings();

    // Get row count
    $num = $result->rowCount();

    // Check if any setting
    if($num > 0)
    {
        // setting array
        $settings_arr = array();
        $settings_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);

            $setting_item = array(
                'id' => $setting->id,
                'user_id' => $setting->user_id,
                'device_id' => $setting->device_id,
                'meas_time_interval' => $setting->meas_time_interval,
                'min_temperature' => $setting->min_temperature,
                'max_temperature' => $setting->max_temperature,
                'min_humidity' => $setting->min_humidity,
                'max_humidity' => $setting->max_humidity         
            );

            // Push to "data"
            array_push($settings_arr['data'], $setting_item);
        }

        // Turn into JSON & output
        echo json_encode($settings_arr);

    } else {
        // No Setting
        echo json_encode(
            array('message' => 'No setting found')
        );
    }
?>