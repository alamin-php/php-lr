<?php 
    include "inc/header.php";
    include "lib/User.php";
    Session::checkSession();
    $user = new User();
?>

<div class="my-3">
<?php 
    $loginmsg = Session::get('loginmsg');
    if(isset($loginmsg)){
        echo $loginmsg;
    }
    Session::set('loginmsg', NULL);
?>
</div>
<div class="card  mt-3">
    <div class="card-header">
                <h2>User List <span class="float-right">Welcome! <strong>
                    <?php 
                        $username = Session::get('username');
                        echo $username;
                    ?>
                </strong></span></h2>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">Serial</th>
                            <th scope="col">Name</th>
                            <th scope="col">Username</th>
                            <th scope="col">Email</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $i = 0;
                            $users = $user->readAll();
                            foreach($users as $value){
                            $i++;
                        ?>
                        <tr>
                            <th scope="row"><?php echo $i; ?></th>
                            <td><?php echo $value['name'] ?></td>
                            <td><?php echo $value['username'] ?></td>
                            <td><?php echo $value['email'] ?></td>
                            <td>
                                <a href="#" class="btn btn-primary">View</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
                <h3>Website: www.al-aminsarekr.com <span class="float-right">Link Us: www.facebook.com/devAlamin</span></h3>
            </div>
        </div>
<?php include "inc/footer.php" ?>
   