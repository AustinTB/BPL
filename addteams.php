<!DOCTYPE html>
<html lang="en">
<head>
  <title>Manage League</title>
  <link rel="stylesheet" href="grid.css" />
</head>

<body>
    <?php include('header.php');
    include('db-helpers.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['action'])) {
        if ($_POST['action'] == 'Delete') {
            if (!empty($_POST['team_id'])) deleteTeam($_POST['team_id']);
        
        } else if ($_POST['action'] == 'Add') {
            if (!empty($_POST['team_name']) && !empty($_POST['p1_name']) && !empty($_POST['p2_name']) && !empty($_POST['p3_name']))
                create_team($_POST['team_name'], $_POST['p1_name'], $_POST['p2_name'], $_POST['p3_name']);

        } else if ($_POST['action'] == 'Delete League') {
            if (!empty($_POST['league_id'])) deleteLeague($_POST['league_id']);
            header('Location: my-leagues.php');
        }
    }
    if (isset($_SESSION['league_id'])) $teams = getTeams($_SESSION['league_id']);
    ?>

    <div class="grid-container">
        <div class="grid-header">
            <h1>Add Teams to League: <?php echo $_SESSION['league_name']?></h1>
        </div>
        <div class="grid-row">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <h3>Team Name: </h3>
                <input type="text" name="team_name" class="grid-input" required />
                <br/>
                <h3>First Player's Name: </h3> 
                <input type="text" name="p1_name" class="grid-input" required />
                <br/>
                <h3>Second Player's Name: </h3> 
                <input type="text" name="p2_name" class="grid-input" required />
                <br/>
                <h3>Third Player's Name: </h3> 
                <input type="text" name="p3_name" class="grid-input" required />
                <br/>
                <input type="submit" name="action" value="Add" class="btn-grid"/>
            </form>
        </div>
        <div class="grid-row">
            <h3>Current Teams: </h3>
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Team Name</th>
                    <th>Player</th>
                    <th>Player</th>
                    <th>Player</th>
                    <th>(Delete?)</th>
                </tr>
                <?php foreach ($teams as $team): ?>
                <tr>
                    <td>
                        <?php echo $team['team_name']; ?>
                    </td>
                    <td>
                        <?php echo $team['player1_id']; ?>
                    </td>
                    <td>
                        <?php echo $team['player2_id']; ?> 
                    </td>
                    <td>
                        <?php echo $team['player3_id']; ?> 
                    </td>
                    <td>
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                            <input type="submit" value="Delete" name="action" class="btn btn-danger" />      
                            <input type="hidden" name="team_id" value="<?php echo $team['team_id'] ?>" />
                        </form>
                    </td>          
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <div class="grid-row">
            <form action="my-leagues.php">
                <br/>
                <input type="submit" class="btn-grid" value="Back to My Leagues" />
                <br/>
            </form>
            </br>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <br/>
                <h5>Delete This League Permanently</h5>
                <input type="submit" value="Delete League" name="action" class="btn btn-danger" />
                <input type="hidden" name="league_id" value="<?php if (isset($_SESSION['league_id'])) echo $_SESSION['league_id'] ?>" />
                <br/>
            </form>
        </div>
    </div>

</body>
</html>

<?php

function deleteTeam($team_id) {
    global $db;

    $query = "DELETE FROM team
    WHERE team_id = " . $team_id;

    $statement = $db->prepare($query);
    $retval = $statement->execute();
    $statement->closeCursor();

    return $retval;
}

function deleteLeague($league_id) {
    global $db;

    // First, delete all teams in this league
    $query = "DELETE FROM team
    WHERE league_id = " . $league_id;

    $statement = $db->prepare($query);
    $retval = $statement->execute();

    // Delete the league
    if ($retval) {
        $query = "DELETE FROM league
        WHERE league_id = " . $league_id;

        $statement = $db->prepare($query);
        $statement->execute();
        $retval = $statement->closeCursor();
    }

    return $retval;
}

function get_player_id($p_name) {
    
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
?>