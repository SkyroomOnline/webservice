<?php
/**
 * Skyroom Web Service API
 *
 * @version     1.0
 * @copyright   Skyroom.ir
 */

interface SkyroomApi
{
    public function getRooms($serviceId);
}

class Skyroom implements SkyroomApi
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
        $params['action'] = $action;
        try {
            return $this->http->post($params);
        } catch (Exception $e) {
            return new Skyroom\HttpError($e->getMessage(), $e->getCode());
        }
    }

    public function getRooms($data) {
        $data['action'] = 'getRooms';
        return $this->call($data);
    }

    public function getRoom($roomId) {
        $data = array(
            'action' => 'getRoom',
            'room_id' => $roomId
        );

        return $this->call($data);
    }
}
