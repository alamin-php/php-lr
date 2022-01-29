<?php 
    include "inc/header.php";
    include "lib/User.php";
?>
<?php 
    $user = new User();

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])){
        $userRegi = $user->userRegistration($_POST);
    }
?>
<div class="card  mt-3">
    <div class="card-header">
        <h2>User Registration</h2>
    </div>
    <div class="card-body">
        <div style="max-width: 600px; margin: 0 auto;">
        <?php 
            if(isset($userRegi)){
                echo $userRegi;
            }
        ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" class="form-control" name="name" id="" aria-describedby="emailHelpId" placeholder="">
                </div>
                <div class="form-group">
                    <label for="">Username</label>
                    <input type="text" class="form-control" name="username" id="" aria-describedby="emailHelpId" placeholder="">
                </div>
                <div class="form-group">
                    <label for="">Email Address</label>
                    <input type="text" class="form-control" name="email" id="" aria-describedby="emailHelpId" placeholder="">
                </div>
                <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" class="form-control" name="password" id="" aria-describedby="emailHelpId"
                        placeholder="">
                </div>
                <button type="submit" name="register" class="btn btn-success">Registration</button>
            </form>
        </div>
    </div>
    <div class="card-footer">
        <h3>Website: www.al-aminsarekr.com <span class="float-right">Link Us: www.facebook.com/devAlamin</span></h3>
    </div>
</div>
<?php include "inc/footer.php" ?>