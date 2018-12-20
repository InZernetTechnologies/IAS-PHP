<?php namespace InZernetTechnologies\IAS;
use InZernetTechnologies\IAS\Builder\JWT;
use InZernetTechnologies\IAS\Builder\loginRequest;
use InZernetTechnologies\IAS\Exceptions\invalidResponse;

class IAS {

    private $application;
    private $secret;

    public function __construct($secret = null, $application = null){
        $this->secret = $secret;
        $this->application = $application;
        return $this;
    }

    public function setSecret($secret){
        $this->secret = $secret;
        return $this;
    }

    public function getApplication(){
        return $this->application;
    }

    public function getSecret(){
        return $this->secret;
    }

    public function setApplication($application){
        $this->application = $application;
        return $this;
    }

    public function loginRequest($return = false){
        $loginRequest = new loginRequest($return, $this->secret);
        $loginRequest->setIssuer($this->application);
        return $loginRequest;
    }

    public function loginResponse(){

        $token = (isset($_GET["token"]) ? $_GET["token"] : (isset($_POST["token"]) ? $_POST["token"] : null));

        if ($token == null){
            throw new invalidResponse("Did not receive an IAS token");
        }

        $JWT = new JWT($token);
        if (!$JWT->softCheckResponse()){
            throw new invalidResponse("Invalid token: " . $JWT->getLastError());
        }

        return new Token($token);
    }
}
