<!DOCTYPE html>
<html lang="en">
<head>
  <title>Team Statistics</title>
  <link rel="stylesheet" href="grid.css" />
</head>

<body>
    <?php 
    include('header.php');
    include('db-helpers.php');

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (isset($_GET['team_id'])) $stats = getTeamStats(null, $_GET['team_id']);
        else {
            if (isset($_GET['league_id'])) $league_id = $_GET['league_id'];
            else $league_id = null;

            $stats = getTeamStats($league_id, null);
        }
    }
    ?>

    <div class="grid-container">
        <div class="grid-header">
            <h1>Team Statistics</h1>
        </div>
        <h6>(Click on a player's name to view their global stats)</h6>
        <?php foreach ($stats as $team_stat): ?>
        <div class="grid-row">
            </br>
            <h3><?php echo $team_stat['team_name'] ?></h3>
            </br>
            <table class="table table-striped table-bordered">
                <tr>
                    <th></th>
                    <th>Players</th>
                    <th></th>
                    <th>Wins</th>
                    <th>Losses</th>
                </tr>
                <tr>
                    <td>
                        <h3><a class="badge badge-warning" href="<?php echo "player-stats.php?id=" . $team_stat['player1_id'] ?>">
                            <?php echo get_player_name($team_stat['player1_id']) ?>
                        </a></h3>
                    </td>
                    <td>
                        <h3><a class="badge badge-warning" href="<?php echo "player-stats.php?id=" . $team_stat['player2_id'] ?>">
                            <?php echo get_player_name($team_stat['player2_id']) ?>
                        </a></h3>
                    </td>
                    <td>
                        <h3><a class="badge badge-warning" href="<?php echo "player-stats.php?id=" . $team_stat['player3_id'] ?>">
                            <?php echo get_player_name($team_stat['player3_id']) ?>
                        </a></h3>
                    </td>
                    <td><?php echo $team_stat['wins'] ?></td>
                    <td><?php echo $team_stat['losses'] ?></td>
                </tr>
            </table>
        </div>
        <?php endforeach ?>
    </div>

</body>
</html>

<?php

function getTeamStats($league_id, $team_id) {
    global $db;

    $query = "SELECT team_name, player1_id, player2_id, player3_id, wins, losses FROM team";
    if (isset($team_id)) $query = $query . " WHERE team_id = " . $team_id;
    else if (isset($league_id)) $query = $query . " WHERE league_id = " . $league_id;
    $query = $query . " ORDER BY wins DESC, losses";

    $sql = $db->prepare($query);
    $sql->execute();

    $results = $sql->fetchAll();

    $sql->closeCursor();

    return $results;
}

?>