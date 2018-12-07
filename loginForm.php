<?php
    session_start();
    include_once("htmlStart.php");
    include_once("navbar.php");
?>
    <div class="card">
        <div class="card-header border-info">
            <h2>Login</h2>
        </div>
        <div class="card-body">
            <form method="post" action="login.php">
                <!-- Display errors here -->
                <?php
                    $fullUrl = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

                    if(strpos($fullUrl, "log=emptyUser") == true){?>
                        <div class="alert alert-danger">
                            <?php echo "Username is required"; ?>
                        </div>  <?php }

                    else if(strpos($fullUrl, "log=emptyPass") == true){?>
                        <div class="alert alert-danger">
                            <?php echo "Password is required"; ?>
                        </div>  <?php }

                    else if(strpos($fullUrl, "log=wrongUserPass") == true){?>
                        <div class="alert alert-danger">
                            <?php
                            $user = $_SESSION['badUser'];
                            echo "The username/password combination cannot be authenticated for <strong>$user</strong> at the moment"; ?>
                        </div>  <?php }

                    else if(strpos($fullUrl, "log=lockedOut") == true){?>
                        <div class="alert alert-danger">
                            <?php
                            $timeLeft = $_SESSION['timeLeft'];
                            echo "Too many failed attempts. You have been locked out. Try again in <strong>$timeLeft</strong> seconds"; ?>
                        </div>  <?php }

                    else if(strpos($fullUrl, "reg=success") == true){?>
                        <div class="alert alert-success">
                            <?php
                            echo "Registration successful, log in to continue."; ?>
                        </div>  <?php }
                ?>

                <div class="form-group col-md-6">
                    <label for="exampleInputEmail1">Username</label>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username">
                </div>
                <div class="form-group col-md-6">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password">
                </div>
                <div class="form-group col-md-6">
                    <button type="submit" name="login" class="btn btn-info">Login</button>
                </div>
            </form>
        </div>
        <div class="card-footer border-info">
            <p>Not yet a member? <a href="registrationForm.php" id="reg">Register</a></p>
        </div>
    </div>
<?php
    include_once("htmlEnd.php");
?>
