<?php
session_start();
require_once('./bd.php'); // Contient la connexion PDO

// Initialisation des variables
$account = [
    'email' => '',
    'password' => '',
];

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification des champs
    if (
        isset($_POST['email'], $_POST['password'])
        && !empty($_POST['email']) &&
        !empty($_POST['password'])

    ) {
        // Nettoyage des données
        $account['email'] = htmlspecialchars(trim($_POST['email']));
        $account['password'] = trim($_POST['password']);


        // Vérifier si l'utilisateur existe déjà
        $sql = "SELECT * FROM users WHERE email = :email";
        $check = $pdo->prepare($sql);
        $check->execute([':email' => $account['email']]);
        $user = $check->fetch();


        if ($user && password_verify($account['password'], $user['password'])) {
            $_SESSION['success'] = "vous etes connecte avec succès.";
            header('Location: index.php');
            exit();
        } else {


            $_SESSION['erreur'] = "Erreur lors de la connexion sinon Créer un compte : ";
        }
    } else {
        $_SESSION['erreur'] = "Veuillez réessayer.";
    }
}
?>

<?php include './head.php'; ?>

<body>
    <nav><?php include './nav.php'; ?></nav>
    <div class="message-de-errour">
        <?php if (!empty($_SESSION['erreur'])): ?>
            <div class="alert alert-danger"><?php echo $_SESSION['erreur'];
                                            unset($_SESSION['erreur']); ?></div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success"><?php echo $_SESSION['success'];
                                                unset($_SESSION['success']); ?></div>
        <?php endif; ?>
    </div>

    <main class="container">
        <div class="row">
            <section class="col-12">
                <h1>Connexion à l'espace particulier</h1>

                <form method="post" action="">
                    <div class="form-group">
                        <label for="email">Adresse Mail</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mots de passe</label>
                        <input type="password" id="password" name="password" minlength="8" class="form-control" required>
                    </div>
                    <div class="mt-3">
                        <input type="submit" class="btn btn-primary" value="Connexion">
                        <a href="index.php" class="btn btn-secondary">Retour</a>
                    </div>
                </form>
            </section>
        </div>
    </main>

    <footer><?php include './footer.php'; ?></footer>
</body>

</html>