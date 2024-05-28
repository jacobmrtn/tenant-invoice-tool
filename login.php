<?php
    require_once 'includes/config_session.inc.php';
    require_once 'includes/signup_view.inc.php';
    require_once 'includes/login_view.inc.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style.css">
    <title>Document</title>
</head>
<body>
    <?php if(!isset($_SESSION["user_id"])) { ?>
        <div class="section">
            <div class="login-box">
                <h3 class="login-heading">Tenant Invoice Tool</h3>
                <form class="login-form" action="includes/login.inc.php" method="post" style="margin: 10px;">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend"><span class="input-group-text">ID</span></div>
                        <input class="form-control" type="text" name="username" placeholder="Login ID">
                    </div>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend"><span class="input-group-text">ID</span></div>
                        <input class="form-control" type="password" name="pwd" placeholder="Password">
                    </div>
                    <button style="width: 100%;" class="btn btn-success">Login</button>
                </form>
                <?php check_login_errors(); ?>
            </div>
            <p>Don't have an account? <a href="get-account.php"class="get-account">Click here</a>!</p>
        </div>

        <!-- <div class="section">
            <h3>Sign Up</h3>
            <form action="includes/signup.inc.php" method="POST">
                <?php signup_input()?>
                <button>Sign Up</button>
            </form>
            <?php check_signup_errors(); ?>
        </div> -->

    <?php } ?>
</body>
</html>