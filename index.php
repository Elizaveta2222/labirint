<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Настройка лабиринта</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/main.css">
    <meta name="viewport" content="width=devixe-width, initial-scale=1.0">
</head>

<body>
<div class="wrapper">
    <main class="page">
        <div class="main-block">
        <form action="labyrinth.php" method="post">
            <div id="container">
                <p>Выберите размеры лабиринта:
                    <input type='number' id='sizeX' class="size" value='6' min="1""/>
                    X
                    <input type='number' id='sizeY' class="size" value='6' min="1"/>
                </p>
                <p>Заполните лабиринт:</p>
                <div id="cells"></div>
                <input type="submit" id="button" value="Добавить"">
            </div>
        </form>
        </div>
    </main>
</div>
</body>
<script type="text/javascript" src="js/inputCells.js"></script>
</html>