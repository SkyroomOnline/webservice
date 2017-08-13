<?php
/**
 * Sample Implementation of Skyroom Web Service
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
    case 'getRooms':
        $params = array(
            'customer_id' => 1,
        );
        break;

    case 'getRoom':
        $params = array(
            'room_id' => 1,
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
