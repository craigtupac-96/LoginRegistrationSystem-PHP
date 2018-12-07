<?php
session_start();
if(!isset($_SESSION['username'])){
    header('location: loginForm.php');
}
include_once("htmlStart.php");
include_once("navbar.php");
?>
    <div class="card">
        <div class="card-header border-info">
            <h2>Welcome <strong><?php echo $_SESSION['username']; ?></strong>!</h2>
        </div>
        <div class="card-body">
            <a class="btn btn-info" href="viewDetails.php" role="button">View Details</a><br/><br/>
            <a class="btn btn-info" href="changePasswordForm.php" role="button">Change Password</a>
        </div>
        <div class="card-footer border-info">
            <a class="btn btn-secondary" href="logout.php" role="button">Logout</a>
        </div>
    </div>
<?php
    include_once("htmlEnd.php");
?>