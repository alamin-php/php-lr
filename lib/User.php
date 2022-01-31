<?php 
    include_once "Session.php";
    include "Database.php";

    class User {
        private $db;

        public function __construct(){
            $this->db = new Database();
        }

        // ---------------------Registration --------------------
        public function userRegistration($data){
            $name       = $this->validation($data['name']);
            $username   = $this->validation($data['username']);
            $email      = $this->validation($data['email']);
            $password   = $this->validation($data['password']);

            $user_chk  = $this->checkUser($username);
            $email_chk  = $this->checkEmail($email);

            if($name == "" OR $username == "" OR $email == "" OR ($password == "" && empty($password)) ){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Field must not be Empty</div>";
                return $msg;
            }

            if(strlen($username) < 3){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Username is too Short</div>";
                return $msg;
            }elseif(preg_match("/[^a-z0-9_-]+/i", $username)){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Username must only content alphanmerical, dashes and underscores!</div>";
                return $msg;
            }elseif($user_chk == true){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>The Username is already Exits.!</div>";
                return $msg;
            }

            if(filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>The email address is not valid!</div>";
                return $msg;
            }

            if($email_chk == true){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>The email address is already Exits.</div>";
                return $msg;
            }
            if(strlen($password) < 3){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Password too much short.</div>";
                return $msg;
            }

            // ---------------------Insert to database users data --------------------

            $sql = "INSERT INTO tbl_user (name, username, email, password) VALUES(:name, :username, :email, :password)";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':name', ucfirst($name));
            $query->bindValue(':username', strtolower($username));
            $query->bindValue(':email', strtolower($email));
            $query->bindValue(':password', md5($password));
            $result = $query->execute();
            if($result){
                $msg = "<div class='alert alert-success'><strong>Success ! </strong>Thank you, You have been registered.</div>";
                return $msg;
            }else{
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Sorry, there has been problem inserting your details!</div>";
                return $msg;
            }
        }

        // ---------------------Login--------------------

        public function getLoginUser($email, $password){
            $sql = "SELECT * FROM tbl_user WHERE email = :email AND password = :password LIMIT 1";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':email', $email);
            $query->bindValue(':password', $password);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_OBJ);
            return $result;
        }

        public function userLogin($data){
            $email      = $data['email'];
            $password   = md5($data['password']);

            $email_chk  = $this->checkEmail($email);

            if(($email == "" AND empty($password) ) OR ($password == "" AND empty($password))){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Field must not be Empty</div>";
                return $msg;
            }

            if(filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>The email address is not valid!</div>";
                return $msg;
            }

            if($email_chk == false){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>The email address is not Exits.</div>";
                return $msg;
            }

            $result = $this->getLoginUser($email, $password);
            if($result){
                Session::init();
                Session::set('login', true);
                Session::set('id', $result->id);
                Session::set('name', $result->name);
                Session::set('username', $result->username);
                Session::set('loginmsg', "<div class='alert alert-success'><strong>Success ! </strong>You are LoggedIn.</div>");
                header('Location: index.php');
            }else{
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Data not found!</div>";
                return $msg;
            }
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

        // ---------------------Field Validation --------------------
        public function validation($data){
            $data = trim($data);
            $data = htmlspecialchars($data);
            $data = stripslashes($data);
            return $data;
        }

    }
?>