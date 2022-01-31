<?php 
    include "inc/header.php";
    Session::checkSession();
?>
<div class="card  mt-3">
    <div class="card-header">
        <h2>User Profile</h2>
    </div>
    <div class="card-body">
        <div style="max-width: 600px; margin: 0 auto;">
                <div class="form-group">
                    <label for="">Your Name</label>
                    <input type="text" class="form-control" name="name" value="Al Amin Sarker">
                </div>
                <div class="form-group">
                    <label for="">Username</label>
                    <input type="text" class="form-control" name="username" value="alamin">
                </div>
                <div class="form-group">
                    <label for="">Email Address</label>
                    <input type="email" class="form-control" name="email" value="alamin@gmail.com">
                </div>
                <button type="submit" name="profile" class="btn btn-success">Update</button>
        </div>
    </div>
    <div class="card-footer">
        <h3>Website: www.al-aminsarekr.com <span class="float-right">Link Us: www.facebook.com/devAlamin</span></h3>
    </div>
</div>
<?php include "inc/footer.php" ?>