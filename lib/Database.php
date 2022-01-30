<?php
    class Database{
        private $db_host = "localhost";
        private $db_name = "db_lr";
        private $db_user = "root";
        private $db_pass = "";
        public $pdo;
        public function __construct(){
            if(!isset($this->pdo)){
                try{
                    $link = new PDO("mysql:dbname=".$this->db_host."; dbname=".$this->db_name, $this->db_user, $this->db_pass);
                    $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $this->pdo = $link;
                }catch(PDOExecption $e){
                    die("Connection fail".$e->getMessage());
                }
            }
        }
    }
?>