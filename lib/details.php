<?php
session_start();
if (isset($_GET['id']) && !empty($_GET['id'])) {

    // si c'est bon je me connecte bd
    require_once('./bd.php');

    // nettoie l'id de envoyé de code html 
    $id = strip_tags($_GET['id']);

    $sql = 'select * from books WHERE idbooks = :id;';

    // on prepare la requete
    $query =  $pdo->prepare($sql);

    // on accroche les parametre 
    $query->bindValue(':id', $id, PDO::PARAM_INT);

    // execute la requete
    $query->execute();
    // on recupere le id 
    $result = $query->fetch();
    if (!$result) {
        $_SESSION['erreur'] = "livre invalide";
        header('location: index.php');
    }
} else {
    $_SESSION['erreur'] = "url invalide";
    header('location: index.php');
}
?>
<?php include './head.php' ?>

<body>
    <nav><?php include './nav.php' ?></nav>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <h1> Détailes de livre : <?= $result['title'] ?></h1>
                <p><strong>Id : </strong><?= $result['idbooks'] ?></p>
                <p><strong>Autour : </strong><?= $result['author'] ?></p>
                <p><strong>catégorie : </strong><?= $result['categorie'] ?></p>
                <p><strong>Date de publication : </strong><?= $result['date'] ?></p>
                <p><a href="index.php"> Retour</a> <a href="edit.php?id=<?= $result['title'] ?>"> Modifier</a></p>




</body>
<footer><?php include './footer.php' ?></footer>

</html>