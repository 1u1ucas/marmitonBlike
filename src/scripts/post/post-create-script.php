<?php
session_start();

$allowedPhotoTypes = array(
    'image/jpeg',
    'image/jpg',
    'image/png',
    'image/gif'
);

$allowedPdfTypes = array(
    'application/pdf'
);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["file"])) {
    $file = $_FILES["file"];
    $uploads_dir = '../../uploads';
    foreach ($file as $key => $error) {
        if ($error == UPLOAD_ERR_OK) {
            $tmp_name = $file['tmp_name'];
            $name = $file['name'];
            move_uploaded_file($tmp_name, "$uploads_dir/$name");
            $image = "$uploads_dir/$name";
        }
    }

    $title = $_POST['title'];
    $ingredient = $_POST['ingredients'];
    $etape = $_POST['etapes'];
    $userid = $_SESSION['id'];


    if (empty($title) || empty($ingredient) || empty($etape)) {
        header("Location: ../../recepy.php?error=Veuillez renseigner un titre, les ingrédients et les étapes.");
        exit();
    }

    $connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
    $request = $connectDatabase->prepare("INSERT INTO recepy (title, ingredient, etape, userid, image) VALUES (:title, :ingredient, :etape, :userid, :image)");

    $request->bindParam(':title', $title);
    $request->bindParam(':ingredient', $ingredient);
    $request->bindParam(':etape', $etape);
    $request->bindParam(':userid', $userid);
    $request->bindParam(':image', $image);

    if (!$request->execute()) {
        header("Location: ../../recepy.php?error=Une erreur s'est produite lors de l'ajout du post.");
        exit();
    }

    header('Location: ../../recepy.php?success=Le post a bien été ajouté');
    exit();
} else {
    header("Location: ../../recepy.php?error=Seuls les fichiers photos (JPEG, JPG, PNG, GIF) et les fichiers PDF sont autorisés.");
    exit();
}