<?php

session_start();

$id = $_POST['recepy_id'];



$connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
//prepare request
$request = $connectDatabase->prepare("SELECT * FROM recepy where id = :id");


$request->bindParam(':id', $id);
//execute request
$request->execute();

//fetch all data from table posts
$recepy = $request->fetchAll(PDO::FETCH_ASSOC);


$request = $connectDatabase->prepare("INSERT INTO recepy (title, ingredient, etape, userid, image, private) VALUES (:title, :ingredient, :etape, :userid, :image, :private)");

$request->bindParam(':title', $recepy['0']['title']);
$request->bindParam(':ingredient', $recepy['0']['ingredient']);
$request->bindParam(':etape', $recepy['0']['etape']);
$request->bindParam(':userid', $recepy['0']['userid']);
$request->bindParam(':image', $recepy['0']['image']);
$request->bindParam(':private', $recepy['0']['private']);

$request->execute();

header('Location: ../../recepy.php?success=Le post a bien été dupliqué');