<?php

session_start();

$commentId = $_POST['comment_id'];

$connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");

$request = $connectDatabase->prepare("DELETE FROM allComment WHERE id = :id");
$request->bindParam(':id', $commentId);
$request->execute();

header("Location: ../../comment.php");