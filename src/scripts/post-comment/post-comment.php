<?php

session_start();


$recepyId = $_SESSION['recepy_id'];
$userId = $_SESSION['id'];
$comment = $_POST['comment'];

$connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");



$query = $connectDatabase->prepare("INSERT INTO allComment (userid, recepyid, comment) VALUES (:userid, :recepyid, :comment)");
$query->bindParam(':userid', $userId);
$query->bindParam(':recepyid', $recepyId);
$query->bindParam(':comment', $comment);
$query->execute();

header("Location: ../../comment.php");
exit();