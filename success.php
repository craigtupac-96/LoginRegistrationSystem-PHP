<?php
    session_start();
    if(!isset($_SESSION['username'])){
        header('location: loginForm.php');
    }
    include_once("htmlStart.php");
    include_once("navbar.php");
?>
    <h1>Great Success!</h1>

    <!-- maybe scrap this and merge with index -->
    <?php if(isset($_SESSION['success'])): ?>
        <div>
            <h3>
                <?php
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                ?>
            </h3>
        </div>
    <?php endif ?>

    <?php if(isset($_SESSION['username'])): ?>
        <p>Hey there <strong><?php echo $_SESSION['username']; ?></strong>, what's up?</p>
        <a class="btn btn-info" href="changePasswordForm.php" role="button">Change Password</a>
        <a class="btn btn-info" href="logout.php" role="button">Logout</a>
    <?php endif ?>

<?php
    include_once("htmlEnd.php");
?>
