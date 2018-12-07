<?php
    include_once("htmlStart.php");
    include_once("navbar.php");
    include('connect.php'); // to create db
?>
    <div class="card">
        <div class="card-header border-info">
            <h2>Login or Register</h2>
        </div>
        <div class="card-body">
            <div class="form-group col-md-6">
                <button type="button" class="btn btn-info" onclick="location.href='loginForm.php'">Login</button>
            </div>
            <div class="form-group col-md-6">
                <button type="button" class="btn btn-info" onclick="location.href='registrationForm.php'">Register</button>
            </div>
        </div>
    </div>
<?php
    include_once("htmlEnd.php");
?>

