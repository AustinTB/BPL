<!DOCTYPE html>
<html lang="en">
<head>
  <title>League Schedule</title>
  <link rel="stylesheet" href="grid.css" />
</head>

<body>
    <?php include('header.php');
    include('db-helpers.php');

    if (isset($_SESSION['league_id'])) {

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['action'])) {
            if ($_POST['action'] == 'Add' && isset($_POST['team1']) && isset($_POST['team2']) && isset($_POST['game_date'])) {
                create_match($_POST['game_name'], $_SESSION['league_id'], $_POST['team1'], $_POST['team2'], $_POST['game_date']);

            } else if ($_POST['action'] == 'Delete' && isset($_POST['game_id'])) {
                delete_match($_POST['game_id']);
            }
        }

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
                <input type="datetime-local" name="game_date" min="2020-01-01T00:00" max="2050-12-31T00:00" required>
                <input type="submit" name="action" value="Add" class="btn-grid"/>
            </form>
        </div>
        <div class="grid-row">
            <h3>Matches:</h3>
            <table class="table table-striped table-bordered">
                <tr>
                    <th>Title</th>
                    <th>Team 1</th>
                    <th>Team 2</th>
                    <th>Date</th>
                    <th>(Delete?)</th>
                </tr>
                <?php foreach ($matches as $match): ?>
                <tr>
                    <td>
                        <?php echo $match['game_name']; ?>
                    </td>
                    <td>
                        <?php echo team_name_from_id($match['team1_id'], $teams); ?>
                    </td>
                    <td>
                        <?php echo team_name_from_id($match['team2_id'], $teams); ?> 
                    </td>
                    <td>
                        <?php echo $match['date']; ?> 
                    </td>
                    <td>
                        <form action="record-stats.php" method="post">
                            <input type="submit" value="Record" name="action" class="btn-grid" />      
                            <input type="hidden" name="game_id" value="<?php echo $match['game_id'] ?>" />
                        </form>
                        <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                            <input type="submit" value="Delete" name="action" class="btn-danger" />      
                            <input type="hidden" name="game_id" value="<?php echo $match['game_id'] ?>" />
                        </form>
                        </br>
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
        </div>
    </div>
</body>
</html>

<?php

// Return an array of all INCOMPLETE matches in a league
function getMatches($league_id) {
    global $db;

    $query = "SELECT * FROM game
    WHERE league_id = " . $league_id .
    " AND winner IS NULL
     ORDER BY date ASC";

    $statement = $db->prepare($query);
    $statement->execute();

    $results = $statement->fetchAll();

    $statement->closeCursor();
    return $results;
}

function create_match($game_name, $league_id, $team1_id, $team2_id, $date) {

    global $db;

    $query = "INSERT INTO game (game_name, league_id, team1_id, team2_id, date)
        VALUES (:game_name, :league_id, :team1_id, :team2_id, :date)";
    
    $sql = $db->prepare($query);
    $sql->bindValue(':game_name', $game_name);
    $sql->bindValue(':league_id', $league_id);
    $sql->bindValue(':team1_id', $team1_id);
    $sql->bindValue(':team2_id', $team2_id);
    $sql->bindValue(':date', $date);
    $sql->execute();
    $sql->closeCursor();
}

function delete_match($game_id) {
    global $db;

    $query = "DELETE FROM game WHERE game_id = '".$game_id."'";
    
    $sql = $db->prepare($query);
    $sql->execute();
    $sql->closeCursor();
}

// To avoid unnecessary querying, use the existing $teams array to find a certain team's name
function team_name_from_id($team_id, $teams_arr) {
    if (!empty($teams_arr)) {
        foreach ($teams_arr as $team):
            if ($team['team_id'] == $team_id) return $team['team_name'];
        endforeach;
    }

    return null;
}
?>