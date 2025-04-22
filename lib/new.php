<?php
session_start();
require_once('./bd.php');

$book = [
    'title' => '',
    'author' => '',
    'categorie' => '',
    'date' => '',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (
        isset($_POST['title']) && !empty($_POST['title']) &&
        isset($_POST['author']) && !empty($_POST['author']) &&
        isset($_POST['categorie']) && !empty($_POST['categorie']) &&
        isset($_POST['date']) && !empty($_POST['date'])
    ) {
        // Nettoyage des données
        $book['title'] = htmlspecialchars($_POST['title']);
        $book['author'] = htmlspecialchars($_POST['author']);
        $book['categorie'] = htmlspecialchars($_POST['categorie']);
        $book['date'] = (int)$_POST['date'];

        // Exécution d'une insertion
        $sql = "INSERT INTO books (title, author, categorie, date) VALUES (:title, :author, :categorie, :date)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':title' => $book['title'],
            ':author' => $book['author'],
            ':categorie' => $book['categorie'],
            ':date' => $book['date']
        ]);

        $_SESSION['success'] = "Livre ajouté avec succès";
        header('Location: index.php');
        exit();
    } else {
        $_SESSION['erreur'] = "Le formulaire est incomplet";
        header('Location: add.php');
        exit();
    }
};
