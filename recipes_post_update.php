<?php
session_start();

include_once "mysql.php";
if (!isset($_SESSION["LOGGED_USER"])) {
    echo "Il faut être authentifié pour cette action.";
    exit();
}

$postData = $_POST;

if (
    !isset($postData["id"]) ||
    !is_numeric($postData["id"]) ||
    empty($postData["title"]) ||
    empty($postData["recipe"]) ||
    trim(strip_tags($postData["title"])) === "" ||
    trim(strip_tags($postData["recipe"])) === ""
) {
    echo 'Il manque des informations pour permettre l\'édition du formulaire.';
    return;
}

$id = (int) $postData["id"];
$title = trim(strip_tags($postData["title"]));
$recipe = trim(strip_tags($postData["recipe"]));

$insertRecipeStatement = $db->prepare("UPDATE recipes SET title = :title, recipe = :recipe WHERE recipe_id = :id");
$insertRecipeStatement->execute([
    "title" => $title,
    "recipe" => $recipe,
    "id" => $id,
]);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site de Recettes - Création de recette</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>
<body class="d-flex flex-column min-vh-100">
    <div class="container">

        <?php require_once __DIR__ . "/header.php"; ?>
        <h1>Recette modifiée avec succès !</h1>

        <div class="card">

            <div class="card-body">
                <h5 class="card-title"><?php echo $title; ?></h5>
                <p class="card-text"><b>Email</b> : <?php echo $_SESSION["LOGGED_USER"]; ?></p>
                <p class="card-text"><b>Recette</b> : <?php echo $recipe; ?></p>
            </div>
        </div>
    </div>
    <?php require_once __DIR__ . "/footer.php"; ?>
</body>
</html>
