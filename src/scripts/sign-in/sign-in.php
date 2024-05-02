<?php
session_start();

$username = $_POST['username'];




if (empty($username)) {
    header("Location: ../../index.php?error=Veuillez renseigner un username");
    die(); // stop the script
}

if (!empty($username)) {

    //connect to db
    $connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
    //prepare request
    $request = $connectDatabase->prepare("SELECT * FROM users WHERE username = :username");
    //execute request

    $request->bindParam(':username', $username);

    $request->execute();


    // //fetch all data from table posts
    $users = $request->fetchAll(PDO::FETCH_ASSOC);



    if (empty($users)) {
        $connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
        $request = $connectDatabase->prepare("INSERT INTO users (username) VALUES (:username)");
        $request->bindParam(':username', $username);
        $request->execute();
        $connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
        //prepare request
        $request = $connectDatabase->prepare("SELECT * FROM users WHERE username = :username");
        //execute request

        $request->bindParam(':username', $username);

        $request->execute();


        // //fetch all data from table posts
        $users = $request->fetchAll(PDO::FETCH_ASSOC);

        $_SESSION['id'] = $users['0']['id'];
        $_SESSION['username'] = $username;
        header('Location: ../../recepy.php?success=vous etes bien inscrit');

    } elseif (!empty($users)) {

        $_SESSION['id'] = $users['0']['id'];
        $_SESSION['username'] = $users['0']['username'];
        header("Location: ../../recepy.php?success=vous etes bien connecté");



    }
    // connect to db with PDO

}