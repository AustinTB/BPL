<?php
include('connect-db.php');

function getMyAdminId($username) {
    global $db;

    $query = "SELECT admin_id FROM admin WHERE admin_user = '" . $username . "'";

    $sql = $db->prepare($query);
    $sql->execute();
    $result = $sql->fetch()[0];
    $sql->closeCursor();

    return $result;
}
?>