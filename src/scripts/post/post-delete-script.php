<?php

session_start();

$recepy_id = $_POST['recepy_id'];
//connect to db
    $connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
    //prepare request
    $request = $connectDatabase->prepare("DELETE FROM recepy WHERE id = :id");
    //bind params
    $request->bindParam(':id', $recepy_id);
    //execute request
    $request->execute();
    $result = $request->fetch(PDO::FETCH_ASSOC);

    $request = $connectDatabase->prepare("DELETE FROM allComment WHERE recepyid = :recepyid ");
    $request->bindParam(':recepyid', $recepy_id);
    $request->execute();

    $request = $connectDatabase->prepare("DELETE FROM allLike WHERE recepyid = :recepyid ");
    $request->bindParam(":recepyid", $recepy_id);
    $request->execute();

    header('Location: ../../recepy.php?success=Le post a bien été supprimé');