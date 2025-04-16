<?php
session_start();
require_once('./bd.php');
$sql = 'select * from books';
$query =  $pdo->prepare($sql);
$query->execute();
$result = $query->fetchAll(PDO::FETCH_ASSOC);
require_once('./closebd.php');
?>

<?php include './head.php' ?>

<body>
    <nav><?php include './nav.php' ?></nav>
    <div class="message-de-errour">
        <?php
        if (!empty($_SESSION['erreur'])) {
            echo '<div class="alert alert-danger" role="alert">
                ' . $_SESSION['erreur'] . '
            </div>';
            $_SESSION['erreur'] = '';
        }
        ?>
    </div>
    <div class="button">
        <h1> Les liste de livres </h1>
        <a href="add.php" class="btn btn-primary">Ajouter un livre</a>
    </div>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Titre</th>
                            <th scope="col">Auteur</th>
                            <th scope="col">Catégorie</th>
                            <th scope="col">Date</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($result as $titre) {
                        ?>
                            <tr>
                                <td>
                                    <?= $titre['idbooks'] ?>
                                </td>
                                <td>
                                    <?php echo $titre['title']; ?></td>
                                <td>
                                    <?php echo $titre['author']; ?></td>
                                <td>
                                    <?php echo $titre['categorie']; ?></td>

                                <td>
                                    <?php echo $titre['date']; ?></td>
                                <td>
                                    <a href="details.php?id=<?= $titre['idbooks'] ?>">Voir</a>
                                </td>
                                <td>
                                    <a href="details.php?id=<?= $titre['idbooks'] ?>">supprimer</a>
                                </td>

                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </section>
        </div>

    </main>
</body>




<footer><?php include './footer.php' ?></footer>

</html>