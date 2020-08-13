<?php
/**
 * Skyroom Web Service API
 *
 * @copyright   Skyroom.online
 */

class Skyroom
{
    const VERSION = '1.3.0';

    const ROOM_STATUS_DISABLED   = 0;
    const ROOM_STATUS_ENABLED    = 1;

    const USER_STATUS_DISABLED   = 0;
    const USER_STATUS_ENABLED    = 1;

    const USER_GENDER_UNKNOWN    = 0;
    const USER_GENDER_MALE       = 1;
    const USER_GENDER_FEMALE     = 2;

    const USER_ACCESS_NORMAL     = 1;
    const USER_ACCESS_PRESENTER  = 2;
    const USER_ACCESS_OPERATOR   = 3;
    const USER_ACCESS_ADMIN      = 4;

    private $http;

    /**
     * Constructor
     *
     * @access  public
     * @param   string  $url    Web service URL
     */
    public function __construct($url)
    {
        require_once 'HttpRequest.php';
        $this->http = new Skyroom\HttpRequest($url);
    }

    public function call($action, $params = array()) {
        $data = array(
            'action' => $action,
            'params' => $params,
        );
        try {
            return $this->http->post(json_encode($data));
        } catch (Exception $e) {
            return new Skyroom\HttpError($e->getMessage(), $e->getCode());
        }
    }
}
