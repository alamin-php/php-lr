<?php 
    include "inc/header.php";
    include "lib/User.php";
    $user = new User();
?>
<div class="card  mt-3">
    <div class="card-header">
                <h2>User List <span class="float-right">Welcome! <strong>alamin</strong></span></h2>
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
                        <tr>
                            <th scope="row">1</th>
                            <td>Mark</td>
                            <td>mark</td>
                            <td>mark@gmail.com</td>
                            <td>
                                <a href="#" class="btn btn-primary">View</a>
                            </td>
                        </tr>
                    </tbody>
                    <tr>
                        <th scope="row">2</th>
                        <td>Johan Due</td>
                        <td>johan</td>
                        <td>johan@gmail.com</td>
                        <td>
                            <a href="#" class="btn btn-primary">View</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="card-footer">
                <h3>Website: www.al-aminsarekr.com <span class="float-right">Link Us: www.facebook.com/devAlamin</span></h3>
            </div>
        </div>
<?php include "inc/footer.php" ?>
   