<?php

session_start();

//connect to db
$connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
//prepare request
$request = $connectDatabase->prepare("DELETE FROM recepy WHERE id = :id");
//bind params
$request->bindParam(':id', $_POST['recepy_id']);
//execute request
$request->execute();
$result = $request->fetch(PDO::FETCH_ASSOC);

header('Location: ../../recepy.php?success=Le post a bien été supprimé');