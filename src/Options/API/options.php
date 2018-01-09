<?php namespace InZernetTechnologies\IAS\Options\API;
use InZernetTechnologies\IAS\Builder\web;

class options {

    private $type;
    private $token;
    private $web;

    public function __construct($token, $type) {
        $this->token = $token;
        switch($type) {
            case "get":
                $this->type = "get";
                $this->web = $this->setupGET();
                break;
            case "post":
                $this->type = "post";
                break;
        }
    }

    public function first_name(){
        $this->web->buildURL("user", "name_first");
        $result = $this->web->execute();
        return $result["name_first"];
    }

    public function middle_name(){

    }

    public function last_name(){
        $this->web->buildURL("user", "name_last");
        $result = $this->web->execute();
        return $result["name_last"];
    }

    private function setupGET(){
        $web = new web($this->token);
        return $web;
    }

    private function setupPOST(){

    }

}