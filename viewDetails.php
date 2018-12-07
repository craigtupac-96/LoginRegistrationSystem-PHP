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
            <h2>Details</h2>
        </div>
        <div class="card-body">
            <p>This page could contain sensitive information that only <strong><?php echo $_SESSION['username'] ?></strong> can see as the authorized user.</p>
        </div>
        <div class="card-footer border-info">
            <a class="btn btn-secondary" href="home.php" role="button">Back to Home</a>
        </div>
    </div>
<?php
    include_once("htmlEnd.php");
?>