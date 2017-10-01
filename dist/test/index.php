<?php
/**
 * Sample Implementation of the Skyroom Web Service
 *
 * @version     1.0
 * @copyright   Skyroom.ir
 */

require_once '../api/Skyroom.php';
define('BASE_URL', 'https://test.skyroom.ir/skyroom/api/');

if (empty($_POST)) {
    $markup = file_get_contents('form.html');
    $markup = str_replace('{{base_url}}', BASE_URL, $markup);
    $markup = str_replace('{{version}}', Skyroom::VERSION, $markup);
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
    case 'getRooms':
        $params = array();
        break;

    case 'countRooms':
        $params = array();
        break;

    case 'getRoom':
        $params = array(
            'room_id' => 1175,
        );
        break;

    case 'getRoomUrl':
        $params = array(
            'room_id' => 1175,
            'relative' => true,
        );
        break;

    case 'createRoom':
        $params = array(
            'name' => 'room-' . time(),
            'title' => 'Room ' . rand(1, 100),
            'max_users' => rand(2, 50),
            'guest_login' => true,
        );
        break;

    case 'updateRoom':
        $params = array(
            'room_id' => 1178,
        );
        break;

    case 'deleteRoom':
        $params = array(
            'room_id' => 1177,
        );
        break;

    case 'getRoomUsers':
        $params = array(
            'room_id' => 1175,
        );
        break;

    case 'addRoomUsers':
        $params = array(
            'room_id' => 1175,
            'users' => array(
                array('user_id' => 6344),
                array('user_id' => 6345, 'access' => Skyroom::USER_ACCESS_PRESENTER),
            ),
        );
        break;

    case 'removeRoomUsers':
        $params = array(
            'room_id' => 1175,
            'users' => array(6344, 6345),
        );
        break;

    case 'updateRoomUser':
        $params = array(
            'room_id' => 1175,
            'user_id' => 6344,
            'access' => Skyroom::USER_ACCESS_OPERATOR,
        );
        break;

    case 'getUsers':
        $params = array();
        break;

    case 'countUsers':
        $params = array();
        break;

    case 'getUser':
        $params = array(
            'user_id' => 6361,
        );
        break;

    case 'createUser':
        $params = array(
            'username' => 'user-' . time(),
            'nickname' => 'User ' . rand(1, 100),
            'password' => rand(8, 10),
            'email' => 'test@gmail.com',
            'fname' => 'First name',
            'lname' => 'Last name',
            'is_public' => true,
        );
        break;

    case 'updateUser':
        $params = array(
            'user_id' => 6361,
        );
        break;

    case 'deleteUser':
        $params = array(
            'user_id' => 6346,
        );
        break;

    case 'getUserRooms':
        $params = array(
            'user_id' => 6347,
        );
        break;

    case 'addUserRooms':
        $params = array(
            'user_id' => 6347,
            'rooms' => array(
                array('room_id' => 1175),
                array('room_id' => 1174, 'access' => Skyroom::USER_ACCESS_PRESENTER),
            ),
        );
        break;

    case 'removeUserRooms':
        $params = array(
            'user_id' => 6347,
            'rooms' => array(1175, 1179),
        );
        break;

    case 'getLoginUrl':
        $params = array(
            'room_id' => 1174,
            'user_id' => 6347,
            'ttl' => 60,
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
    print(json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ));
}
