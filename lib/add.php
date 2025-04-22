<?php
session_start();
require_once('./bd.php'); // Contient la connexion PDO

// Initialisation des variables
$book = [
    'title' => '',
    'author' => '',
    'categorie' => '',
    'date' => '',
];

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification des champs
    if (
        isset($_POST['title'], $_POST['author'], $_POST['categorie'], $_POST['date']) &&
        !empty($_POST['title']) && !empty($_POST['author']) &&
        !empty($_POST['categorie']) && !empty($_POST['date'])
    ) {
        // Nettoyage des données
        $book['title'] = htmlspecialchars(trim($_POST['title']));
        $book['author'] = htmlspecialchars(trim($_POST['author']));
        $book['categorie'] = htmlspecialchars(trim($_POST['categorie']));
        $book['date'] = (int) $_POST['date'];

        // Insertion en base de données
        $sql = "INSERT INTO books (title, author, categorie, date) VALUES (:title, :author, :categorie, :date)";
        $stmt = $pdo->prepare($sql);

        try {
            $stmt->execute([
                ':title' => $book['title'],
                ':author' => $book['author'],
                ':categorie' => $book['categorie'],
                ':date' => $book['date']
            ]);
            $_SESSION['success'] = "Livre ajouté avec succès.";
            header('Location: index.php');
            exit();
        } catch (PDOException $e) {
            $_SESSION['erreur'] = "Erreur lors de l'insertion : " . $e->getMessage();
        }
    } else {
        $_SESSION['erreur'] = "Veuillez remplir tous les champs.";
    }
}
?>

<?php include './head.php'; ?>

<body>
    <nav><?php include './nav.php'; ?></nav>

    <main class="container">
        <div class="row">
            <section class="col-12">
                <h1>Ajouter un livre</h1>

                <?php if (!empty($_SESSION['erreur'])): ?>
                    <div class="alert alert-danger"><?php echo $_SESSION['erreur'];
                                                    unset($_SESSION['erreur']); ?></div>
                <?php endif; ?>

                <?php if (!empty($_SESSION['success'])): ?>
                    <div class="alert alert-success"><?php echo $_SESSION['success'];
                                                        unset($_SESSION['success']); ?></div>
                <?php endif; ?>

                <form method="post" action="add.php">
                    <div class="form-group">
                        <label for="title">Titre</label>
                        <input type="text" id="title" name="title" class="form-control" value="<?php echo $book['title']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="author">Auteur</label>
                        <input type="text" id="author" name="author" class="form-control" value="<?php echo $book['author']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="categorie">Catégorie</label>
                        <input type="text" id="categorie" name="categorie" class="form-control" value="<?php echo $book['categorie']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="date">Date de publication</label>
                        <input type="number" id="date" name="date" class="form-control" placeholder="YYYY" max="2025" value="<?php echo $book['date']; ?>" required>
                    </div>
                    <div class="mt-3">
                        <input type="submit" class="btn btn-primary" value="Ajouter">
                        <a href="index.php" class="btn btn-secondary">Annuler</a>
                    </div>
                </form>
            </section>
        </div>
    </main>

    <footer><?php include './footer.php'; ?></footer>
</body>

</html>