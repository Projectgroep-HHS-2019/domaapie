<?php
    // headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/User.php';

    // Instantiate DB % connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate User
    $user = new User($db);

    // GET ID
    $data = json_decode(file_get_contents("php://input"));

     // Set ID to read
    $user->name = isset($data->name) ? $data->name : die(); 
    $user->password = isset($data->password) ? $data->password : die(); 

    // Get user
    $user->login();

    if($user->id === null)
    {
        $user_arr = array(
            'Message' => 'Login Failed!'
        );
    }

    // Create array
    $user_arr = array(
        'id' => $user->id,
        'name' => $user->name,
        'type_user' => $user->type_user,
        'type_user_name' =>  $user->type_user_name,
        'type_user_description' =>  $user->type_user_description
    );

    // Make JSON
    print_r(json_encode($user_arr));
?>