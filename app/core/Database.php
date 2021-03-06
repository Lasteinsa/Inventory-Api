<?php

class Database{
    public $dbh;
    public $stmt;
    private $db_host = 'remotemysql.com';
    private $db_name = 'tKJqSor9fp';
    private $db_user = 'tKJqSor9fp';
    private $db_pass = 'bb13ATOmBX';

    public function __construct()
    {
        $dsn = "mysql:host=$this->db_host;dbname=$this->db_name";

        $option = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];

        try{
            $this->dbh = new PDO($dsn,$this->db_user,$this->db_pass,$option);
        }
        catch(PDOException $e){
            header('Content-Type: application/json');
            http_response_code(500);
            $response = [
                "status"  => 500,
                "message" => $e->getMessage(),
            ];

            echo json_encode($response);
            die;
        }
    }

    public function query($query){
        $this->stmt = $this->dbh->prepare($query);
    }

    public function bind($param,$value,$type = null){
        if(is_null($type)){
            switch(true){
                case is_int($value) :
                    $type = PDO::PARAM_INT;
                break;
                case is_bool($value) :
                    $type = PDO::PARAM_BOOL;
                break;
                case is_null($value) : 
                    $type = PDO::PARAM_NULL;
                break;
                default : 
                    $type = PDO::PARAM_STR;
                break;                    
            }
        }
        $this->stmt->bindValue($param,$value,$type);
    }

    public function execute(){
        return $this->stmt->execute();
    }
    
    public function multiResult(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function singleResult(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount(){
        return $this->stmt->rowCount();
    }
}

?>