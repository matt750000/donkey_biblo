<?php
session_start();
require_once('./bd.php');
include('./head.php');

$book = [
    'title' => '',
    'author' => '',
    'categorie' => '',
    'date' => '',
];
foreach ($_POST as $key => $value) {
    $book[$key] = $value;
}

var_dump($book);
