<?php 
    include "Database.php";

    class User {
        public $name;
        public $username;
        public $email;
        public $password;
        private $db;

        public function __construct(){
            $this->db = new Database();
        }

        // ---------------------Registration --------------------
        public function userRegistration($data){
            $this->name       = $this->validation($data['name']);
            $this->username   = $this->validation($data['username']);
            $this->email      = $this->validation($data['email']);
            $this->password   = $this->validation($data['password']);

            $user_chk  = $this->checkUser($this->username);
            $email_chk  = $this->checkEmail($this->email);

            if($this->name == "" OR $this->username == "" OR $this->email == "" OR ($this->password == "" && empty($this->password)) ){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Field must not be Empty</div>";
                return $msg;
            }

            if(strlen($this->username) < 3){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Username is too Short</div>";
                return $msg;
            }elseif(preg_match("/[^a-z0-9_-]+/i", $this->username)){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Username must only content alphanmerical, dashes and underscores!</div>";
                return $msg;
            }elseif($user_chk == true){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>The Username is already Exits.!</div>";
                return $msg;
            }

            if(filter_var($this->email, FILTER_VALIDATE_EMAIL) == FALSE){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>The email address is not valid!</div>";
                return $msg;
            }

            if($email_chk == true){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>The email address is already Exits.</div>";
                return $msg;
            }
            if(strlen($this->password) < 3){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Password too much short.</div>";
                return $msg;
            }

            $dataInsert = $this->insert();

            if($dataInsert){
                $msg = "<div class='alert alert-success'><strong>Success ! </strong>Thank you, You have been registered.</div>";
                return $msg;
            }else{
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Sorry, there has been problem inserting your details!</div>";
                return $msg;
            }

        }

        // ---------------------Login--------------------
        public function userLogin($data){
            $this->email      = $this->validation($data['email']);
            $this->password   = $this->validation($data['password']);

            $email_chk  = $this->checkEmail($this->email);
            $password_chk  = $this->checkPassword($password);

            if(($this->email == "" AND empty($this->password) ) OR ($this->password == "" AND empty($this->password))){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Field must not be Empty</div>";
                return $msg;
            }

            if($email_chk == false){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>The email address is not Exits.</div>";
                return $msg;
            }

            if($password_chk == false){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Your password is Wrong. Please check & again try.</div>";
                return $msg;
            }
        }
        
        // ---------------------Insert to database users data --------------------
        public function insert(){
            $sql = "INSERT INTO tbl_user (name, username, email, password) VALUES(:name, :username, :email, :password)";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':name', ucfirst($this->name));
            $query->bindValue(':username', strtolower($this->username));
            $query->bindValue(':email', strtolower($this->email));
            $query->bindValue(':password', md5($this->password));
            $result = $query->execute();
            return $result;
        }

        // ---------------------Get all users data --------------------
        public function readAll(){
            $sql = "SELECT * FROM tbl_user";
            $query = $this->db->pdo->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        }

        // ---------------------Username checking --------------------
        public function checkUser($username){
            $sql = "SELECT username FROM tbl_user WHERE username=:username";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':username', $username);
            $query->execute();
            $result = $query->rowCount();
            if($result > 0){
                return true;
            }else{
                return false;
            }
        }

        // ---------------------Email checking --------------------
        public function checkEmail($email){
            $sql = "SELECT email FROM tbl_user WHERE email=:email";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':email', $email);
            $query->execute();
            $result = $query->rowCount();
            if($result > 0){
                return true;
            }else{
                return false;
            }
        }

        // ---------------------Password checking --------------------
        public function checkPassword($password){
            $password = md5($password);
            $sql = "SELECT password FROM tbl_user WHERE password=:password";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':password', $password);
            $query->execute();
            $result = $query->rowCount();
            if($result > 0){
                return true;
            }else{
                return false;
            }
        }

        // ---------------------Field Validation --------------------
        public function validation($data){
            $data = trim($data);
            $data = htmlspecialchars($data);
            $data = stripslashes($data);
            return $data;
        }

    }
?>