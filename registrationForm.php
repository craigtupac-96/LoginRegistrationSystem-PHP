<?php
    include_once("htmlStart.php");
    include_once("navbar.php");
?>
    <div class="card">
        <div class="card-header border-info">
            <h2>Register</h2>
        </div>
        <div class="card-body">
            <form method="post" action="register.php">
                <!-- Display errors here -->
                <?php
                    $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                    if(strpos($fullUrl, "reg=emptyUser") == true){?>
                        <div class="alert alert-danger">
                            <?php echo "Username is required"; ?>
                        </div>  <?php }

                    if(strpos($fullUrl, "reg=emptyPass") == true){?>
                        <div class="alert alert-danger">
                            <?php echo "Password is required"; ?>
                        </div>  <?php }

                    if(strpos($fullUrl, "reg=emptyRePass") == true){?>
                        <div class="alert alert-danger">
                            <?php echo "Re-enter Password is required"; ?>
                        </div>  <?php }

                    if(strpos($fullUrl, "reg=noPassMatch") == true){?>
                        <div class="alert alert-danger">
                            <?php echo "The two passwords do not match"; ?>
                        </div>  <?php }

                    if(strpos($fullUrl, "reg=pass8") == true){?>
                        <div class="alert alert-danger">
                            <?php echo "Password is less than 8 characters"; ?>
                        </div>  <?php }

                    if(strpos($fullUrl, "reg=passUpper") == true){?>
                        <div class="alert alert-danger">
                            <?php echo "Password must contain at least 1 upper-case letter"; ?>
                        </div>  <?php }

                    if(strpos($fullUrl, "reg=passNum") == true){?>
                        <div class="alert alert-danger">
                            <?php echo "Password must contain at least 1 number"; ?>
                        </div>  <?php }

                    if(strpos($fullUrl, "reg=userExists") == true){?>
                        <div class="alert alert-danger">
                            <?php echo "Username already exists"; ?>
                        </div>  <?php }
                ?>

                <div class="form-group col-md-6">
                    <label for="inputUser">Username</label>
                    <input type="text" class="form-control" id="inputUser" name="username" placeholder="Enter username">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword2">Password</label>
                    <input type="password" class="form-control" id="inputPassword1" name="password1" placeholder="Enter password">
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword2">Re-enter Password</label>
                    <input type="password" class="form-control" id="inputPassword2" name="password2" placeholder="Re-enter password">
                </div>
                <div class="form-group col-md-6">
                    <button type="submit" name="register" class="btn btn-info">Submit</button>
                </div>
            </form>
        </div>
        <div class="card-footer border-info">
            <p>Have an account? <a href="loginForm.php" id="log">Log In!</a></p>
        </div>
    </div>
<?php
    include_once("htmlEnd.php");
?>