<!DOCTYPE html>
<html lang="en">
<head>
  <title>Log out</title>
  <link rel="stylesheet" href="grid.css" />
</head>

<body>
    <?php
    session_start();
    if (count($_SESSION) > 0) {
        foreach ($_SESSION as $k => $v) {
          unset($_SESSION[$k]); // remove k/v pair from session object (server)
        }
        session_destroy(); // completely remove the instance (server)
    }
    if (isset($_COOKIE['name'])) {
        setcookie("name", "", time()-3600);
    }
    include('header.php')
    ?>

    <div class="grid-container">
        <div class="grid-header">
            <h1>You've logged out successfully. Come back soon!</h1>
        </div>
        <div class="grid-row">
            <form action="homepage.php">
                <br/>
                <input type="submit" class="btn-grid" value="Home Page" />
                <br/>
            </form>
        </div>
    </div>
</body>
</html>