<?php include "inc/header.php" ?>
<div class="card  mt-3">
    <div class="card-header">
        <h2>Change Password</h2>
    </div>
    <div class="card-body">
        <div style="max-width: 600px; margin: 0 auto;">
            <form action="" method="post">
                <div class="form-group">
                    <label for="">Old Password</label>
                    <input type="password" class="form-control" name="oldpass" >
                </div>
                <div class="form-group">
                    <label for="">New Password</label>
                    <input type="password" class="form-control" name="newpass" >
                </div>
                <div class="form-group">
                    <label for="">Confirm Password</label>
                    <input type="password" class="form-control" name="confirmpass" >
                </div>
                <button type="submit" name="changepass" class="btn btn-success">Change</button>
            </form>
        </div>
    </div>
    <div class="card-footer">
        <h3>Website: www.al-aminsarekr.com <span class="float-right">Link Us: www.facebook.com/devAlamin</span></h3>
    </div>
</div>
<?php include "inc/footer.php" ?>