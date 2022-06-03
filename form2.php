<?php
    include "db.php";
    header('Content-Type: text/xml');
    header('Cache-Control: no-cache, must-revalidate');
    echo '<?xml version="1.0" encoding="UTF-8"?>';
    echo "<root>";
    $year_min = $_GET['year_min'];
    $year_max = $_GET['year_max'];
    $sqlSelect = $dbh->prepare(
        "SELECT * FROM $db.LITERATURE 
        JOIN $db.BOOK_AUTHORS 
        on $db.LITERATURE.ID_BOOK = $db.BOOK_AUTHORS.FID_BOOK
        JOIN $db.AUTHORS 
        on $db.BOOK_AUTHORS.FID_AUTHORS = $db.AUTHORS.ID_AUTHORS
        where $db.LITERATURE.year >= :year_min and $db.LITERATURE.year <= :year_max");
    $sqlSelect->execute(array('year_min' => $year_min, 'year_max' => $year_max));
    while($cell=$sqlSelect->fetch(PDO::FETCH_BOTH)){
        echo "<row><book>$cell[1]</book><author>$cell[13]</author><publisher>$cell[7]</publisher><year>$cell[5]</year><isbn>$cell[3]</isbn></row>";
    }
    $sqlSelect = $dbh->prepare(
        "SELECT * FROM $db.LITERATURE 
        JOIN $db.BOOK_AUTHORS 
        on $db.LITERATURE.ID_BOOK = $db.BOOK_AUTHORS.FID_BOOK
        JOIN $db.AUTHORS 
        on $db.BOOK_AUTHORS.FID_AUTHORS = $db.AUTHORS.ID_AUTHORS
        where year($db.LITERATURE.date) >= :year_min and year($db.LITERATURE.date) <= :year_max");
    $sqlSelect->execute(array('year_min' => $year_min, 'year_max' => $year_max));
    while($cell=$sqlSelect->fetch(PDO::FETCH_BOTH)){
        echo "<row><book>$cell[1]</book><author>$cell[13]</author><publisher>$cell[7]</publisher><year>$cell[5]</year><isbn>$cell[3]</isbn></row>";
        echo "<row><book>$cell[1]</book><author>$cell[13]</author><publisher>$cell[7]</publisher><year>$cell[5]</year><isbn>$cell[3]</isbn></row>";
    }
    echo "</root>";
?>
