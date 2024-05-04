<?php require_once 'parts/header.php';

//connect to db
$connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
//prepare request
$request = $connectDatabase->prepare("SELECT * FROM recepy where userid = :userid ORDER BY id DESC");


$request->bindParam(':userid', $_SESSION['id']);
//execute request
$request->execute();

//fetch all data from table posts
$recepies = $request->fetchAll(PDO::FETCH_ASSOC);
?>

<section id="post-list" class="contain">
    <div class="post mb-3 center">
        <form action="createRecepy.php">
            <button type="submit" value="envoyer" class="create"> <i class="fa-solid fa-plus"></i></button>
        </form>
    </div>

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
                    <form action="recepyUpdate.php" method="POST">
                        <input type="hidden" name="recepy_id" value="<?php echo $recepy['id']; ?>">
                        <button type="submit" value="envoyer" class="btn btn-primary update toolTip">
                            <i class="fa-regular fa-pen-to-square "></i>
                            <span class="toolTipText">Update</span>
                        </button>
                    </form>
                    <form action="scripts/post/post-delete-script.php" method="POST">
                        <input type="hidden" name="recepy_id" value="<?php echo $recepy['id']; ?>">
                        <button type="submit" value="envoyer" class="btn btn-primary update toolTip">
                            <i class="fa-solid fa-trash-can"></i>
                            <span class="toolTipText">Delete</span>
                        </button>
                    </form>
                    <form action="scripts/post/post-duplicate-script.php" method="POST">
                        <input type="hidden" name="recepy_id" value="<?php echo $recepy['id']; ?>">
                        <button type="submit" value="envoyer" class="btn btn-primary update toolTip">
                            <i class="fa-solid fa-clone"></i>
                            <span class="toolTipText">Duplicate</span>
                        </button>
                    </form>
                    <form action="scripts/post/post-copy-script.php" method="POST">
                        <input type="hidden" name="recepy_id" value="<?php echo $recepy['id']; ?>">
                        <button type="submit" value="envoyer" class="btn btn-primary update toolTip">
                            <i class="fa-solid fa-copy"></i>
                            <span class="toolTipText">Copy</span>
                        </button>
                    </form>

                </div>

            </div>
        </div>


        <?php
    endforeach; ?>
</section>


<?php require_once 'parts/footer.php'; ?>