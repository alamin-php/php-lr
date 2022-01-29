<?php 
    include_once "Config.php";
    class DB{
        private static $pdo;

        public static function connection(){
            if(!isset(self::$pdo)){
                try{
                    self::$pdo = new PDO("mysql:dbname=".DB_HOST."; dbname=".DB_NAME, DB_USER, DB_PASS);
                }catch(PDOExecption $e){
                    die("Connection fail".$e->getMessage());
                }
                return self::$pdo;
            }
        }

        public static function prepare($sql){
            return self::connection()->prepare($sql);
        }
    }
?>