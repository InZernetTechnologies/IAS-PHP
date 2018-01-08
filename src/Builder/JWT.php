<?php namespace InZernetTechnologies\IAS\Builder;

use Phalcon\Exception;

class JWT {
    private $jwt;
    private $payload;
    private $header;
    private $signature;
    private $secret;
    private $error;

    public function __construct($jwt = null, $secret = null){
        if ($jwt != null) {
            $this->jwt = $jwt;
            $this->secret = $secret;
            $this->setPayload();
        }
    }

    public function getPayload(){
        return $this->payload;
    }

    public function encode($data){
        try {
            return \Firebase\JWT\JWT::encode($data, $this->secret, "HS256");
        } catch (\Exception $exception){
            echo $exception->getMessage();
        }
    }

    public function getHeader(){
        return $this->header;
    }

    public function getSignature(){
        return $this->signature;
    }

    public function setSecret($secret){
        $this->secret = $secret;
    }

    public function getLastError(){
        return $this->error;
    }

    public function canDecode(){

        try {
            $jwtdecoded = \Firebase\JWT\JWT::decode($this->jwt, $this->secret, ["HS256"]);
            return true;
        } catch (\Firebase\JWT\SignatureInvalidException $e){
            $this->error = $e->getMessage();
            return false;
        } catch (\Firebase\JWT\ExpiredException $e){
            $this->error = $e->getMessage();
            return false;
        } catch (UnexpectedValueException $e){
            $this->error = $e->getMessage();
            return false;
        }
    }

    private function setPayload(){
        $tks = explode('.', $this->jwt);
        $this->payload = json_decode(base64_decode($tks[1]), true);
    }
}