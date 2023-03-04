<!DOCTYPE html>
<html>

<head>
    <title>Лабиринт</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/main.css">
    <meta name="viewport" content="width=devixe-width, initial-scale=1.0">
</head>

<body>
<div class="wrapper">
    <main class="page">
        <form method="post">
            <div id="container">
                <p>Выберите размеры лабиринта:
                    <input type='number' id='sizeX' class="size" value='6' min="1""/>
                    <input type='number' id='sizeY' class="size" value='6' min="1"/>
                </p>
                <div id="cells"></div>
                <input type="submit" value="Добавить"">
            </div>
        </form>
    </main>
</div>
</body>
<script type="text/javascript" src="js/inputCells.js"></script>
</html>