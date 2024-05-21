<?php require_once 'parts/header.php';


// Connect to db
$connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");

$false = True

    ?>
<form action="" method="GET">
    <input type="text" name="search" placeholder="Rechercher par titre...">
    <input type="submit" value="Rechercher">
</form>

<?php
// Query for search results
$searchResults = [];
if (!empty($_GET['search'])) {
    $searchSql = "SELECT * FROM recepy WHERE private = :private AND title LIKE :search";
    $searchRequest = $connectDatabase->prepare($searchSql);
    $searchRequest->bindValue(':private', $false);
    $searchTerm = '%' . $_GET['search'] . '%';
    $searchRequest->bindValue(':search', $searchTerm, PDO::PARAM_STR);
    $searchRequest->execute();
    $searchResults = $searchRequest->fetchAll(PDO::FETCH_ASSOC);
}

// Query for all other posts
$sql = "SELECT * FROM recepy WHERE private = :private";
$request = $connectDatabase->prepare($sql);
$request->bindValue(':private', $false);
$request->execute();
$allRecepies = $request->fetchAll(PDO::FETCH_ASSOC);

// Merge search results and all other posts
$recepies = array_merge($searchResults, $allRecepies);

// Remove duplicates
$recepies = array_unique($recepies, SORT_REGULAR);
$recepies = array_values($recepies);
?>

<section id="post-list" class="contain">

    <?php foreach ($recepies as $index => $recepy):

        $query = $connectDatabase->prepare("SELECT username FROM users WHERE id = :userid");
        $query->bindParam(':userid', $recepy['userid']);
        $query->execute();
        $username = $query->fetch(PDO::FETCH_ASSOC)['username'];
        ?>


    <div class="<?php echo $index % 2 == 0 ? 'left' : 'right'; ?> post mb-3">
        <div class="leftPart">
            <h1><?php echo htmlspecialchars($recepy['title']); ?></h1>
            <p>Posté par <?php echo $username; ?></p>
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

                    if (isset($_SESSION['id'])):
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
                <form action="scripts/post/post-copy-script.php" method="POST">
                    <input type="hidden" name="recepy_id" value="<?php echo $recepy['id']; ?>">
                    <button type="submit" value="envoyer" class="btn btn-primary update toolTip">
                        <i class="fa-solid fa-copy"></i>
                        <span class="toolTipText">Copy</span>
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
                <?php endif; ?>
                <div class="btn btn-primary "> like: <?php echo htmlspecialchars($recepy['liked']) ?>
                </div>
                <form action="scripts/set-recepy-id/set-recepy-id.php" method="POST">
                    <input type="hidden" name="recepy_id" value="<?php echo $recepy['id']; ?>">
                    <button type="submit" value="envoyer" class="btn btn-primary update toolTip">
                        <i class="fa-solid fa-comment"></i>
                        <span class="toolTipText">Comment</span>
                    </button>
                </form>
            </div>
        </div>

    </div>


    <?php
    endforeach; ?>
</section>


<?php require_once 'parts/footer.php'; ?>