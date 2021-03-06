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
            if(strlen($password) < 6){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Password must be gaterthe 6 digit.</div>";
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

        // ---------------------Profile Update --------------------
        public function updateUserData($id, $data){
            $name       = $this->validation($data['name']);
            $username   = $this->validation($data['username']);
            $email      = $this->validation($data['email']);

            if($name == "" OR $username == "" OR $email == ""){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Field must not be Empty</div>";
                return $msg;
            }

            if(strlen($username) < 3){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Username is too Short</div>";
                return $msg;
            }elseif(preg_match("/[^a-z0-9_-]+/i", $username)){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Username must only content alphanmerical, dashes and underscores!</div>";
                return $msg;
            }

            if(filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>The email address is not valid!</div>";
                return $msg;
            }

            // ---------------------Update Profile to database users data --------------------

            $sql = "UPDATE tbl_user SET name = :name, username = :username, email = :email WHERE id =:id ";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':name', ucfirst($name));
            $query->bindValue(':username', strtolower($username));
            $query->bindValue(':email', strtolower($email));
            $query->bindValue(':id', $id);
            $result = $query->execute();
            if($result){
                $msg = "<div class='alert alert-success'><strong>Success ! </strong>Profile updated successfully.</div>";
                return $msg;
            }else{
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Sorry, there has been problem inserting your details!</div>";
                return $msg;
            }
        }

        // ---------------------Change user password --------------------
        public function updateUserPass($id, $data){
            $old_pass = md5($data['old_pass']);
            $new_pass = $data['password'];
            $password_chk = $this->checkPassword($id, $old_pass);

            if($old_pass == "" OR ($new_pass == "" AND empty($new_pass))){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Field must not be Empty</div>";
                return $msg;
            }
            if($password_chk == false){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Old password not Match</div>";
                return $msg;
            }
            if(strlen($new_pass) < 6){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Password must be gater then 6 digit.</div>";
                return $msg;
            }

            $sql = "UPDATE tbl_user SET password = :password WHERE id =:id ";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':password', md5($new_pass));
            $query->bindValue(':id', $id);
            $result = $query->execute();
            if($result){
                $msg = "<div class='alert alert-success'><strong>Success ! </strong>Password changed successfully.</div>";
                return $msg;
            }else{
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Sorry, Password not changed!</div>";
                return $msg;
            }

        }

        // ---------------------Get all users data --------------------
        public function getUserData(){
            $sql = "SELECT * FROM tbl_user ORDER BY id DESC";
            $query = $this->db->pdo->prepare($sql);
            $query->execute();
            return $query->fetchAll();
        }

        // ---------------------Get user data by ID --------------------
        public function getUserById($userId){
            $sql = "SELECT * FROM tbl_user where id = :id LIMIT 1";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':id', $userId);
            $query->execute();
            $result = $query->fetch(PDO::FETCH_OBJ);
            return $result;
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
        public function checkPassword($id, $password){
            $sql = "SELECT email FROM tbl_user WHERE password=:password AND id=:id";
            $query = $this->db->pdo->prepare($sql);
            $query->bindValue(':password', $password);
            $query->bindValue(':id', $id);
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