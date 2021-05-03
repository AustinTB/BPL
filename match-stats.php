<!DOCTYPE html>
<html lang="en">
<head>
  <title>Match Statistics</title>
  <link rel="stylesheet" href="grid.css" />
</head>

<body>
    <?php 
    include('header.php');
    include('db-helpers.php');

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['game_id'])) $stats = getMatchStats(null, $_GET['game_id']);
        else {
            if (isset($_GET['league_id'])) $league_id = $_GET['league_id'];
            else $league_id = null;

            $stats = getMatchStats($league_id, null);
        }
    }
    ?>

    <div class="grid-container">
        <div class="grid-header">
            <h1>Match Statistics</h1>
        </div>
        <h6>(Click on a PEEPEEPOOPOO to view their stats)</h6>
        <?php foreach ($stats as $match_stat):
        if ($match_stat['team1_id'] == $match_stat['winner']) $winnerA = true;
        else $winnerA = false;

        $teamA = getTeamFromId($match_stat['team1_id']);
        $playersA = getPlayersFromTeam($teamA);
        $gamestatA0 = getGameStat($match_stat['game_id'], $playersA[0]['player_id']);
        $gamestatA1 = getGameStat($match_stat['game_id'], $playersA[1]['player_id']);
        $gamestatA2 = getGameStat($match_stat['game_id'], $playersA[2]['player_id']);

        $teamB = getTeamFromId($match_stat['team2_id']);
        $playersB = getPlayersFromTeam($teamB);
        $gamestatB0 = getGameStat($match_stat['game_id'], $playersB[0]['player_id']);
        $gamestatB1 = getGameStat($match_stat['game_id'], $playersB[1]['player_id']);
        $gamestatB2 = getGameStat($match_stat['game_id'], $playersB[2]['player_id']);
        ?>
        <div class="grid-row">
            </br>
            <h3><?php echo $match_stat['game_name'] ?></h3>
            <p><?php echo $match_stat['date'] ?></p>
            </br>
            <table class="table table-striped table-bordered">
                <tr>
                    <th></th>
                    <th></th>
                    <th><?php if ($winnerA) echo "<span class='badge badge-warning'>Winners</span>"; ?><h4><?php echo $teamA['team_name']; ?></h4></th>
                    <th></th>
                    <th><h5>VS.</h5></th>
                    <th></th>
                    <th><?php if (!$winnerA) echo "<span class='badge badge-warning'>Winners</span>"; ?><h4><?php echo $teamB['team_name'] ?></h4></th>
                    <th></th>
                </tr>
                <tr>
                    <th></th>
                    <th><?php echo $playersA[0]['player_name'] ?></th>
                    <th><?php echo $playersA[1]['player_name'] ?></th>
                    <th><?php echo $playersA[2]['player_name'] ?></th>
                    <th></th>
                    <th><?php echo $playersB[0]['player_name'] ?></th>
                    <th><?php echo $playersB[1]['player_name'] ?></th>
                    <th><?php echo $playersB[2]['player_name'] ?></th>
                </tr>
                <tr>
                    <th>Hits</th>
                    <td><?php echo $gamestatA0['hits'] ?></td>
                    <td><?php echo $gamestatA1['hits'] ?></td>
                    <td><?php echo $gamestatA2['hits'] ?></td>
                    <th></th>
                    <td><?php echo $gamestatB0['hits'] ?></td>
                    <td><?php echo $gamestatB1['hits'] ?></td>
                    <td><?php echo $gamestatB2['hits'] ?></td>
                </tr>
                <tr>
                    <th>Misses</th>
                    <td><?php echo $gamestatA0['misses'] ?></td>
                    <td><?php echo $gamestatA1['misses'] ?></td>
                    <td><?php echo $gamestatA2['misses'] ?></td>
                    <th></th>
                    <td><?php echo $gamestatB0['misses'] ?></td>
                    <td><?php echo $gamestatB1['misses'] ?></td>
                    <td><?php echo $gamestatB2['misses'] ?></td>
                </tr>
                <tr>
                    <th>Called Cups</th>
                    <td><?php echo $gamestatA0['called_cups'] ?></td>
                    <td><?php echo $gamestatA1['called_cups'] ?></td>
                    <td><?php echo $gamestatA2['called_cups'] ?></td>
                    <th></th>
                    <td><?php echo $gamestatB0['called_cups'] ?></td>
                    <td><?php echo $gamestatB1['called_cups'] ?></td>
                    <td><?php echo $gamestatB2['called_cups'] ?></td>
                </tr>
            </table>
        </div>
        <?php endforeach; ?>
    </div>

</body>
</html>

<?php

function getMatchStats($league_id, $game_id) {
    global $db;

    $query = "SELECT game_id, game_name, team1_id, team2_id, date, winner FROM game
     WHERE winner IS NOT NULL";
    if (isset($game_id)) $query = $query . " AND game_id = " . $game_id;
    else if (isset($league_id)) $query = $query . " AND league_id = " . $league_id;
    $query = $query . " ORDER BY date DESC";

    $sql = $db->prepare($query);
    $sql->execute();

    $results = $sql->fetchAll();

    $sql->closeCursor();

    return $results;
}

function getGameStat($game_id, $player_id) {
    global $db;

    $query = "SELECT hits, misses, called_cups FROM gamestat
    WHERE game_id = " . $game_id . " AND player_id = " . $player_id;

    $sql = $db->prepare($query);
    $sql->execute();

    $results = $sql->fetch();

    $sql->closeCursor();

    return $results;
}

// Given a team, get the names and IDs of the team's players
function getPlayersFromTeam($team) {
    global $db;

    $query = "SELECT player_id, player_name FROM player 
    WHERE player_id IN ('" . $team['player1_id'] . "', '" . $team['player2_id'] . "', '" . $team['player3_id'] . "')";

    $sql = $db->prepare($query);
    $sql->execute();

    $players = $sql->fetchAll();

    $sql->closeCursor();
    return $players;
}

function getTeamFromId($team_id) {
    global $db;

    $query = "SELECT * FROM team
     WHERE team_id = " . $team_id;

    $sql = $db->prepare($query);
    $sql->execute();

    $team_results = $sql->fetch();

    $sql->closeCursor();
    return $team_results;
}

?>