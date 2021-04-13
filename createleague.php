<!DOCTYPE html>
<html lang="en">
<head>
  <title>League Creation</title>
  <link rel="stylesheet" href="grid.css" />
</head>

<body>
    <?php include('header.html');
    include('connect-db.php'); ?>
    <?php session_start(); ?>

    <div class="grid-container">
        <div class="grid-header">
            <h1>Create a League</h1>
        </div>
        <div class="grid-row">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <h3>League Name: </h3> 
                <input type="text" name="league_name" class="grid-input"/>
                <br/>
                <input type="submit" class="btn-grid" value="Create League"/>   <!-- use input type="submit" with the required attribute -->
            </form>
        </div>
    </div>

</body>
</html>

<?php
function create_league($league_name) {

    global $db;

    $admin_id = 2;

    $query = "INSERT INTO league (league_name, admin_id) VALUES (:league_name, :admin_id)";
    $sql = $db->prepare($query);
    $sql->bindValue(':league_name', $league_name);
    $sql->bindValue(':admin_id', $admin_id);
    $sql->execute();
    $sql->closeCursor();

}

function set_sess_league_id($league_name) {

    global $db;

    $query = "SELECT league_id FROM league WHERE league_name = '".$league_name."'";
    $sql = $db->prepare($query);
    $sql->execute();
    $result = $sql->fetch();
    $sql->closeCursor();

    $_SESSION['league_id'] = $result[0];

}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && strlen($_POST['league_name']) > 0) {

    create_league($_POST['league_name']);
    set_sess_league_id($_POST['league_name']);
    //echo $_SESSION['league_id'];
    header('Location: addteams.php');

}
?>