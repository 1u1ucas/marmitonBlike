<?php require_once 'parts/header.php';

//connect to db
$connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
//prepare request
$request = $connectDatabase->prepare("SELECT * FROM recepy where userid = :userid");


$request->bindParam(':userid', $_SESSION['id']);
//execute request
$request->execute();

//fetch all data from table posts
$recepies = $request->fetchAll(PDO::FETCH_ASSOC);
?>


<div class="super-contain">
    <section id="create-post" class="contain ">
        <form action="scripts/post/post-create-script.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <input type="text" class="formControl" placeholder="Title" name="title">

                <div id="ingredients" class="wrap mb-3">
                    <input type="text" class="size formControl " placeholder="Ingredient" name="ingredient">
                </div>
                <div class="wrap mb-3">
                    <button type="button" class="btn btn-primary size" id="add-ingredient">Add Ingredient</button>
                    <button type="button" class="btn btn-primary size" id="remove-ingredient">Remove
                        Ingredient</button>
                </div>
                <div id="etapes" class="wrap mb-3">
                    <input type="text" class="size formControl " placeholder="Etape" name="etape">
                </div>
                <div class="wrap mb-3">
                    <button type="button" class="btn btn-primary size" id="add-etape">Add Etape</button>
                    <button type="button" class="btn btn-primary size" id="remove-etape">Remove
                        Etape</button>
                </div>
                <input type="file" class="formControl" placeholder="file" name="file">

                <input type="hidden" id="combinedIngredients" name="ingredients">
                <input type="hidden" id="combinedEtapes" name="etapes">
            </div>

            <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                <?php echo $_GET['error']; ?>
            </div>
            <?php endif; ?>

            <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                <?php echo $_GET['success']; ?>
            </div>
            <?php endif; ?>

            <input type="submit" value="Envoyer" class="btn btn-primary">
        </form>

    </section>


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
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="rightPart">
                <img class="img" src="<?php echo $recepy['image'] ?>" alt="Image du post">
            </div>
        </div>


        <?php endforeach; ?>
    </section>


</div>
<script>
document.getElementById('add-ingredient').addEventListener('click', function() {
    var input = document.createElement('input');
    input.type = 'text';
    input.className = ' formControl size';
    input.placeholder = 'Ingredient';
    input.name = 'ingredient';
    document.getElementById('ingredients').appendChild(input);
});

document.getElementById('remove-ingredient').addEventListener('click', function() {
    var ingredientsDiv = document.getElementById('ingredients');
    if (ingredientsDiv.children.length > 1) {
        ingredientsDiv.removeChild(ingredientsDiv.lastChild);
    }
});


document.getElementById('add-etape').addEventListener('click', function() {
    var input = document.createElement('input');
    input.type = 'text';
    input.className = ' formControl size';
    input.placeholder = 'Etape';
    input.name = 'etape';
    document.getElementById('etapes').appendChild(input);
});

document.getElementById('remove-etape').addEventListener('click', function() {
    var etapesDiv = document.getElementById('etapes');
    if (etapesDiv.children.length > 1) {
        etapesDiv.removeChild(etapesDiv.lastChild);
    }
});

document.querySelector('form').addEventListener('submit', function(e) {
    var ingredients = Array.from(document.querySelectorAll('[name="ingredient"]')).map(function(input) {
        return input.value;
    });
    var etapes = Array.from(document.querySelectorAll('[name="etape"]')).map(function(input) {
        return input.value;
    });
    document.querySelector('[name="ingredients"]').value = ingredients.join(';');
    document.querySelector('[name="etapes"]').value = etapes.join(';');


});
</script>
<?php require_once 'parts/footer.php'; ?>