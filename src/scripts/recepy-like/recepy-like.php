<?php

session_start();


$recepyId = $_POST['recepy_id'];
$userId = $_SESSION['id'];

$connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");

$query = $connectDatabase->prepare("SELECT * FROM allLike WHERE userid = :userid AND recepyid = :recepyid");
$query->bindParam(':userid', $userId);
$query->bindParam(':recepyid', $recepyId);
$query->execute();

if ($query->rowCount() > 0) {

    $query = $connectDatabase->prepare("DELETE FROM allLike WHERE userid = :userid AND recepyid = :recepyid");
    $query->bindParam(':userid', $userId);
    $query->bindParam(':recepyid', $recepyId);
    $query->execute();
} else {


    $query = $connectDatabase->prepare("INSERT INTO allLike (userid, recepyid) VALUES (:userid, :recepyid)");
    $query->bindParam(':userid', $userId);
    $query->bindParam(':recepyid', $recepyId);
    $query->execute();
}

$query = $connectDatabase->prepare("SELECT COUNT(*) as count FROM allLike WHERE recepyid = :recepyid");
$query->bindParam(':recepyid', $recepyId);
$query->execute();
$count = $query->fetch(PDO::FETCH_ASSOC)['count'];

$query = $connectDatabase->prepare("UPDATE recepy SET liked = :liked WHERE id = :recepyid");
$query->bindParam(':liked', $count);
$query->bindParam(':recepyid', $recepyId);
$query->execute();

header("Location: ../../public_recepy.php");
exit();