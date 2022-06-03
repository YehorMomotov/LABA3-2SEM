<?php
$db = "iteh_var0";
$dsn = "mysql:host=localhost";
$user = "root";
$pass = "";
$dbh = new PDO($dsn, $user, $pass);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Лаба3</title>
    <script>
        var ajax = new XMLHttpRequest();

function form1() {
    ajax.onreadystatechange = function() {
        if (ajax.readyState === 4) {
            if (ajax.status === 200) {
                console.dir(ajax.responseText);
                document.getElementById("res").innerHTML = ajax.response;
            }
        }
    }
    var publisher = document.getElementById("publisher").value;
    console.dir(publisher);
    ajax.open("get", "form1.php?publisher=" + publisher);
    ajax.send();
}

function form2() {
    ajax.onreadystatechange = function() {
        if (ajax.readyState === 4) {
            if (ajax.status === 200) {

                console.dir(ajax);
                let rows = ajax.responseXML.firstChild.children;
                let result = "Представленная по запросу информация: <ul>";
                for (var i = 0; i < rows.length; i++) {
                    result += "<li>";
                    result += "Книга: " + rows[i].children[0].firstChild.nodeValue;
                    result += ", автор: " + rows[i].children[1].firstChild.nodeValue;
                    result += ", издательство: " + rows[i].children[2].firstChild.nodeValue;
                    result += ", <b>год выпуска: " + rows[i].children[3].firstChild.nodeValue;
                    result += "</b>, ISBN" + rows[i].children[4].firstChild.nodeValue;
                    result += "</li>";
                }
                result += "</ul>";
                document.getElementById("res").innerHTML = result;
            }
        }
    }
    var year_min = document.getElementById("year_min").value;
    var year_max = document.getElementById("year_max").value;
    ajax.open("get", "form2.php?year_min=" + year_min + "&year_max=" + year_max);
    ajax.send();
}

function form3() {
    ajax.onreadystatechange = function() {
    let rows = JSON.parse(ajax.responseText);
    console.dir(rows);
    if (ajax.readyState === 4) {
        if (ajax.status === 200) {
            console.dir(ajax);
            let result = "Представленная по запросу информация: <ul>";
            for (var i = 0; i < rows.length; i++) {
                result += "<li>";
                result += "Книга: " + rows[i].title;
                result += ", автор: " + rows[i].name;
                result += ", издательство: " + rows[i].publisher;
                result += ", <b>год выпуска: " + rows[i].year;
                result += "</b>, ISBN" + rows[i].ISBN;
                result += "</li>";
                }
            result += "</ul>";
            document.getElementById("res").innerHTML = result;
            }
        }
    }
    var author = document.getElementById("author").value;
    ajax.open("get", "form3.php?author=" + author);
    ajax.send();
}
    </script>
</head>
<body>
<p><strong> Информация о книгах издательства: </strong>
        <select name="publisher" id="publisher">
            <?php
            $sql = "SELECT DISTINCT publisher FROM $db.LITERATURE";
            $sql = $dbh->query($sql);
            foreach ($sql as $cell) {
                echo "<option> $cell[0] </option>";
            }
            ?>
        </select>
    <button onclick="form1()">ОК</button>
</p>

<p><strong>Информация о книгах, журналах, газетах, опубликованных за указанный период:</strong>
        <select name="year_min" id="year_min">
            <?php
            $sql = "SELECT DISTINCT year FROM $db.LITERATURE";
            $sql = $dbh->query($sql);
            foreach ($sql as $cell) {
                if($cell[0] == 0)
                    continue;
                else
                    echo "<option> $cell[0] </option>";
            }
            $sql = "Select distinct year(date) from $db.LITERATURE";
            $sql = $dbh->query($sql);
            foreach ($sql as $cell) {
                if($cell[0] == 0)
                    continue;
                else
                    echo "<option> $cell[0] </option>";
            }
            ?>
        </select>
        <select name="year_max" id="year_max">
        <?php
            $sql = "SELECT DISTINCT year FROM $db.LITERATURE";
            $sql = $dbh->query($sql);
            foreach ($sql as $cell) {
                if($cell[0] == 0)
                    continue;
                else
                    echo "<option> $cell[0] </option>";
            }
            $sql = "Select distinct year(date) from $db.LITERATURE";
            $sql = $dbh->query($sql);
            foreach ($sql as $cell) {
                if($cell[0] == 0)
                    continue;
                else
                    echo "<option> $cell[0] </option>";
            }
            ?>
        </select>
    <button onclick="form2()">ОК</button>
</p>
<p><strong> Вывести информацию о книгах автора: </strong>
        <select name="author" id="author">
            <?php
            $sql = "SELECT DISTINCT name FROM $db.authors";
            $sql = $dbh->query($sql);
            foreach ($sql as $cell) {
                echo "<option> $cell[0] </option>";
            }
            ?>
        </select>
    <button onclick="form3()">ОК</button>
</p>
<p id="res"></p>
</body>
</html>