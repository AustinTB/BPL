<!DOCTYPE html>
<html lang="en">
<head>
  <title>Login</title>
  <link rel="stylesheet" href="grid.css" />
</head>

<body>
    <?php
    require('connect-db.php');
    include('header.php');

    // Verify the given credentials, and return true if they match an existing user.
    function verify_credentials($user, $pwd) {
        global $db;

        // query for admin users first
        $query = "SELECT * FROM admin
        WHERE admin_user = :user
        AND admin_password = :pwd";

        $statement = $db->prepare($query);
        $statement->bindValue(':user', $user);
        $statement->bindValue(':pwd', $pwd);
        $statement->execute();

        $result = $statement->fetch();

        $retval = $statement->closeCursor();

        if (isset($result['admin_user'])) {
            if (isset($result['admin_name'])) setcookie('name', $result['admin_name'], time() + 3600);
            return $retval;
        }

        // if no admin found, query for players
        $query = "SELECT * FROM player
        WHERE player_user = :user
        AND player_password = :pwd";

        $statement = $db->prepare($query);
        $statement->bindValue(':user', $user);
        $statement->bindValue(':pwd', $pwd);
        $statement->execute();

        $result = $statement->fetch();

        $retval = $statement->closeCursor();

        if (isset($result['player_user']) > 0) {
            if (isset($result['player_name'])) setcookie('name', $result['player_name'], time() + 3600);
            return $retval;
        } else {
            return false;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && strlen($_POST['username']) > 0) {
        $pwd = htmlspecialchars($_POST['pwd']);
        $user = htmlspecialchars($_POST['username']);

        if (verify_credentials($user, $pwd)) {
            $_SESSION['user'] = $user;
            $_SESSION['pwd'] = $pwd;
            header('Location: success.php');

        } else {
            echo "Login failed.";
        }
    }
    ?>

    <div class="grid-container">
        <div class="grid-header">
            <h1>Log in</h1>
        </div>
        <div class="grid-row">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <div id="err-msg" class="feedback"></div> 
                <h3>Username: </h3> 
                <input type="text" name="username" class="grid-input" autofocus required />
                <br/>
                <h3>Password: </h3> 
                <input type="password" name="pwd" class="grid-input" required />
                <br/>
                <input type="submit" class="btn-grid" value="Log in" />   <!-- use input type="submit" with the required attribute -->
            </form>
            </br>
            <p>Don't have an account yet? Sign up as a <a href="player-signup.php">Player</a> or <a href="commisioner-signup.php">Commissioner</a></p>
        </div>
    </div>
</body>
</html>