<?php

session_start();

if (!isset($_SESSION["title"]) || !isset($_SESSION["ingredient"]) || !isset($_SESSION["etape"]) || !isset($_SESSION["image"]) || !isset($_SESSION['private'])) {
    header("Location: ../../createRecepy.php?error=Vous n'avez aucun post de copié");

    exit();
}
;

$connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");


$request = $connectDatabase->prepare("INSERT INTO recepy (title, ingredient, etape, userid, image, private) VALUES (:title, :ingredient, :etape, :userid, :image, :private)");

$request->bindParam(':title', $_SESSION['title']);
$request->bindParam(':ingredient', $_SESSION['ingredient']);
$request->bindParam(':etape', $_SESSION['etape']);
$request->bindParam(':userid', $_SESSION['id']);
$request->bindParam(':image', $_SESSION['image']);
$request->bindParam(':private', $_SESSION['private']);

$request->execute();



header('Location: ../../recepy.php?success=Le post a bien été dupliqué');