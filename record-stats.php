<!DOCTYPE html>
<html lang="en">
<head>
  <title>Record Stats</title>
  <link rel="stylesheet" href="grid.css" />
</head>

<body>
    <?php include('header.php');
    include('db-helpers.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['action'])) {
        if ($_POST['action'] == 'Record' && isset($_POST['game_id'])) {
            $match = getMatch($_POST['game_id']);

            $team1 = getTeam($match['team1_id']);
            $players1 = getTeamMembers($team1);

            $team2 = getTeam($match['team2_id']);
            $players2 = getTeamMembers($team2);
        }
    }
    ?>

    <div class="grid-container">
        <div class="grid-header">
            <h1>Record Stats for Match: <?php echo $match['game_name']?></h1>
        </div>
        <div class="grid-row">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" id="stats_form" method="post">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th></th>
                        <th></th>
                        <th><?php echo $team1['team_name'] ?></th>
                        <th><?php echo $team2['team_name'] ?></th>
                        <th></th>
                        <th></th>
                    </tr>
                    <tr>
                        <th><?php echo $players1[0]['player_name'] ?></th>
                        <th><?php echo $players1[1]['player_name'] ?></th>
                        <th><?php echo $players1[2]['player_name'] ?></th>
                        <th><?php echo $players2[0]['player_name'] ?></th>
                        <th><?php echo $players2[1]['player_name'] ?></th>
                        <th><?php echo $players2[2]['player_name'] ?></th>
                    </tr>
                    <tr>
                        <td>
                            <label for="hits1">Hits:</label>
                            <input type="number" id="hits1" name="hits1" min="0" value="0" >
                        </td>
                        <td>
                            <label for="hits2">Hits:</label>
                            <input type="number" id="hits2" name="hits2" min="0" value="0" >
                        </td>
                        <td>
                            <label for="hits3">Hits:</label>
                            <input type="number" id="hits3" name="hits3" min="0" value="0" >
                        </td>
                        <td>
                            <label for="hits4">Hits:</label>
                            <input type="number" id="hits4" name="hits4" min="0" value="0" >
                        </td>
                        <td>
                            <label for="hits5">Hits:</label>
                            <input type="number" id="hits5" name="hits5" min="0" value="0" >
                        </td>
                        <td>
                            <label for="hits6">Hits:</label>
                            <input type="number" id="hits6" name="hits6" min="0" value="0" >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="miss1">Misses:</label>
                            <input type="number" id="miss1" name="miss1" min="0" value="0" >
                        </td>
                        <td>
                            <label for="miss2">Misses:</label>
                            <input type="number" id="miss2" name="miss2" min="0" value="0" >
                        </td>
                        <td>
                            <label for="miss3">Misses:</label>
                            <input type="number" id="miss3" name="miss3" min="0" value="0" >
                        </td>
                        <td>
                            <label for="miss4">Misses:</label>
                            <input type="number" id="miss4" name="miss4" min="0" value="0" >
                        </td>
                        <td>
                            <label for="miss5">Misses:</label>
                            <input type="number" id="miss5" name="miss5" min="0" value="0" >
                        </td>
                        <td>
                            <label for="miss6">Misses:</label>
                            <input type="number" id="miss6" name="miss6" min="0" value="0" >
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="cc1">Called Cups:</label>
                            <input type="number" id="cc1" name="cc1" min="0" value="0" >
                        </td>
                        <td>
                            <label for="cc2">Called Cups:</label>
                            <input type="number" id="cc2" name="cc2" min="0" value="0" >
                        </td>
                        <td>
                            <label for="cc3">Called Cups:</label>
                            <input type="number" id="cc3" name="cc3" min="0" value="0" >
                        </td>
                        <td>
                            <label for="cc4">Called Cups:</label>
                            <input type="number" id="cc4" name="cc4" min="0" value="0" >
                        </td>
                        <td>
                            <label for="cc5">Called Cups:</label>
                            <input type="number" id="cc5" name="cc5" min="0" value="0" >
                        </td>
                        <td>
                            <label for="cc6">Called Cups:</label>
                            <input type="number" id="cc6" name="cc6" min="0" value="0" >
                        </td>
                    </tr>
                </table>
                <select name="winner" form="stats_form" required>
                    <option value="" disabled selected>Winning Team</option>
                    <option value="<?php echo $team1['team_id'] ?>"><?php echo $team1['team_name']; ?></option>
                    <option value="<?php echo $team2['team_id'] ?>"><?php echo $team2['team_name']; ?></option>
                </select>
            </form>
        </div>
    </div>
</body>
</html>

<?php

// Get the match to enter stats for
function getMatch($game_id) {
    global $db;

    $query = "SELECT * FROM game
    WHERE game_id = " . $game_id;

    $sql = $db->prepare($query);
    $sql->execute();

    $result = $sql->fetch();

    $sql->closeCursor();
    return $result;
}

// Get a team given its ID
function getTeam($team_id) {
    global $db;

    $query = "SELECT * FROM team
    WHERE team_id = " . $team_id;

    $sql = $db->prepare($query);
    $sql->execute();

    $team = $sql->fetch();

    $sql->closeCursor();

    return $team;
}

// Return an array containing the players for a given team
function getTeamMembers($team) {
    global $db;

    $query = "SELECT * FROM player
    WHERE player_id = " . $team["player1_id"]
    . " OR player_id = " . $team["player2_id"]
    . " OR player_id = " . $team["player3_id"];

    $sql = $db->prepare($query);
    $sql->execute();

    $players = $sql->fetchAll();

    $sql->closeCursor();

    return $players;
}

?>