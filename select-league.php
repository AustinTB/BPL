<!DOCTYPE html>
<html lang="en">
<head>
  <title>League Statistics</title>
  <link rel="stylesheet" href="grid.css" />
</head>

<body>
    <?php
    include('header.php');
    include('db-helpers.php');

    $leagues = getLeagues();
    ?>

    <div class="grid-container">
        <div class="grid-header">
            <h1>View Team or Match Statistics</h1>
        </div>
        <div class="grid-row">
            </br>
            <h3>Team Statistics</h3>
            <form action="team-stats.php" id="teams_form" method="get">
                </br>
                <h5>Which league do you want to view team stats for?</h5>
                <select name="league_id" form="teams_form" required>
                    <option value="" disabled selected>Select...</option>
                    <?php foreach ($leagues as $league): ?>
                    <option value="<?php echo $league['league_id'] ?>"><?php echo $league['league_name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" class="btn-grid"/>
            </form>
        </div>
        </br>
        <div class="grid-row">
            </br>
            <h3>Match Statistics</h3>
            <form action="match-stats.php" id="matches_form" method="get">
                </br>
                <h5>Which league do you want to view match stats for?</h5>
                <select name="league_id" form="matches_form" required>
                    <option value="" disabled selected>Select...</option>
                    <?php foreach ($leagues as $league): ?>
                    <option value="<?php echo $league['league_id'] ?>"><?php echo $league['league_name']; ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="submit" class="btn-grid"/>
            </form>
        </div>
    </div>
</body>
</html>