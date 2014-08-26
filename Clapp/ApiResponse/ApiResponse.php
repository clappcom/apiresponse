<?php

namespace Clapp\ApiResponse;

class ApiResponse
{

    const ERROR_STATUS_NAME = 'error';
    const SUCCESS_STATUS_NAME = 'success';

    protected $status = '';
    protected $code = '';
    protected $data = array();
    protected $message = '';
    protected $response = array();

    public function __construct($code, $message = '', $data = array())
    {
        $this->setCode($code);
        $this->setData($data);
        $this->setMessage($message);
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function getResponse()
    {
        return $this->formatResponse();
    }

    public function setCode($code)
    {
        switch (substr(strtolower($code), 0, 1)) {
            case 'e' :
                $this->status = self::ERROR_STATUS_NAME;
                break;

            case 's' :
                $this->status = self::SUCCESS_STATUS_NAME;
                break;

            default:
                throw new \Exception('First character of statusCode must be "e" or "s" character');
        }
        $this->code = $code;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setMessage($message)
    {
        $this->message = $message;
    }

    /*
     * {'status' : 'error|success', 'statusCode' : 'String'[, 'message' : 'string'[, 'data' : 'array']]}
     */

    protected function formatResponse()
    {
        $this->response['status'] = $this->status;
        $this->response['statusCode'] = $this->code;
        if (!empty($this->data))
            $this->response['data'] = $this->data;
        if (!empty($this->message))
            $this->response['message'] = $this->message;

        return $this->response;
    }

    public function toJSON()
    {
        throw new \Exception('Use own or framework JSON converter');
    }


}