<?php
session_start();
require_once 'PDO.php';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    echo "Connected to $dbname at $host successfully.";
} catch (PDOException $pe) {
    die("Could not connect to the database $dbname :" . $pe->getMessage());
}
$stmt = $pdo->prepare("DELETE FROM cabshare WHERE cabshare_id = :cab");
$stmt->execute(array(':cab' => $_GET['cabshare_id']));
$stmt = $pdo->prepare("DELETE FROM booker WHERE cabshare_id = :cab");
$stmt->execute(array(':cab' => $_GET['cabshare_id']));
header('location: displaycabshares.php');
?>