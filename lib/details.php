<?php
session_start();
if (isset($_GET['id']) && !empty($_GET['id'])) {

    // si c'est bon je me connecte bd
    require_once('./bd.php');

    // nettoie l'id de envoyé de code html 
    $id = strip_tags($_GET['id']);

    $sql = 'select * from books WHERE idbooks = :id;';

    // on prepare la requete
    $stmt =  $pdo->prepare($sql);

    // on accroche les parametre 
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);

    // execute la requete
    $stmt->execute();
    // on recupere le id 
    $result = $stmt->fetch();
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

            </section>
            <div class="mt-3"><a href="index.php"> Retour</a> <a href="edit.php?id=<?= $result['title'] ?>"> Modifier</a>
            </div>
        </div>

    </main>




</body>
<footer><?php include './footer.php' ?></footer>

</html>