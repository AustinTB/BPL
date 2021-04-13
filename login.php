<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
  <link rel="stylesheet" href="grid.css" />
</head>

<body>
    <?php include('header.html') ?>
    <?php session_start(); ?>

    <div class="grid-container">
        <div class="grid-header">
            <h1>Log in</h1>
        </div>
        <div class="grid-row">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="return (validateInfo())">
                <h3>Username: </h3> 
                <input type="text" name="username" class="grid-input" autofocus required />
                <div id="user-msg" class="feedback"></div> 
                <br/>
                <h3>Password: </h3> 
                <input type="password" name="pwd" class="grid-input" required />
                <div id="pwd-msg" class="feedback"></div> 
                <br/>
                <input type="submit" class="btn-grid" value="Log in" />   <!-- use input type="submit" with the required attribute -->
            </form>
            </br>
            Don't have an account yet? <a href="signup.php">Sign up</a>
            </br>
        </div>
    </div>

    <?php
    // Verify the given credentials, and return true if they match an existing user.
    function verify_credentials($user, $pwd) {
        return true;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && strlen($_POST['username']) > 0) {
        $pwd = htmlspecialchars($_POST['pwd']);
        $user = htmlspecialchars($_POST['username']);

        if (verify_credentials($user, $pwd)) {
            $_SESSION['user'] = $pwd;
            $_SESSION['pwd'] = $user;
            header('Location: success.php');
        } else {
            // error msg
        }
    } 
    ?>
</body>
</html>