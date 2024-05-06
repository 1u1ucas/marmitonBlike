<?php
session_start();

$id = $_POST['recepy_id'];
$title = $_POST['title'];
$ingredient = $_POST['ingredients'];
$etape = $_POST['etapes'];

if (empty($_POST['private'])) {
    $private = 0;
} else {
    $private = $_POST['private'];
}
;

$connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");

$allowedPhotoTypes = array(
    'image/jpeg',
    'image/jpg',
    'image/png',
    'image/gif'
);

$allowedPdfTypes = array(
    'application/pdf'
);
if ($_FILES['file']['size'] > 0) {
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
    }
    $request = $connectDatabase->prepare("UPDATE recepy SET title = :title, ingredient = :ingredient, etape = :etape, image = :image, private = :private WHERE id = :id");
    //bind params
    $request->bindParam(':title', $title);
    $request->bindParam(':ingredient', $ingredient);
    $request->bindParam(':etape', $etape);
    $request->bindParam(':image', $image);
    $request->bindParam(':id', $id);
    $request->bindParam(':private', $private);
    //execute request
    $request->execute();

    header('Location: ../../recepy.php?success=Le post a bien été modifié');
}

//prepare request
$request = $connectDatabase->prepare("UPDATE recepy SET title = :title, ingredient = :ingredient, etape = :etape, private = :private WHERE id = :id");
//bind params
$request->bindParam(':title', $title);
$request->bindParam(':ingredient', $ingredient);
$request->bindParam(':etape', $etape);
$request->bindParam(':id', $id);
$request->bindParam(':private', $private);

//execute request
$request->execute();



header('Location: ../../recepy.php?success=Le post a bien été modifié');