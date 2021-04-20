<!DOCTYPE html>
<html lang="en">
<head>
  <title>League Schedule</title>
  <link rel="stylesheet" href="grid.css" />
</head>

<body>
    <?php include('header.php');
    include('db-helpers.php');

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['action'])) {}
    if (isset($_SESSION['league_id'])) {
        $matches = getMatches($_SESSION['league_id']);
        $teams = getTeams($_SESSION['league_id']);
    }
    ?>

    <div class="grid-container">
        <div class="grid-header">
            <h1>Schedule Matches for League: <?php echo $_SESSION['league_name']?></h1>
        </div>
        <div class="grid-row">
            <form action="<?php $_SERVER['PHP_SELF'] ?>" id="game_form" method="post">
                <h5>Match Title:</h5>
                <input type="text" name="game_name" class="grid-input" required />
                </br>
                <h3>Teams:</h3>
                <select name="team1" form="game_form" required>
                    <option value="" disabled selected>Select Team</option>
                    <?php foreach ($teams as $team): ?>
                    <option value="<?php echo $team['team_id'] ?>"><?php echo $team['team_name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <br/>
                <select name="team2" form="game_form" required>
                    <option value="" disabled selected>Select Team</option>
                    <?php foreach ($teams as $team): ?>
                    <option value="<?php echo $team['team_id'] ?>"><?php echo $team['team_name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <br/>
                <br/>
                <h5>Date:</h5>
                <input type="datetime-local" name="game_date" min="2020-01-01T00:00" max="2050-12-31T00:00">
                <input type="submit" name="action" value="Add" class="btn-grid"/>
            </form>
        </div>
        <div class="grid-row">
            <h3>Matches:</h3>
        </div>
        <div class="grid-row">
            <form action="my-leagues.php">
                <br/>
                <input type="submit" class="btn-grid" value="Back to My Leagues" />
                <br/>
            </form>
        </div>
    </div>
</body>
</html>

<?php

// Return an array of all matches in a league
function getMatches($league_id) {
    global $db;

    $query = "SELECT * FROM game
    WHERE league_id = " . $league_id;

    $statement = $db->prepare($query);
    $statement->execute();

    $results = $statement->fetchAll();

    $statement->closeCursor();
    return $results;
}
?>