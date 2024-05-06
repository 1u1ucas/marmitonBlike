<?php

$email = $_POST['email'];
$password = $_POST['password'];
$username = $_POST['username'];




if (empty($username) || empty($password) || empty($email)) {
    header("Location: ../../sign_up.php?error=Veuillez renseigner un username, un password et un email");
    die(); // stop the script
}

if (!empty($username) && !empty($password) && !empty($email)) {
    $hash_password = password_hash($password, PASSWORD_DEFAULT);
    //connect to db
    $connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
    //prepare request
    $request = $connectDatabase->prepare("SELECT * FROM users WHERE email = :email");
    //execute request

    $request->bindParam(':email', $email);

    $request->execute();


    // //fetch all data from table posts
    $users = $request->fetchAll(PDO::FETCH_ASSOC);



    if (empty($users)) {
        $connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
        // prepare request
        $request = $connectDatabase->prepare("INSERT INTO users (username, password, email) VALUES (:username, :password, :email)");
        // bind params,
        $request->bindParam(':email', $email);
        $request->bindParam(':password', $hash_password);
        $request->bindParam(':username', $username);
        // execute request
        $request->execute();
        header('Location: ../../index.php?success=Le user a bien été ajouté');

    } elseif (!empty($users)) {
        header("Location: ../../sign_up.php?error=L'utilisateur existe déjà");
    }
    // connect to db with PDO

}