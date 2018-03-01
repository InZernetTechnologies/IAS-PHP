<?php namespace InZernetTechnologies\IAS\Builder;

use InZernetTechnologies\IAS\Options\callbackType;

class request {

    private $request;
    private $time;
    private $iss;

    public function __construct() {
        $this->time = time();
        $this->request = array(
            "iss" => null,
            "exp" => strtotime("+1 hour", $this->time),
            "iat" => time(),
            "jti" => null,
            "typ" => "request",
            "request" => array (
                "create" => array(),
                "permissions" => array(),
                "use" => array()
            ),
            "callback" => array (
                "type" => null,
                "url" => null,
            )
        );
    }

    public function setIssuer($issuer){
        $this->iss = $issuer;
    }

    public function setCallbackType($callbackType){
        $this->request["callback"]["type"] = $callbackType;
    }

    public function setCallbackURL($url){
        $this->request["callback"]["url"] = $url;
    }

    public function setRequestCreate(array $create){
        $this->request["request"]["create"] = $create;
    }
    public function setRequestUse(array $use){
        $this->request["request"]["use"] = $use;
    }

    public function setRequestPermissions(array $permissions){
        $this->request["request"]["permissions"] = $permissions;
    }

    public function build(){
        $this->request["jti"] = uniqid($this->iss);
        $this->request["iss"] = $this->iss;
        return $this->request;
    }
}

