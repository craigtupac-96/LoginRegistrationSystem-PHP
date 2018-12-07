<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location: loginForm.php');
    }
    include_once("htmlStart.php");
    include_once("navbar.php");
    $errors = array();
    ?>
    <div class="card">
        <div class="card-header border-info">
            <h2>Change Password</h2>
        </div>
        <div class="card-body">
            <form method="post" action="changePassword.php">
                <!-- Display errors here -->
                <?php
                    $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                    if(strpos($fullUrl, "change=emptyOldPass") == true){?>
                    <div class="alert alert-danger">
                        <?php echo "Old password is required"; ?>
                    </div>  <?php }

                    if(strpos($fullUrl, "change=emptyNewPass") == true){?>
                    <div class="alert alert-danger">
                        <?php echo " New Password is required"; ?>
                    </div>  <?php }

                    if(strpos($fullUrl, "change=emptyNewRePass") == true){?>
                    <div class="alert alert-danger">
                        <?php echo "Re-enter New Password is required"; ?>
                    </div>  <?php }

                    if(strpos($fullUrl, "change=noPassMatch") == true){?>
                    <div class="alert alert-danger">
                        <?php echo "The two passwords do not match"; ?>
                    </div>  <?php }

                    if(strpos($fullUrl, "change=pass8") == true){?>
                    <div class="alert alert-danger">
                        <?php echo "Password is less than 8 characters"; ?>
                    </div>  <?php }

                    if(strpos($fullUrl, "change=passUpper") == true){?>
                    <div class="alert alert-danger">
                        <?php echo "Password must contain at least 1 upper-case letter"; ?>
                    </div>  <?php }

                    if(strpos($fullUrl, "change=passNum") == true){?>
                    <div class="alert alert-danger">
                        <?php echo "Password must contain at least 1 number"; ?>
                    </div>  <?php }

                    if(strpos($fullUrl, "change=oldPassWrong") == true){?>
                        <div class="alert alert-danger">
                            <?php echo "The old password entered was incorrect"; ?>
                        </div>  <?php }
                ?>

                <div class="form-group col-md-6">
                    <label for="inputUser">Old Password</label>
                    <input type="password" class="form-control" id="inputUser" name="oldPassword" placeholder="Enter Old Password">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword2">New Password</label>
                    <input type="password" class="form-control" id="inputPassword1" name="newPassword1" placeholder="Enter New Password">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword2">Re-enter New Password</label>
                    <input type="password" class="form-control" id="inputPassword2" name="newPassword2" placeholder="Re-enter New Password">
                </div>
                <div class="form-group col-md-6">
                    <button type="submit" name="change" class="btn btn-info">Submit</button>
                </div>
            </form>
        </div>
        <div class="card-footer border-info">
            <a href="home.php" id="log">Cancel password change</a>
        </div>
    </div>
<?php
    include_once("htmlEnd.php");
?>
