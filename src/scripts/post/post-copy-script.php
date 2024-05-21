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

$_SESSION['title'] = $recepy['0']['title'];
$_SESSION['ingredient'] = $recepy['0']['ingredient'];
$_SESSION['etape'] = $recepy['0']['etape'];
$_SESSION['userid'] = $recepy['0']['userid'];
$_SESSION['image'] = $recepy['0']['image'];
$_SESSION['private'] = $recepy['0']['private'];

header('Location: ../../recepy.php?success=Le post a bien été copié');