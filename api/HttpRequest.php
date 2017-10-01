<?php
/**
 * HTTP Request implementation using cURL
 *
 * @version     1.0
 * @copyright   Skyroom.ir
 */

namespace Skyroom;

class HttpRequest
{
    private $url;

    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Prepares and sends the request to the server via HTTP POST
     *
     * @param   array   $data Request params
     * @return  array   Response array
     * @throws  HttpException
     * @throws  JsonException
     * @throws  NetworkException
     */
    public function post($data)
    {
        $queryString = '';
        if (!is_null($data)) {
            foreach($data as $key => $value) {
                $queryString .= $key . '=' . $value . '&';
            }
            $queryString = rtrim($queryString, '&');
        }

        // set request options
        $curl = curl_init($this->url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $queryString);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array (
            'Accept: application/json',
            'Content-Type: application/x-www-form-urlencoded',
        ));

        // make the request
        $response = curl_exec($curl);
        $errNo = curl_errno($curl);
        if ($errNo !== 0) {
            throw new NetworkException(curl_error($curl), $errNo);
        }

        // check HTTP status code
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($http_code !== 200) {
            throw new HttpException('HTTP Error', $http_code);
        }

        // decode JSON response
        $response = json_decode($response, true);
        if ($response === null) {
            throw new JsonException('Invalid Response', json_last_error());
        }

        return $response;
    }
}

class HttpError
{
    private $code;
    private $message;

    function __construct($message, $code = 0) {
        $this->code = $code;
        $this->message = $message;
    }

    function getCode() {
        return $this->code;
    }

    function getMessage() {
        return $this->message;
    }

    static function IsError(&$input) {
        return is_object($input) && (get_class($input) === 'Skyroom\HttpError');
    }
}

class NetworkException extends \Exception
{
    public function __toString() {
        return __CLASS__ . ": {$this->message}\n";
    }
}

class HttpException extends \Exception
{
    public function __toString() {
        return __CLASS__ . ": {$this->message}\n";
    }
}

class JsonException extends \Exception
{
    public function __toString() {
        return __CLASS__ . ": {$this->message}\n";
    }
}
