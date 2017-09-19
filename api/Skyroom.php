<?php
/**
 * Skyroom Web Service API
 *
 * @version     1.0
 * @copyright   Skyroom.ir
 */

class Skyroom
{
    const Version = '1.0';
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
        $data = [
            'action' => $action,
            'params' => json_encode($params),
        ];
        try {
            return $this->http->post($data);
        } catch (Exception $e) {
            return new Skyroom\HttpError($e->getMessage(), $e->getCode());
        }
    }
}
