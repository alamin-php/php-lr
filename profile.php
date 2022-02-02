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
    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])){
        $updateProfile = $user->updateUserData($userId, $_POST);
    }
    
?>
<div class="card  mt-3">
    <div class="card-header">
        <h2>User Profile</h2>
    </div>
    <div class="card-body">
        <div style="max-width: 600px; margin: 0 auto;">
        <?php 
            if(isset($updateProfile)){
                echo $updateProfile;
            }
        ?>
            <?php 
            $userdata = $user->getUserById($userId);
            if($userdata){

        ?>
            <form action="" method="post">
                <div class="form-group">
                    <label for="">Your Name</label>
                    <input type="text" class="form-control" name="name" value="<?php echo $userdata->name; ?>">
                </div>
                <div class="form-group">
                    <label for="">Username</label>
                    <input type="text" class="form-control" name="username" value="<?php echo $userdata->username; ?>">
                </div>
                <div class="form-group">
                    <label for="">Email Address</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $userdata->email; ?>">
                </div>
                <?php 
                    $sesId = Session::get('id');
                    if($sesId == $userId){
                       
                ?>
                <button type="submit" name="update" class="btn btn-success">Update</button>
                <?php } ?>
            </form>
            <?php } ?>
        </div>
    </div>
    <div class="card-footer">
        <h3>Website: www.al-aminsarekr.com <span class="float-right">Link Us: www.facebook.com/devAlamin</span></h3>
    </div>
</div>
<?php include "inc/footer.php" ?>