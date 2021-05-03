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

// Return an array of all leagues
function getLeagues() {
    global $db;

    $query = "SELECT * FROM league WHERE 1";

    $statement = $db->prepare($query);
    $statement->execute();

    $results = $statement->fetchAll();

    $statement->closeCursor();
    return $results;
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

function get_player_id($p_user) {
    
    global $db;

    $p_user = trim($p_user);

    $query = "SELECT player_id FROM player WHERE player_user = '".$p_user."'";
    $sql = $db->prepare($query);
    $sql->execute();
    $result = $sql->fetch();
    $sql->closeCursor();

    return $result[0];
}

function get_player_name($p_id) {
    global $db;

    $query = "SELECT player_name FROM player WHERE player_id = " . $p_id;
    $stm = $db->prepare($query);
    $stm->execute();
    $result = $stm->fetch();
    $stm->closeCursor();

    return $result[0];
}
?>