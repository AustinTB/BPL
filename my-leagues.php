<!DOCTYPE html>
<html lang="en">
<head>
  <title>My Leagues</title>
  <link rel="stylesheet" href="grid.css" />
</head>

<body>
    <?php 
    include('header.php');
    include('db-helpers.php');

    if (isset($_SESSION['user'])) {
        $my_admin_id = getMyAdminId($_SESSION['user']);
        if (!empty($my_admin_id)) $leagues = getMyLeagues($my_admin_id);

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['league_id'])) {
            $_SESSION['league_id'] = $_POST['league_id'];
            $_SESSION['league_name'] = $_POST['league_name'];
            
            if ($_POST['action'] == 'Manage') {
                header('Location: addteams.php');
            } else if ($_POST['action'] == 'Schedule') {
                header('Location: schedule.php');
            }
        }
    }
    ?>

    <div class="grid-container">
        <div class="grid-header">
            <h1>My Leagues</h1>
        </div>

        <?php foreach ($leagues as $league): ?>
        <div class="grid-row">
            </br>
            <h3><?php echo $league['league_name'] ?></h3>
            </br>
            <form action="<?php $_SERVER['PHP_SELF'] ?>" method="post">
                <input type="submit" name="action" value="Manage" class="btn-grid" />
                <input type="submit" name="action" value="Schedule" class="btn-grid" />
                <input type="hidden" name="league_id" value="<?php echo $league['league_id'] ?>" />
                <input type="hidden" name="league_name" value="<?php echo $league['league_name'] ?>" />
            </form>
            </br>
        </div>
        <?php endforeach; ?>
        <div class ="grid-row">
            <form action="createleague.php">
                <br/>
                <input type="submit" class="btn-grid" value="Create a New League" />
                <br/>
            </form>
        </div>
    </div>
</body>

<?php
function getMyLeagues($admin_id) {
    global $db;

    $query = "SELECT * FROM league WHERE admin_id = '" . $admin_id . "'";
    $sql = $db->prepare($query);
    $sql->execute();
    $result = $sql->fetchAll();
    $sql->closeCursor();

    return $result;
}
?>

</html>