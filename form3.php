<?php
    include "db.php";
    header('Content-Type: application/json');
    header('Cache-Control: no-cache, must-revalidate');
    $author = $_GET['author'];
    $literate = "Book";
    $sqlSelect = $dbh->prepare(
        "SELECT * FROM $db.LITERATURE 
        JOIN $db.BOOK_AUTHORS 
        on $db.LITERATURE.ID_BOOK = $db.BOOK_AUTHORS.FID_BOOK
        JOIN $db.AUTHORS 
        on $db.BOOK_AUTHORS.FID_AUTHORS = $db.AUTHORS.ID_AUTHORS
        where $db.LITERATURE.LITERATE = :literate and $db.AUTHORS.name = :author");
    $sqlSelect->execute(array('literate' => $literate, 'author' => $author));
    $cell=$sqlSelect->fetchAll(PDO::FETCH_OBJ);
    echo json_encode($cell);
?>