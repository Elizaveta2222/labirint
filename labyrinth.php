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
                    <p>Выберите начало и конец</p>
                    <div id="cells">
                        <table>
                            <?php
                            foreach ($cells as $row)
                            {
                                echo "<tr>";
                                foreach ($row as $cell)
                                {
                                    echo "<td>";
                                    echo "<input type='button' class='cell' value='$cell'>";
                                    echo "</td>";
                                }
                                echo "</tr>";
                            }
                            ?>
                        </table>
                    </div>
                    <input type="submit" id="button" value="Вычислить"">
                </div>
            </form>
        </div>
    </main>
</div>
</body>
<script>
    document.querySelector('input').onclick = function(){
        console.log(this)  // теперь this это кнопка
        this.style.background = "red";
    }


</script>
</html>