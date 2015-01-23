<?php

namespace Clapp\ApiResponse;

class ApiResponse implements \JsonSerializable
{
    const ERROR_GENERAL = 'error.general';
    const SUCCESS_GENERAL = 'success.general';

    const ERROR_STATUS_NAME = 'error';
    const SUCCESS_STATUS_NAME = 'success';

    protected $status = '';
    protected $code = '';
    protected $data = array();
    protected $function = '';
    protected $response = array();
	
	/**
	 *  
	 *  @param $code (optional)
	 *   * string/int: error constant
	 *   * array/object: $data
	 *  default: self::ERROR_GENERAL
	 *  @param $function (optional)
	 *   * string: name of the current api function
	 *   * array/object: $data
	 *  default: null
	 *  @param $data (optional)
	 *   * array/object: data to be passed
	 *  default: null
	 */
	
    public function __construct($code = self::ERROR_GENERAL, $function = '', $data = array())
    {
		if (is_string($code) || is_numeric($code)){ //allow 
			if (!is_string($function)){
				if (is_string($data)){
					$tmp = $function;
					$function = $data;
					$data = $tmp;
				}else {
					$data = $function;
					$function = "";
				}
			}
		}else {
			if (!empty($code)){
				$data = $code;
				$code = self::SUCCESS_GENERAL;
			}else {
				$code = self::ERROR_GENERAL;
				$data = array();
				$function = "";
			}
		}
		
		$this->setCode($code);
        $this->setFunction($function);
		$this->setData($data);
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

    public function jsonSerialize()
    {
        return $this->getResponse();
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function setFunction($function)
    {
        $this->function = $function;
    }

    /*
     * {'status' : 'error|success', 'statusCode' : 'String'[, 'function' : 'string'[, 'data' : 'array']]}
     */

    protected function formatResponse()
    {
        $this->response['status'] = $this->status;
        $this->response['statusCode'] = $this->code;
        if (!empty($this->data))
            $this->response['data'] = $this->data;
        if (!empty($this->function))
            $this->response['function'] = $this->function;

        return $this->response;
    }

    public function toJSON()
    {
        throw new \Exception('Use own or framework JSON converter');
    }


}