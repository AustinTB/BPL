<?php

//Connection to UVA CS Server
$username = 'rch5ec';
$password = '!Lillian1198';
$host = 'usersrv01.cs.virginia.edu';
$dbname = 'rch5ec';

$dsn = "mysql:host=$host;dbname=$dbname";
$db = "";

try {
    $db = new PDO($dsn, $username, $password);
    echo "<p>YOu have connected to the database.</p>";
} catch (PDOException $e) {
    $error_message = $e->getMessage();
    echo "<p>There was an error connecting to the database: $error_message </p>";
} catch (Exception $e) {
    $error_message = $e->getMessage();
    echo "<p>Error: $error_message </p>";
}

?>