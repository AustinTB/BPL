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
        }
    }
    ?>

    <div class="grid-container">
        <div class="grid-header">
            <h1>Record Stats for Match: <?php echo $match['game_name']?></h1>
        </div>
        <div class="grid-row">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" id="stats_form" method="post">
                <label for="hits_1">Hits:</label>
                <input type="number" id="hits_1" name="hits_1" min="0" >
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

    $result = $sql->fetch(); // [0]?

    $sql->closeCursor();
    return $result;
}

?>