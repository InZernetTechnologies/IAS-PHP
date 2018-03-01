<?php namespace InZernetTechnologies\IAS\Builder;
class drop {

    private $id;
    private $token;

    public function __construct($id, $token){
        $this->id = $id;
        $this->token = $token;
    }

    public function get(){
        $web = new web($this->token);
        $web->buildURL("drop", $this->id);
        $data = $web->execute();
        print_r($data);
        if ($web->checkResult()){
            return $data["data"];
        } else {
            return null;
        }
    }

    public function patch($patch){
        $web = new web($this->token);
        $web->buildURL("drop", $this->id);
        $web->setType("PATCH");
        $web->setPOST($patch);
        $data = $web->execute();
        if ($web->checkResult()){
            return $data["data"];
        } else {
            return null;
        }
    }

    public function delete(){
        $web = new web($this->token);
        $web->buildURL("drop", $this->id);
        $web->setType("DELETE");
        $data = $web->execute();
        if ($web->getCode() == 200){
            return true;
        } else {
            return false;
        }
    }

    public function post($data){
        $web = new web($this->token);
        $web->buildURL("drop", $this->id);
        $web->setType("POST");
        $web->setPOST($data);
        $web->debug(true);
        $data = $web->execute();
        print_r($web->checkResult());
        if ($web->checkResult()){
            return $data["data"];
        } else {
            return null;
        }
    }

}