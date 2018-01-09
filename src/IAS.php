<?php namespace InZernetTechnologies\IAS;
use InZernetTechnologies\IAS\Builder\JWT;
use InZernetTechnologies\IAS\Builder\request;
use InZernetTechnologies\IAS\Exceptions\invalidResponse;
use InZernetTechnologies\IAS\Options\API\get_options;
use InZernetTechnologies\IAS\Options\API\options;

class IAS {

    private $IAS_SECRET = "H5=aPr8ra2u#rAPHu+!8uv4Y3daqu&+u\$u?H5mu8aSPuwRawuSAheswutab8treDta3athATr_zEPruRetawruHujuxespas?rUyE6a\$W+ThebRaSuTHUGEpRub78-6+";
    private $IAS_APPLICATION = "5a2b514ff508bf217c103478";

    public function loginRequest($return = false, $callbackType, $callbackURL, array $create = array(), array $permissions = array()){

        $request = new request();
        $request->setIssuer($this->IAS_APPLICATION);
        $request->setCallbackType($callbackType);
        $request->setCallbackURL($callbackURL);
        $request->setRequestCreate($create);
        $request->setRequestPermissions($permissions);

        $requestArray = $request->build();

        $JWT = new JWT(null);
        $JWT->setSecret($this->IAS_SECRET);
        $requestJWT = $JWT->encode($requestArray);

        if ($return){
            return "http://ias.inzernettechnologies.com/login/" . $requestJWT;
        } else {
            header("Location: http://ias.inzernettechnologies.com/login/" . $requestJWT);
        }
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

        return (string) $token;
    }

    public function get($token){
        return new options($token, "get");
    }

    public function set($token){
        return new options($token, "post");
    }
}