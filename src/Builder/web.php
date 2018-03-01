<?php namespace InZernetTechnologies\IAS\Builder;
class web {

    private $curl;
    private $output;
    private $status;
    private $token;
    private $APIver = 100;
    private $base_url = "http://localhost/IAS-API/public";
    private $debug;


    public function __construct($token) {
        $this->curl = curl_init();
        $this->token = $token;
    }

    public function buildURL($endpoint, $data){
        curl_setopt($this->curl, CURLOPT_URL, "$this->base_url/api/$endpoint/$data");
    }

    public function setType($type){
        curl_setopt($this->curl, CURLOPT_CUSTOMREQUEST, $type);
    }

    public function setPOST($fields){
        if (!is_array($fields)){
            curl_setopt($this->curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
        }
        curl_setopt($this->curl, CURLOPT_POSTFIELDS, $fields);
    }

    private function beforeExecute(){
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_HTTPHEADER, array("Authorization: Bearer " . $this->token));
    }

    public function getCode(){
        return $this->status;
    }

    public function debug($status){
        $this->debug = $status;
    }

    public function execute(){
        $this->beforeExecute();
        $this->output = curl_exec($this->curl);
        $this->status = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);
        if ($this->debug){
            print_r($this->output);
            return $this->output;
        }
        curl_close($this->curl);
        return json_decode($this->output, true);
    }

    public function checkResult(){
        if ($this->status != 200){
            return false;
        }
        $json = json_decode($this->output, true);
        if ($json["status"] == false ){
            return false;
        }
    }

}