<?php require_once 'parts/header.php';

//connect to db
$connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
//prepare request
$request = $connectDatabase->prepare("SELECT * FROM recepy where private = :private ORDER BY id DESC");


$false = True;

$request->bindParam(':private', $false);
//execute request
$request->execute();

//fetch all data from table posts
$recepies = $request->fetchAll(PDO::FETCH_ASSOC);
?>

<section id="post-list" class="contain">

    <?php foreach ($recepies as $index => $recepy): ?>


        <div class="<?php echo $index % 2 == 0 ? 'left' : 'right'; ?> post mb-3">
            <div class="leftPart">
                <h1><?php echo htmlspecialchars($recepy['title']); ?></h1>
                <ul>
                    <?php
                    $recepy['ingredient'] = explode(";", $recepy['ingredient']);

                    foreach ($recepy['ingredient'] as $ingredient): ?>
                        <li><?php echo htmlspecialchars($ingredient); ?></li>
                    <?php endforeach; ?>
                </ul>
                <ul>
                    <?php
                    $recepy['etape'] = explode(";", $recepy['etape']);

                    foreach ($recepy['etape'] as $etape): ?>
                        <li><?php echo htmlspecialchars($etape); ?></li>

                    <?php endforeach;
                    ?>
                </ul>
            </div>
            <div class="rightPart">
                <img class="img" src="<?php echo $recepy['image'] ?>" alt="Image du post">
                <div class="contain-options">
                    <?php
                    $userId = $_SESSION['id'];
                    $postId = $recepy['id'];

                    $query = $connectDatabase->prepare("SELECT * FROM allLike WHERE userid = :userid AND recepyid = :recepyid");
                    $query->bindParam(':userid', $userId);
                    $query->bindParam(':recepyid', $postId);
                    $query->execute();
                    ?>
                    <?php if ($query->rowCount() > 0): ?>
                        <form action="scripts/recepy-like/recepy-like.php" method="POST">
                            <input type="hidden" name="recepy_id" value="<?php echo $recepy['id']; ?>">
                            <button type="submit" value="envoyer" class="btn btn-primary update toolTip">
                                <i class="fa-solid fa-heart"></i>
                                <span class="toolTipText">Unlike</span>
                            </button>
                        </form>
                    <?php else: ?>
                        <form action="scripts/recepy-like/recepy-like.php" method="POST">
                            <input type="hidden" name="recepy_id" value="<?php echo $recepy['id']; ?>">
                            <button type="submit" value="envoyer" class="btn btn-primary update toolTip">
                                <i class="fa-regular fa-heart"></i>
                                <span class="toolTipText">Like</span>
                            </button>
                        </form>
                    <?php endif; ?>
                    <div class="btn btn-primary "> like: <?php echo htmlspecialchars($recepy['liked']) ?>
                    </div>
                </div>
            </div>

        </div>


        <?php
    endforeach; ?>
</section>


<?php require_once 'parts/footer.php'; ?>