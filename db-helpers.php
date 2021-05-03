<?php
include('connect-db.php');

function getMyAdminId($username) {
    global $db;

    $query = "SELECT admin_id FROM admin WHERE admin_user = '" . $username . "'";

    $sql = $db->prepare($query);
    $sql->execute();
    $result = $sql->fetch()[0];
    $sql->closeCursor();

    return $result;
}

// Return an array of all teams in a league
function getTeams($league_id) {
    global $db;

    $query = "SELECT * FROM team
    WHERE league_id = " . $league_id;

    $statement = $db->prepare($query);
    $statement->execute();

    $results = $statement->fetchAll();

    $statement->closeCursor();
    return $results;
}

//Return an array of all players
function getPlayers() {
    global $db;

    $query = "SELECT * FROM player WHERE 1";

    $statement = $db->prepare($query);
    $statement->execute();

    $results = $statement->fetchAll();

    $statement->closeCursor();
    return $results;
}
?>