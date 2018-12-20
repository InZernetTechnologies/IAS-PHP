<?php namespace InZernetTechnologies\IAS;
class Token {

    private $token;
    private $header;
    private $payload;
    private $signature;

    public function __construct($token){
        $this->token = $token;
        $this->set();
    }

    public function getData(){
        return $this->payload;
    }

    private function set($return = false){
        $tks = explode('.', $this->token);
        if ($return){
            return $tks;
        }
        $this->header = json_decode(base64_decode($tks[0]), true);
        $this->payload = json_decode(base64_decode($tks[1]), true);
        $this->signature = json_decode(base64_decode($tks[2]), true);
    }

}
