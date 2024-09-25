<?php

session_start();

include_once "mysql.php";

if (!isset($_SESSION["LOGGED_USER"])) {
    echo "Il faut être authentifié pour cette action.";
    exit();
}

$postData = $_POST;

if (!isset($postData["id"]) || !is_numeric($postData["id"])) {
    echo "Il faut un identifiant valide pour supprimer une recette.";
    return;
}

$deleteRecipeStatement = $db->prepare("DELETE FROM recipes WHERE recipe_id = :id");
$deleteRecipeStatement->execute([
    "id" => (int) $postData["id"],
]);

header("Location: index.php");
