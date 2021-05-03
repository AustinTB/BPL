<!DOCTYPE html>
<html lang="en">
<head>
  <title>Player Signup</title>
  <link rel="stylesheet" href="grid.css" />
</head>

<body>
    <?php
    require('connect-db.php');
    include('header.php');
    
    //Check if a user exists
    function user_check($user){
        global $db;

        $query = "SELECT * FROM player WHERE player_user = " . $db->quote($user);

        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();

        if (! $result){
            return false;
        } else {
            return true;
        }
    }

    // Create a user account with the given credentials. Return true if successful.
    function create_account($user, $pwd, $name) {
        global $db;

        $query = "INSERT INTO player (player_user, player_password, player_name, hits, misses, called_cups) VALUES (:user, :pwd, :name, :h, :m, :cc)";

        $h= 0;
        $m = 0;
        $cc = 0;

        $statement = $db->prepare($query);
        $statement->bindValue(':user', $user);
        $statement->bindValue(':pwd', $pwd);
        $statement->bindValue(':name', $name);
        $statement->bindValue(':h', $h);
        $statement->bindValue(':m', $m);
        $statement->bindValue(':cc', $cc);
        $statement->execute();

        return $statement->closeCursor();
    }

    function getPlayerId($user) {
        global $db;

        $query = "SELECT player_id FROM player WHERE player_user = " . $user;

        $statement = $db->prepare($query);
        $statement->execute();
        $result = $statement->fetch();
        $statement->closeCursor();

        return $result;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && strlen($_POST['username']) > 0) {
        $pwd = htmlspecialchars($_POST['pwd']);
        $user = htmlspecialchars($_POST['username']);
        $name = htmlspecialchars($_POST['name']);

        if (user_check($user)){
            echo "Error: unable to create account. Try a new username.";
        } elseif (create_account($user, $pwd, $name)) {
            $_SESSION['user'] = $user;
            $_SESSION['id'] = getPlayerId($user);
            setcookie('name', $name, time() + 3600);
            header('Location: success.php');
        } else {
            echo "Error - unable to create account, external error.";
        }
    }
    ?>

    <div class="grid-container">
        <div class="grid-header">
            <h1>Create an account</h1>
        </div>
        <div class="grid-row">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="return validateInfo()">
                <h3>Name: </h3> 
                <input type="text" name="name" class="grid-input" autofocus required />
                <br/>
                <h3>Username: </h3> 
                <input type="text" name="username" id="username" class="grid-input" required />
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

    <script>
        var user = document.getElementById("username");

        user.addEventListener('blur', function() {
            checkUsername(8);
        }, false);

        function checkUsername(minlength) {
            var msg = document.getElementById("user-msg");
            if (user.value.length < minlength && user.value.length > 0) {
                msg.textContent = "Username is too short";
            } else {
                msg.textContent = "";
            }
        }

        function validateInfo() {
            if (user.value.length < 8)
            {
                alert("Username must be at least 8 characters in length.")
                return false;
            }
            return true;
        }
    </script>
</body>
</html>