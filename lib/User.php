<?php 
    include "DB.php";

    class User {
        public function userRegistration($data){
            $name       = $data['name'];
            $username   = $data['username'];
            $email      = $data['email'];
            $password   = md5($data['password']);

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
            }

            if(filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE){
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>The email address is not valid!</div>";
                return $msg;
            }

            $sql = "INSERT INTO tbl_user (name, username, email, password) VALUES(:name, :username, :email, :password)";
            $query = DB::prepare($sql);
            $query->bindValue(':name', $name);
            $query->bindValue(':username', $username);
            $query->bindValue(':email', $email);
            $query->bindValue(':password', $password);
            $result = $query->execute();
            if($result){
                $msg = "<div class='alert alert-success'><strong>Success ! </strong>Thank you, You have been registered.</div>";
                return $msg;
            }else{
                $msg = "<div class='alert alert-danger'><strong>Error ! </strong>Sorry, there has been problem inserting your details!</div>";
                return $msg;
            }

        }

    }
?>