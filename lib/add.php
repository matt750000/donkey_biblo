<?php
session_start();
if ($_POST) {
    if (
        isset($_POST['title']) && !empty($_POST['title'])
        && isset($_POST['author']) && !empty($_POST['author'])
        && isset($_POST['categorie']) && !empty($_POST['categorie'])
        && isset($_POST['date']) && !empty($_POST['date'])
    ) {
    } else {
        $_SESSION['erreur'] = "le formulaire est incomplet";
        header('location: add.php');
    }
}
var_dump($_POST);

include './head.php' ?>

<body>
    <nav><?php include './nav.php' ?></nav>
    <div class="message-de-errour">
        <?php
        if (!empty($_SESSION['erreur'])) {
            echo '<div class="alert alert-danger" role="alert">
                ' . $_SESSION['erreur'] . '
            </div>';
        }
        ?>
    </div>
    <main class="container">
        <div class="row">
            <section class="col-12">
                <h1> Ajouter un livre </h1>
                <form method="post">
                    <div class="form-group">
                        <label for="title" class="form-label">Titre</label>
                        <input type="text" id="title" name="title" class="form-control" value="<?php echo $book['title']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="author" class="form-label">Auteur</label>
                        <input type="text" id="author" name="author" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="categorie" class="form-label">Catégorie </label>
                        <input type="text" id="categorie" name="categorie" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="date" class="form-label">Date de publication</label>
                        <input type="number" placeholder="YYYY" pattern="\d{4}" max="2025" id="date" name="date" class="form-control" required>
                    </div>
                    <div class="button1">
                        <input type="submit" class="btn btn-primary" value="Envoyer"> <a href="index.php" class="btn btn-primary">Annuler </a>
                    </div>
                </form>

            </section>
        </div>

    </main>
</body>




<footer><?php include './footer.php' ?></footer>

</html>