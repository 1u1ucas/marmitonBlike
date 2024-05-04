<?php
session_start(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
        </script>
</head>

<body>
    <nav class="navbar text-center p-3 ">
        <?php if (!isset($_SESSION['id'])): ?>
            <a href="index.php">Log-in</a>
        <?php elseif (isset($_SESSION['id'])): ?>
            <a href="../scripts/sign-out/sign-out.php">Disconnect</a>
        <?php endif;

        //connect to db
        if (isset($_SESSION['id'])):
            $connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");

            $stmt = $connectDatabase->prepare("SELECT username FROM users WHERE id = :id");
            $stmt->execute([':id' => $_SESSION['id']]);
            $user = $stmt->fetch();
            $user = $user['username'];
        endif;
        ?>
    </nav>

    <div>
        <?php if (isset($_SESSION['id'])): ?>
            <p>Connecté en tant que <?php echo htmlspecialchars($user) ?></p>
        <?php else: ?>
            <p>Non connecté</p>
        <?php endif; ?>
    </div>