<?php
    include "db.php";
    $publisher = $_GET['publisher'];
    $literate = "Book";
    $sqlSelect = $dbh->prepare(
        "SELECT * FROM $db.LITERATURE 
        JOIN $db.BOOK_AUTHORS 
        on $db.LITERATURE.ID_BOOK = $db.BOOK_AUTHORS.FID_BOOK
        JOIN $db.AUTHORS 
        on $db.BOOK_AUTHORS.FID_AUTHORS = $db.AUTHORS.ID_AUTHORS
        where $db.LITERATURE.LITERATE = :literate and $db.LITERATURE.publisher = :publisher");
    $sqlSelect->execute(array('literate' => $literate, 'publisher' => $publisher));
    echo "Представленная по запросу информация: <ul>";
    while($cell=$sqlSelect->fetch(PDO::FETCH_BOTH)){
        echo "<li>Книга: $cell[1], автор: $cell[13], издательство: $publisher, год выпуска: $cell[5], ISBN $cell[3] </li>";
    }
    echo "</ul>";
?>