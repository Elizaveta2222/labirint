<?php
include 'handler/getMatrix.php';
?>

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
        <div class="main-block">
            <form method="post">
                <div id="container">
                    <p>Полученное поле</p>
                    <div id="cells">
                        <table>
                            <?php
                            $cells = $_SESSION["cells"];
                            echo "<tr>";
                            echo "<td class='cell'>  </td>";
                            for($i = 0; $i < count($cells); $i++)
                                echo "<td class='cell'>$i</td>";
                            echo "</tr>";
                            $i = 0;
                            foreach ($cells as $row)
                            {
                                echo "<tr>";
                                echo "<td class='cell'>$i</td>";
                                foreach ($row as $cell)
                                {
                                    echo "<td class='cell _block'>";
                                    if ($cell != "") echo $cell;
                                    else echo "0";
                                    echo "</td>";
                                }
                                echo "</tr>";
                                $i++;
                            }
                            ?>
                        </table>
                    </div>
                    <form action="labyrinth.php" method="post">
                        <div id="container">
                            <p>Выберите координаты входа:
                                <input type='number' name='fromX' class="from" value='0' min="0""/>
                                .
                                <input type='number' name='fromY' class="from" value='0' min="0"/>
                            </p>
                            <p>Выберите координаты выхода:
                                <input type='number' name='toX' class="to" value='<?=count($cells)-1?>' min="0""/>
                                .
                                <input type='number' name='toY' class="to" value='<?=count($cells[0])-1?>' min="0"/>
                            </p>
                            <input type="submit" name="button" id="button" value="Вычислить"">
                        </div>
                        <p>
                            <?php
                            // вывод ошибки, если есть
                            if (isset($_SESSION["error"]))
                                echo $_SESSION["error"];
                            // если уже был запрошен и получен, выводится путь
                            elseif(isset($path))
                            {
                                echo "Кратчайший путь: ";
                                while (!empty($path))
                                {
                                    $point = array_pop($path);
                                    echo "($point->x, $point->y); ";
                                }
                            }
                            ?>
                        </p>
                    </form>
                </div>
            </form>
        </div>
    </main>
</div>
</body>
</html>