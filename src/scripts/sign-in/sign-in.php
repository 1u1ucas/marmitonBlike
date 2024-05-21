<?php

$email = $_POST['email'];
$password = $_POST['password'];

if (empty($email) || empty($password)) {
    header("Location: ../../index.php?error=Veuillez renseigner un email et un password");
    die(); // stop the script
}


//connect to db
$connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
//prepare request
$request = $connectDatabase->prepare("SELECT * FROM users WHERE email = :email");
//execute request



$request->bindParam(':email', $email);


$request->execute();


// //fetch all data from table posts
$users = $request->fetch(PDO::FETCH_ASSOC);

if (empty($users)) {
    header("Location: ../../index.php?error=Email or password is incorrect");
    die(); // stop the script
}
$isValidPassword = password_verify($password, $users['password']);

if (empty($users || !$isValidPassword)) {
    header("Location: ../../index.php?error=Email or password is incorrect");
    die(); // stop the script

} elseif (!empty($users && $isValidPassword)) {
    header('Location: ../../public_recepy.php?success=Le user a bien été connecté');
    session_start();

    $_SESSION['id'] = $users['id'];
    $_SESSION['username'] = $users['username'];
}