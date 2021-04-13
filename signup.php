<!DOCTYPE html>
<html lang="en">
<head>
  <title>Signup</title>
  <link rel="stylesheet" href="grid.css" />
</head>

<body>
    <?php include('header.html') ?>
    <?php session_start(); ?>

    <div class="grid-container">
        <div class="grid-header">
            <h1>Create an account</h1>
        </div>
        <div class="grid-row">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="return (validateInfo())">
                <h3>Name: </h3> 
                <input type="text" name="name" class="grid-input" autofocus required />
                <br/>
                <h3>Username: </h3> 
                <input type="text" name="username" class="grid-input" required />
                <div id="user-msg" class="feedback"></div> 
                <br/>
                <h3>Password: </h3>
                <input type="password" name="pwd" class="grid-input" required />
                <div id="pwd-msg" class="feedback"></div> 
                <br/>
                <input type="submit" class="btn-grid" value="Sign up" />   <!-- use input type="submit" with the required attribute -->
            </form>
        </div>
    </div>

    <?php
    // Create a user account with the given credentials. Return true if successful.
    function create_account($user, $pwd, $name) {
        return true;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && strlen($_POST['username']) > 0) {
        $pwd = htmlspecialchars($_POST['pwd']);
        $user = htmlspecialchars($_POST['username']);
        $name = htmlspecialchars($_POST['name']);

        if (create_account($user, $pwd, $name)) {
            $_SESSION['user'] = $pwd;
            $_SESSION['pwd'] = $user;
            header('Location: success.php');
        } else {
            // error message
        }
    } 
    ?>

    <script>
        var user = document.getElementByName("username");

        user.addEventListener('blur', function() {
            checkUsername(8);
        }, false);

        function checkUsername(minlength) {
            var msg = document.getElementById("user-msg");
            if (user.value.length < minlength && user.value.length > 0)
                msg.textContent = "Username is too short";
            else
                msg.textContent = "";
            }

        function validateInfo() {
            var pwd = document.getElementById("pwd").value;       
            if (user.value.length < 8)
            {    	  
                document.getElementById("user-msg").innerHTML = "Username is too short";
                document.getElementByName("username").focus();
                return false;
            }
            return true;
        } 
    </script>
</body>
</html>