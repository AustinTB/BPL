<!DOCTYPE html>
<html lang="en">
<head>
  <title>Player Statistics</title>
  <link rel="stylesheet" href="grid.css" />
</head>

<body>
    <?php 
    include('header.php');
    include('db-helpers.php');

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
        $stats = getPlayerStats($_GET['id']);
    } else {
        $stats = getPlayerStats(null);
    }
    ?>

    <div class="grid-container">
        <div class="grid-header">
            <h1>Global Player Statistics</h1>
        </div>
        <?php foreach ($stats as $player_stat): ?>
        <div class="grid-row">
            </br>
            <h3><?php echo $player_stat['player_name'] ?></h3>
            </br>
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Hits</th>
                    <th>Misses</th>
                    <th>Called Cups</th>
                </tr>
                <tr>
                    <td><?php echo $player_stat['hits'] ?></td>
                    <td><?php echo $player_stat['misses'] ?></td>
                    <td><?php echo $player_stat['called_cups'] ?></td>
                </tr>
            </table>
        </div>
        <?php endforeach ?>
    </div>

</body>
</html>

<?php

function getPlayerStats($player_id) {
    global $db;

    $query = "SELECT player_name, hits, misses, called_cups FROM player";
    if (isset($player_id)) $query = $query . " WHERE player_id = " . $player_id;
    $query = $query . " ORDER BY hits DESC";

    $sql = $db->prepare($query);
    $sql->execute();

    $results = $sql->fetchAll();

    $sql->closeCursor();

    return $results;
}

?>