<?php
session_start();
require_once('./bd.php'); // Contient la connexion PDO

// Initialisation des variables
$account = [
    'username' => '',
    'email' => '',
    'password' => '',
];

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification des champs
    if (
        isset($_POST['username'], $_POST['email'], $_POST['password']) &&
        !empty($_POST['username']) && !empty($_POST['email']) &&
        !empty($_POST['password'])
        && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) &&
        preg_match("/^[a-zA-Z-' ]*$/", $_POST['username'])
    ) {
        // Nettoyage des données
        $account['username'] = htmlspecialchars(trim($_POST['username']));
        $account['email'] = htmlspecialchars(trim($_POST['email']));
        $account['password'] = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);


        // Vérifier si l'utilisateur existe déjà
        $sql = "SELECT id FROM users WHERE email= :email ";
        $check = $pdo->prepare($sql);
        $check->execute([':email' => $account['email']]);
        $userExists = $check->fetch();

        if ($userExists) {
            $_SESSION['erreur'] = "Vous avez déjà un compte. Connectez-vous.";
            header('Location: login.php'); // Redirection vers la page de connexion
            exit();
        }


        // Insertion en base de données
        $sql = "INSERT INTO users (username, email, password ) VALUES (:username, :email, :password )";
        $stmt = $pdo->prepare($sql);


        try {
            $stmt->execute([
                ':username' => $account['username'],
                ':email' => $account['email'],
                ':password' => $account['password'],

            ]);
            $_SESSION['success'] = "votre compte a ete cree avec succès.";
            header('Location: index.php');
            exit();
        } catch (PDOException $e) {
            $_SESSION['erreur'] = "Erreur lors de l'inscription : " . $e->getMessage();
        }
    } else {
        $_SESSION['erreur'] = "Veuillez remplir tous les champs.";
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
                <h1>Créer un compte</h1>

                <form method="post" action="">
                    <div class="form-group">
                        <label for="username">Utilisateur</label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Nom d'utilisateur" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Adresse Mail</label>
                        <input type="email" id="email" name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Mots de passe</label>
                        <input type="password" id="pass" name="password" minlength="8" class="form-control" required>
                    </div>
                    <div class="mt-3">
                        <input type="submit" class="btn btn-primary" value="Envoyer">
                        <a href="login.php" class="btn btn-secondary">Déjà inscrit?</a>
                    </div>
                </form>
            </section>
        </div>
    </main>

    <footer><?php include './footer.php'; ?></footer>
</body>

</html>