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
            $game_id = $_POST['game_id'];
            $match = getMatch($game_id);

            $team1 = getTeam($match['team1_id']);
            $players1 = getTeamMembers($team1);

            $team2 = getTeam($match['team2_id']);
            $players2 = getTeamMembers($team2);

        } else if ($_POST['action'] == 'Finalize' 
            && isset($_POST['game_id'])) {

                $team1 = getTeam($_POST['team1_id']);
                $players1 = getTeamMembers($team1);

                $team2 = getTeam($_POST['team2_id']);
                $players2 = getTeamMembers($team2);

                if ($_POST['winner'] == $_POST['team1_id']) {
                    $loser = $_POST['team2_id'];
                } else {
                    $loser = $_POST['team1_id'];
                }

                // Build arrays for the finalized stats
                $hits1 = [$_POST['hits1'], $_POST['hits2'], $_POST['hits3']];
                $hits2 = [$_POST['hits4'], $_POST['hits5'], $_POST['hits6']];
                $miss1 = [$_POST['miss1'], $_POST['miss2'], $_POST['miss3']];
                $miss2 = [$_POST['miss4'], $_POST['miss5'], $_POST['miss6']];
                $cc1 = [$_POST['cc1'], $_POST['cc2'], $_POST['cc3']];
                $cc2 = [$_POST['cc4'], $_POST['cc5'], $_POST['cc6']];

                // Record the stats to the DB
                finalizeStats($_POST['game_id'], $players1, $players2,
                $_POST['winner'], $loser, $hits1, $hits2, $miss1, $miss2, $cc1, $cc2);

                header('Location: match-stats.php?game_id=' . $_POST['game_id']);
        }
    }
    ?>

    <div class="grid-container">
        <div class="grid-header">
            <h1>Record Stats for Match: <?php echo $match['game_name']?></h1>
        </div>
        <form action="<?php $_SERVER['PHP_SELF'] ?>" id="stats_form" method="post">
            <div class="grid-row">
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
            </div>
            <div class="grid-row">
                <br/>
                <input type="submit" class="btn-grid" name="action" value="Finalize" />
                <input type="hidden" name="game_id" value="<?php echo $game_id ?>" />
                <input type="hidden" name="team1_id" value="<?php echo $team1['team_id'] ?>" />
                <input type="hidden" name="team2_id" value="<?php echo $team2['team_id'] ?>" />
                <br/>
            </div>
        </form>
    </div>
</body>
</html>

<?php

// Write the final match stats to the database
function finalizeStats($game_id, $players1, $players2, $winner_id, $loser_id,
    $hits1, $hits2, $miss1, $miss2, $cc1, $cc2) {

        // Record winner/loser
        recordWinnerForGame($game_id, $winner_id);
        
        // Adjust team's W/L stats
        recordWin($winner_id);
        recordLoss($loser_id);

        // Record stats for each player
        for ($i = 0; $i <= 2; $i++) {
            // Record each player's stats for this game
            createGameStat($game_id, $players1[$i]['player_id'], $hits1[$i], $miss1[$i], $cc1[$i]);
            createGameStat($game_id, $players2[$i]['player_id'], $hits2[$i], $miss2[$i], $cc2[$i]);
            
            // Adjust each player's global stats
            updatePlayerStats($players1[$i]['player_id'], $hits1[$i], $miss1[$i], $cc1[$i]);
            updatePlayerStats($players2[$i]['player_id'], $hits2[$i], $miss2[$i], $cc2[$i]);
        }
}

// Update a player's hits, misses, and called cups stats
function updatePlayerStats($player_id, $hits, $misses, $called_cups) {
    global $db;

    $query = "UPDATE player
    SET hits = hits + " . $hits
    . ", misses = misses + " . $misses
    . ", called_cups = called_cups + " . $called_cups
    . " WHERE player_id = " . $player_id;

    $sql = $db->prepare($query);
    $sql->execute();
    $sql->closeCursor();
}

// Adjust a team's stats to reflect a win
function recordWin($winner_id) {
    global $db;

    $query = "UPDATE team SET wins = wins + 1
    WHERE team_id = " . $winner_id;

    $sql = $db->prepare($query);
    $sql->execute();
    $sql->closeCursor();
}

// Adjust a team's stats to reflect a loss
function recordLoss($loser_id) {
    global $db;

    $query = "UPDATE team SET losses = losses + 1
    WHERE team_id = " . $loser_id;

    $sql = $db->prepare($query);
    $sql->execute();
    $sql->closeCursor();
}

// Set the 'winner' column for the game
function recordWinnerForGame($game_id, $winner_id) {
    global $db;

    $query = "UPDATE game SET winner = " . $winner_id
    . " WHERE game_id = " . $game_id;

    $sql = $db->prepare($query);
    $sql->execute();
    $sql->closeCursor();
}

// Create a record of an individual player's performance in the game
function createGameStat($game_id, $player_id, $hits, $misses, $called_cups) {
    global $db;

    $query = "INSERT INTO gamestat (game_id, player_id, hits, misses, called_cups)
    VALUES (:game_id, :player_id, :hits, :misses, :called_cups)";

    $sql = $db->prepare($query);
    $sql->bindValue(':game_id', $game_id);
    $sql->bindValue(':player_id', $player_id);
    $sql->bindValue(':hits', $hits);
    $sql->bindValue(':misses', $misses);
    $sql->bindValue(':called_cups', $called_cups);
    $sql->execute();
    $sql->closeCursor();
}

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