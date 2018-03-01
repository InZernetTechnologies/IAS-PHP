<?php namespace InZernetTechnologies\IAS\Builder;

class loginRequest {
    private $iss;
    private $return;
    private $secret;

    private $callback_type;
    private $callback_url;

    private $create = array();
    private $permission = array();
    private $use = array();

    public function __construct($return, $secret) {
        $this->return = $return;
        $this->secret = $secret;
        return $this;
    }

    public function setSecret($secret){
        $this->secret = $secret;
        return $this;
    }

    public function setReturn($return){
        $this->return = $return;
        return $this;
    }

    public function setIssuer($issuer){
        $this->iss = $issuer;
        return $this;
    }

    public function setCallbackType($type){
        $this->callback_type = $type;
        return $this;
    }

    public function setCallbackURL($url){
        $this->callback_url = $url;
        return $this;
    }

    public function addCreate($endpoint){
        array_push($this->create, $endpoint);
        return $this;
    }

    public function setCreate(array $create){
        $this->create = $create;
        return $this;
    }

    public function addPermission($permission, $access){
        $this->permission[$permission] = $access;
        return $this;
    }

    public function setPermission(array $permissions){
        $this->permission = $permissions;
        return $this;
    }

    public function addUse($api){
        array_push($this->use, $api);
        return $this;
    }

    public function setUse(array $api){
        $this->use = $api;
        return $this;
    }

    public function __toString() {
        $request = new \InZernetTechnologies\IAS\Builder\request();
        $request->setIssuer($this->iss);
        $request->setCallbackType($this->callback_type);
        $request->setCallbackURL($this->callback_url);
        $request->setRequestCreate($this->create);
        $request->setRequestPermissions($this->permission);
        $request->setRequestUse($this->use);

        $requestArray = $request->build();

        $JWT = new JWT(null);
        $JWT->setSecret($this->secret);
        $requestJWT = $JWT->encode($requestArray);

        if ($this->return){
            return "http://ias.inzernettechnologies.com/login/" . $requestJWT;
        } else {
            header("Location: http://ias.inzernettechnologies.com/login/" . $requestJWT);
            return "";
        }
    }

}