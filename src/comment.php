<?php require_once 'parts/header.php';

$recepyId = $_SESSION['recepy_id'];

$connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");

$query = $connectDatabase->prepare("SELECT * FROM allComment WHERE recepyid = :recepyid ORDER BY timestamp DESC");
$query->bindParam(':recepyid', $recepyId);
$query->execute();
$comments = $query->fetchAll(PDO::FETCH_ASSOC);

$request = $connectDatabase->prepare('SELECT * FROM recepy WHERE id = :id');
$request->bindParam(':id', $recepyId);
$request->execute();
$recepy = $request->fetch(PDO::FETCH_ASSOC);



?>

<h1>Commentaires</h1>
<form action="scripts/post-comment/post-comment.php" method="post">
    <input type="hidden" name="recepy_id" value="<?php echo $recepyId; ?>">
    <input name="comment" placeholder="Ajoutez un commentaire">
    <button class="btn btn-primary" type="submit">Poster le commentaire</button>
</form>
<section class="contain">
    <?php foreach ($comments as $comment): ?>
    <?php
        $query = $connectDatabase->prepare("SELECT username FROM users WHERE id = :userid");
        $query->bindParam(':userid', $comment['userid']);
        $query->execute();
        $username = $query->fetch(PDO::FETCH_ASSOC)['username'];
        ?>
    <div class="comment mb-3 left">
        <div class="leftPart">
            <h5>Commentaire de l'utilisateur <?php echo $username; ?></h5>
            <p><?php echo $comment['comment']; ?></p>
            <p>Posté le <?php echo $comment['timestamp']; ?></p>
        </div>
        <div class="rightPart">
            <?php if ($comment['userid'] == $_SESSION['id'] || $_SESSION['id'] == $recepy['userid']): ?>
            <form action="scripts/delete-comment/delete-comment.php" method="POST">
                <input type="hidden" name="comment_id" value="<?php echo $comment['id']; ?>">
                <button type="submit" value="envoyer" class="btn btn-primary update toolTip">
                    <i class="fa-solid fa-trash-can"></i>
                    <span class="toolTipText">Delete</span>
                </button>
            </form>
            <?php endif; ?>
        </div>
    </div>

    <?php endforeach; ?>
</section>


<?php require_once 'parts/footer.php'; ?>