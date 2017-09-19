<?php
/**
 * Sample Implementation of the Skyroom Web Service
 *
 * @version     1.0
 * @copyright   Skyroom.ir
 */

require_once '../api/Skyroom.php';
define('BASE_URL', 'http://localhost.skyroom/skyroom/api/');

if (empty($_POST)) {
    $markup = file_get_contents('form.html');
    $markup = str_replace('{{base_url}}', BASE_URL, $markup);
    $markup = str_replace('{{version}}', Skyroom::Version, $markup);
    print($markup);
  exit;
}

$apiKey = $_POST['api_key'];
if (empty($apiKey)) {
    print('<pre>No API key is provided!</pre>');
    return;
}

$url = BASE_URL . $apiKey;
$api = new Skyroom($url);
$action = $_POST['action'];
switch ($action) {
    case 'getServices':
        $params = array();
        break;

    case 'getService':
        $params = array(
            'service_id' => 1,
        );
        break;

    case 'getRooms':
        $params = array();
        break;

    case 'getRoom':
        $params = array(
            'room_id' => 1,
        );
        break;

    case 'createRoom':
        $params = array(
            'service_id' => 1,
            'name' => time(),
            'title' => 'Room ' . rand(1, 100),
            'max_users' => rand(2, 50),
        );
        break;

    case 'updateRoom':
        $params = array(
            'room_id' => 31,
            'name' => time(),
            'title' => 'Room ' . rand(1, 100),
            'max_users' => rand(2, 50),
        );
        break;

    case 'deleteRoom':
        $params = array(
            'room_id' => 36,
        );
        break;

    case 'getUsers':
        $params = array();
        break;

    case 'getUser':
        $params = array(
            'user_id' => 11888,
        );
        break;

    case 'createUser':
        $params = array(
            'username' => time(),
//            'nickname' => 'User ' . rand(1, 100),
            'password' => rand(8, 10),
            'fname' => 'First name',
            'lname' => 'Last name',
            'is_public' => true,
        );
        break;

    case 'updateUser':
        $params = array(
            'user_id' => 31,
            'name' => time(),
            'title' => 'User ' . rand(1, 100),
            'max_users' => rand(2, 50),
        );
        break;

    case 'deleteUser':
        $params = array(
            'user_id' => 36,
        );
        break;

    default:
        $params = array();
}
$result = $api->call($action, $params);

if (Skyroom\HttpError::IsError($result)) {
    printf('<pre>%s (%d)</pre>', $result->getMessage(), $result->getCode());
} else {
    output($result);
}

/**
 * Prints data in a human readable format
 * @param   array   $data   Output data
 */
function output($data) {
    header('Content-Type: application/json');
    print(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
