<?php
/**
 * Skyroom Web Service API
 *
 * @version     1.0
 * @copyright   Skyroom.ir
 */

class Skyroom
{
    const VERSION = '1.0';

    const SERVICE_STATUS_DISABLED = 0;
    const SERVICE_STATUS_ENABLED  = 1;

    const SERVICE_TYPE_GENERIC    = 0;
    const SERVICE_TYPE_MEETING    = 1;
    const SERVICE_TYPE_LEARNING   = 2;
    const SERVICE_TYPE_WEBINAR    = 3;

    const ROOM_STATUS_DISABLED    = 0;
    const ROOM_STATUS_ENABLED     = 1;

    const USER_STATUS_DISABLED    = 0;
    const USER_STATUS_ENABLED     = 1;

    const USER_ACCESS_BANNED      = -1;
    const USER_ACCESS_GUEST       = 0;
    const USER_ACCESS_NORMAL      = 1;
    const USER_ACCESS_PRESENTER   = 2;
    const USER_ACCESS_OPERATOR    = 3;
    const USER_ACCESS_ADMIN       = 6;

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
            'params' => json_encode($params),
        );
        try {
            return $this->http->post($data);
        } catch (Exception $e) {
            return new Skyroom\HttpError($e->getMessage(), $e->getCode());
        }
    }
}
