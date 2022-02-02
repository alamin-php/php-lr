<?php 
    include "lib/User.php";
    include "inc/header.php";
    Session::checkSession();
    $user = new User();
?>
<?php 
    if(isset($_GET['id'])){
        $userId = (int) $_GET['id'];
    }
    $user = new User();
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['updatepass'])){
        $updatePass = $user->updateUserPass($userId, $_POST);
    }
    
?>
<div class="card  mt-3">
    <div class="card-header">
        <h2>User Profile <span><a href="profile.php?id=<?php echo $userId; ?>" class="btn btn-primary float-right">Back</a></span></h2>
    </div>
    <div class="card-body">
        <div style="max-width: 600px; margin: 0 auto;">
        <?php 
            if(isset($updatePass)){
                echo $updatePass;
            }
        ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="">Old Password</label>
                    <input type="password" class="form-control" name="old_pass">
                </div>
                <div class="form-group">
                    <label for="">New Password</label>
                    <input type="password" class="form-control" name="password">
                </div>
                <button type="submit" name="updatepass" class="btn btn-success">Update</button>
            </form>
        </div>
    </div>
    <div class="card-footer">
        <h3>Website: www.al-aminsarekr.com <span class="float-right">Link Us: www.facebook.com/devAlamin</span></h3>
    </div>
</div>
<?php include "inc/footer.php" ?>