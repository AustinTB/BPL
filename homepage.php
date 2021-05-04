<!DOCTYPE html>
<html lang="en">
<head> 
  <title>Home</title>
  <link rel="stylesheet" href="grid.css" />
</head>

<body>
  <?php include('header.php');
  include('connect-db.php');  
  ?>
  
  <?php if (isset($_SESSION['admin']) && isset($_SESSION['id'])) : ?> 

    <div class="grid-container">
      <div class="grid-header">
        <h1>Upcoming Matches</h1>
      </div>
      <?php
      $leagues = getLeagues($_SESSION['id']);
      ?>
     <?php foreach ($leagues as $league): 
        
        $league_id = $league[0];

        $matches = getMatches($league);
        
        foreach ($matches as $match): ?>

        <div class="grid-row"> 
          <h2><?php echo $match['game_name'] ?></h2>
          <h3><?php echo getTeamNameFromId($match['team1_id']) ?> VS. <?php echo getTeamNameFromId($match['team2_id']) ?> </h3>
          <h3><?php echo $match['date'] ?> </h3>
          <form action="record-stats.php" method="post">
            <input type="submit" value="Record" name="action" class="btn-grid" />      
            <input type="hidden" name="game_id" value="<?php echo $match['game_id'] ?>" />
          </form>
          <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
            <input type="submit" value="Delete" name="action" class="btn-danger" />      
            <input type="hidden" name="game_id" value="<?php echo $match['game_id'] ?>" />
          </form>
        </div>

        <?php endforeach; ?>
      <?php endforeach; ?>


    </div>

  <?php elseif (!isset($_SESSION['admin']) && isset($_SESSION['id'])): ?>

    <div class="grid-container">
      <div class="grid-header">
        <h1>My Upcoming Matches</h1>
      </div>
      <?php
      $teams = getTeamsFromId($_SESSION['id']);
      ?>
     <?php foreach ($teams as $team): 
        
        //echo $team[0];

        $games = getMatchesFromTeam($team[0]);
        
          foreach ($games as $game): ?>

          <div class="grid-row"> 
            <h2><?php echo $game['game_name'] ?></h2>
            <h3><?php echo getTeamNameFromId($game['team1_id']) ?> VS. <?php echo getTeamNameFromId($game['team2_id']) ?> </h3>
            <h3><?php echo $game['date'] ?> </h3>
          </div>

          <?php endforeach; ?>
      <?php endforeach; ?>


    </div>

  <?php else : ?>

    <div class="grid-container">
      <div class="grid-header">
        <h1> Do you wish to <a href="login.php">login</a> first? </h1>
      </div>
      <div class="grid-row">
        <h1> <a href="select-league.php"> View League Statistics </a> </h1>
      </div>
      <div class="grid-row">
        <h1> <a href="player-stats.php"> View Player Statistics </a> </h1>
      </div>
    </div>

  <?php endif; ?>

</body>

</html>

<?php

function getLeagues($admin_id) {
  global $db;

  $admin_id = (string)$admin_id;

  $query = "SELECT league_id FROM league WHERE admin_id = " . $admin_id;
  $sql = $db->prepare($query);
  $sql->execute();

  $leagues = $sql->fetchAll();

  $sql->closeCursor();

  return $leagues; //MAYBE CHANGE?
}

function getMatches($league) {
  global $db;

  $league = $league[0];

  $query = "SELECT * FROM game WHERE league_id = " . $league . " AND winner IS NULL";
  $sql = $db->prepare($query);
  $sql->execute();

  $matches = $sql->fetchAll();

  $sql->closeCursor();

  return $matches;
}

function getTeamNameFromId($team_id) {
  global $db;

  $query = "SELECT team_name FROM team WHERE team_id = " . $team_id;
  $sql = $db->prepare($query);
  $sql->execute();

  $team_name = $sql->fetch()[0];

  $sql->closeCursor();
  return $team_name;
}

function getTeamsFromId($player_id) {
  global $db;

  //$player_id = (string)$player_id;

  $query = "SELECT team_id FROM team WHERE player1_id = '" . $player_id . "' OR player2_id = '" . $player_id . "' OR player3_id = '" . $player_id . "'";
  $sql = $db->prepare($query);
  $sql->execute();

  $teams = $sql->fetchAll();

  $sql->closeCursor();
  return $teams;
}

function getMatchesFromTeam($team) {
  global $db;

  $query = "SELECT * from game WHERE team1_id = " . $team . " OR team2_id = " . $team . " AND winner IS NULL";
  $sql = $db->prepare($query);
  $sql->execute();
  
  $games = $sql->fetchAll();

  $sql->closeCursor();
  return $games;
}

?>