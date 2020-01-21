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
    $setting->user_id = isset($data->user_id) ? $data->user_id : die();

    // Setting query
    $result = $setting->readUserSettings();

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
                'id' => $id,
                'user_id' => $user_id,
                'device_id' => $device_id,
                'meas_time_interval' => $meas_time_interval,
                'min_temperature' => $min_temperature,
                'max_temperature' => $max_temperature,
                'min_humidity' => $min_humidity,
                'max_humidity' => $max_humidity         
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