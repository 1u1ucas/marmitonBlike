<?php
require_once 'parts/header.php';
?>
<form action="scripts/post/post-paste-script.php" method="POST">
    <input type="hidden" name="recepy_id" value="<?php echo $recepy['id']; ?>">
    <button type="submit" value="envoyer" class="btn btn-primary update toolTip">
        <i class="fa-solid fa-paste"></i>
        <span class="toolTipText">Paste</span>
    </button>
</form>
<div class="gap"></div>
<form id='create-post' action="scripts/post/post-create-script.php" method="POST" enctype="multipart/form-data">

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
    <div>
        <input type="checkbox" name="private" value="1"> public
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

    document.querySelector('#create-post').addEventListener('submit', function (e) {
        var ingredients = Array.from(document.querySelectorAll('[name="ingredient"]')).map(function (input) {
            return input.value;
        });
        var etapes = Array.from(document.querySelectorAll('[name="etape"]')).map(function (input) {
            return input.value;
        });
        document.querySelector('[name="ingredients"]').value = ingredients.join(';');
        document.querySelector('[name="etapes"]').value = etapes.join(';');


    });
</script>

<?php require_once 'parts/footer.php'; ?>