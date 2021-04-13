<!DOCTYPE html>
<html lang="en">
<head>
  <title>Team Addition</title>
  <link rel="stylesheet" href="grid.css" />
</head>

<body>
    <?php include('header.html');
    include('connect-db.php'); ?>
    <?php session_start(); ?>

    <div class="grid-container">
        <div class="grid-header">
            <h1>Add Teams</h1>
        </div>
        <div class="grid-row">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="get">
                <h3>Team Name: </h3> 
                <input type="text" name="team_name" class="grid-input"/>
                <br/>
                <h3>First Player's Name: </h3> 
                <input type="text" name="p1_name" class="grid-input"/>
                <br/>
                <h3>Second Player's Name: </h3> 
                <input type="text" name="p2_name" class="grid-input"/>
                <br/>
                <h3>Third Player's Name: </h3> 
                <input type="text" name="p3_name" class="grid-input"/>
                <br/>
                <input type="submit" class="btn-grid" value="Add Team"/>   <!-- use input type="submit" with the required attribute -->
            </form>
        </div>
        <div class="grid-row">
            <h3>Current Teams: </h3>

        </div>
        <div class ="grid-row">
        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
            <h5>When you're done adding teams, please click "Done!"</h5>
            <input type="submit" class="btn-grid" value="Done"/>
        </form>
    </div>

</body>
</html>

<?php

function get_player_id($p_name){
    
    global $db;

    $p_name = trim($p_name);

    $query = "SELECT player_id FROM player WHERE player_name = '".$p_name."'";
    $sql = $db->prepare($query);
    $sql->execute();
    $result = $sql->fetch();
    $sql->closeCursor();

    return $result[0];
}

function create_team($team_name, $p1_name, $p2_name, $p3_name) {

    global $db;

    $league_id = $_SESSION['league_id'];
    $p1_id = get_player_id($p1_name);
    $p2_id = get_player_id($p2_name);
    $p3_id = get_player_id($p3_name);

    $query = "INSERT INTO team (team_name, league_id, player1_id, player2_id, player3_id) VALUES (:team_name, :league_id, :player1_id, :player2_id, :player3_id)";
    $sql = $db->prepare($query);
    $sql->bindValue(':team_name', $team_name);
    $sql->bindValue(':league_id', $league_id);
    $sql->bindValue(':player1_id', $p1_id);
    $sql->bindValue(':player2_id', $p2_id);
    $sql->bindValue(':player3_id', $p3_id);
    $sql->execute();
    $sql->closeCursor();

}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && strlen($_GET['team_name']) > 0 && strlen($_GET['p1_name']) > 0 && strlen($_GET['p2_name']) > 0 && strlen($_GET['p3_name']) > 0) {

    create_team($_GET['team_name'], $_GET['p1_name'], $_GET['p2_name'], $_GET['p3_name']);

}
?>