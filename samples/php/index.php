<?php
/**
 * Sample Implementation of the Skyroom Web Service
 *
 * @copyright  Skyroom.online
 */

require_once 'api/Skyroom.php';

if (empty($_POST)) {
    $markup = file_get_contents('asset/form.html');
    $markup = str_replace('{{version}}', Skyroom::VERSION, $markup);
    print($markup);
  exit;
}

$apiUrl = $_POST['api_url'];
if (empty($apiUrl)) {
    print('<pre>No API key is provided!</pre>');
    return;
}

$api = new Skyroom($apiUrl);
$action = $_POST['action'];
switch ($action) {
    case 'getServices':
        $params = array();
        break;

    case 'getRooms':
        $params = array();
        break;

    case 'countRooms':
        $params = array();
        break;

    case 'getRoom':
        $params = array(
            'room_id' => 1,
        );
        break;

    case 'getRoomUrl':
        $params = array(
            'room_id' => 1,
            'relative' => true,
            'language' => 'fa',
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
            'room_id' => 1,
            'time_limit' => 3600,
            'session_duration' => 120,
        );
        break;

    case 'deleteRoom':
        $params = array(
            'room_id' => 1,
        );
        break;

    case 'getRoomUsers':
        $params = array(
            'room_id' => 1,
        );
        break;

    case 'addRoomUsers':
        $params = array(
            'room_id' => 1,
            'users' => array(
                array('user_id' => 5, 'access' => Skyroom::USER_ACCESS_PRESENTER),
            ),
        );
        break;

    case 'removeRoomUsers':
        $params = array(
            'room_id' => 1,
            'users' => array(6344, 6345),
        );
        break;

    case 'updateRoomUser':
        $params = array(
            'room_id' => 1,
            'user_id' => 5,
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
            'user_id' => 5,
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
            'user_id' => 5,
        );
        break;

    case 'deleteUser':
        $params = array(
            'user_id' => 5,
        );
        break;

    case 'getUserRooms':
        $params = array(
            'user_id' => 5,
        );
        break;

    case 'addUserRooms':
        $params = array(
            'user_id' => 5,
            'rooms' => array(
                array('room_id' => 1),
                array('room_id' => 2, 'access' => Skyroom::USER_ACCESS_PRESENTER),
            ),
        );
        break;

    case 'removeUserRooms':
        $params = array(
            'user_id' => 5,
            'rooms' => array(1, 2),
        );
        break;

    case 'getLoginUrl':
        $params = array(
            'room_id' => 1,
            'user_id' => 5,
            'language' => 'fa',
            'ttl' => 60,
        );
        break;

    case 'createLoginUrl':
        $params = array(
            'room_id' => 1,
            'user_id' => 'sina',
            'language' => 'en',
            'nickname' => 'Sina',
            'access' => 2,
            'concurrent' => 1,
            'ttl' => 3600,
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
