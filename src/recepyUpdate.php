<?php
require_once 'parts/header.php';


$id = $_POST['recepy_id'];

$connectDatabase = new PDO("mysql:host=db;dbname=wordpress", "root", "admin");
//prepare request
$request = $connectDatabase->prepare("SELECT * FROM recepy where id = :id");

$request->bindParam(':id', $id); // Change ':userid' to ':id'
//execute request
$request->execute();

//fetch all data from table posts
$recepy = $request->fetchAll(PDO::FETCH_ASSOC);

?>

<form action="scripts/post/post-update-script.php" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <input type="text" class="formControl" placeholder="Title" name="title"
            value="<?php echo htmlspecialchars($recepy['0']['title']) ?>">

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
        <div class="super-contain center">
            <img class="img-update" src="<?php echo $recepy['0']['image'];
            ?>" alt="Current Image">
            <input type="file" class="formControl" placeholder="file" name="file">
        </div>

        <input type="hidden" id="combinedIngredients" name="ingredients">
        <input type="hidden" id="combinedEtapes" name="etapes">
    </div>
    <div>
        <input type="checkbox" name="private" value="1" <?php echo ($recepy['0']['private'] == 1) ? 'checked' : '' ?>>
        public
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

    <input type="hidden" name="recepy_id" value="<?php echo $id; ?>">
    <input type="submit" value="Envoyer" class="btn btn-primary">
</form>

<script>
    document.getElementById('add-ingredient').addEventListener('click', function () {
        var input = document.createElement('input');
        input.type = 'text';
        input.className = ' formControl size';
        input.placeholder = 'Ingredient';
        input.name = 'ingredient';
        document.getElementById('ingredients').appendChild(input);
    });

    document.getElementById('remove-ingredient').addEventListener('click', function () {
        var ingredientsDiv = document.getElementById('ingredients');
        if (ingredientsDiv.children.length > 1) {
            ingredientsDiv.removeChild(ingredientsDiv.lastChild);
        }
    });


    document.getElementById('add-etape').addEventListener('click', function () {
        var input = document.createElement('input');
        input.type = 'text';
        input.className = ' formControl size';
        input.placeholder = 'Etape';
        input.name = 'etape';
        document.getElementById('etapes').appendChild(input);
    });

    document.getElementById('remove-etape').addEventListener('click', function () {
        var etapesDiv = document.getElementById('etapes');
        if (etapesDiv.children.length > 1) {
            etapesDiv.removeChild(etapesDiv.lastChild);
        }
    });

    document.querySelector('form').addEventListener('submit', function (e) {
        var ingredients = Array.from(document.querySelectorAll('[name="ingredient"]')).map(function (input) {
            return input.value;
        });
        var etapes = Array.from(document.querySelectorAll('[name="etape"]')).map(function (input) {
            return input.value;
        });
        document.querySelector('[name="ingredients"]').value = ingredients.join(';');
        document.querySelector('[name="etapes"]').value = etapes.join(';');


    });

    document.addEventListener('DOMContentLoaded', function () {
        var ingredients = "<?php echo $recepy['0']['ingredient']; ?>".split(';');
        var etapes = "<?php echo $recepy['0']['etape']; ?>".split(';');

        ingredients.forEach(function (ingredient, index) {
            if (index === 0) {
                var input = document.querySelector('[name="ingredient"]');
                input.value = ingredient;
            } else {
                var input = document.createElement('input');
                input.type = 'text';
                input.className = ' formControl size';
                input.placeholder = 'Ingredient';
                input.name = 'ingredient';
                input.value = ingredient;
                document.getElementById('ingredients').appendChild(input);
            }

        });

        etapes.forEach(function (etape, index) {
            if (index === 0) {
                var input = document.querySelector('[name="etape"]');
                input.value = etape;
            } else {
                var input = document.createElement('input');
                input.type = 'text';
                input.className = ' formControl size';
                input.placeholder = 'Etape';
                input.name = 'etape';
                input.value = etape;
                document.getElementById('etapes').appendChild(input);
            }
        });
    });

    document.querySelector('form').addEventListener('submit', function (e) {
        var ingredients = Array.from(document.querySelectorAll('[name="ingredient"]')).map(function (input) {
            return input.value;
        });
        var etapes = Array.from(document.querySelectorAll('[name="etape"]')).map(function (input) {
            return input.value;
        });
        document.querySelector('[name="ingredients"]').value = ingredients.join(';');
        document.querySelector('[name="etapes"]').value = etapes.join(';');


    });

    document.querySelector('input[type="file"]').addEventListener('change', function (event) {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.querySelector('.img-update').src = e.target.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });
</script>

<?php require_once 'parts/footer.php'; ?>