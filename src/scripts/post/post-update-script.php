<?php


//connect to db
$connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
//prepare request
$request = $connectDatabase->prepare("UPDATE posts SET title = :title WHERE id = :id");
//bind params
$request->bindParam(':title', $_POST['title']);
$request->bindParam(':id', $_GET['id']);
//execute request
$request->execute();

header('Location: ../../post_list.php?success=Le post a bien été modifié');