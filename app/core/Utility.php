<?php

class Utility{

    /**
     * JSON Output
     */
    static public function response(int $status,$data): string
    {
        $success = ($status >= 200 && $status <= 300) ? true : false;
        $varData = ($status <= 300 && is_array($data)) ? 'data' : 'message';
        
        $jsonOutput['success'] = $success;
        $jsonOutput[$varData]  = $data;
        
        http_response_code($status);
        echo json_encode($jsonOutput);
        die;
    }

    static public function reqMethodCheck(string $method): void
    {
        if($_SERVER['REQUEST_METHOD'] !== $method){
            self::response(400,"invalid method ".$_SERVER['REQUEST_METHOD']."!");
        }
    }

}