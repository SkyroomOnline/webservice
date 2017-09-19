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

    public function call($action, $options = array()) {
        $options['action'] = $action;
        try {
            return $this->http->post($options);
        } catch (Exception $e) {
            return new Skyroom\HttpError($e->getMessage(), $e->getCode());
        }
    }
}
