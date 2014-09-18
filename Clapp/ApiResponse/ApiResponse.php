<?php

namespace Clapp\ApiResponse;

class ApiResponse implements \JsonSerializable
{

    // GENERAL ERROR MESSAGES
    const ERROR_GENERAL = 'error.general';
    const ERROR_LOGIN_FIELD_IS_REQUIRED = 'error.login_field_is_required';
    const ERROR_PASSWORD_FIELD_IS_REQUIRED = 'error.password_field_is_required';
    const ERROR_WRONG_PASSWORD = 'error.wrong_password';
    const ERROR_USER_DOES_NOT_EXISTS = 'error.user_does_not_exists';
    const ERROR_USER_IS_NOT_ACTIVATED = 'error.user_is_not_activated';
    const ERROR_USER_IS_ALREADY_EXISTS = 'error.user_is_already_exists';

    const ERROR_GAME_DOES_NOT_EXISTS = 'error.game_does_not_exists';

    const ERROR_SIGNIN_REQUIRED = 'error.signin_required';

    // GENERAL SUCCESS MESSAGES
    const SUCCESS_GENERAL = 'success.general';
    const SUCCESS_SIGNIN = 'success.signin';
    const SUCCESS_SIGNUP = 'success.signup';


    const ERROR_STATUS_NAME = 'error';
    const SUCCESS_STATUS_NAME = 'success';

    protected $status = '';
    protected $code = '';
    protected $data = array();
    protected $message = '';
    protected $response = array();
	
	/**
	 *  
	 *  @param $code (optional)
	 *   * string/int: error constant
	 *   * array/object: $data
	 *  default: self::ERROR_GENERAL
	 *  @param $message (optional)
	 *   * string: custom error message
	 *   * array/object: $data
	 *  default: null
	 *  @param $data (optional)
	 *   * array/object: data to be passed
	 *  default: null
	 */
	
    public function __construct($code = self::ERROR_GENERAL, $message = '', $data = array())
    {
		if (is_string($code) || is_numeric($code)){ //allow 
			if (!is_string($message)){
				if (is_string($data)){
					$tmp = $message;
					$message = $data;
					$data = $tmp;
				}else {
					$data = $message;
					$message = "";
				}
			}
		}else {
			if (!empty($code)){
				$data = $code;
				$code = self::SUCCESS_GENERAL;
				$message = "";
			}else {
				$code = self::ERROR_GENERAL;
				$data = array();
				$message = "";
			}
		}
		
		$this->setCode($code);
        $this->setMessage($message);
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