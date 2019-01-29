<?php
require_once APPPATH.'/libraries/JWT.php';

class JWT_Imp {

    PRIVATE $key = "1fuh2rh3f98hfn3r99cnwo2";

    public function GenerateToken($data){
        $jwt = JWT::encode($data, $this->key);
        return $jwt;
    }

    public function DecodeToken($token){
        // try{
            $decoded = JWT::decode($token, $this->key, array('HS256'));
            $decodedData = (array)$decoded;
            return $decodedData;
        // } catch (Exception $e){
        //     return "Error invalid credentials";
        // }
        
    }
}




?>