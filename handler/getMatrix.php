<?php
session_start();
unset($_SESSION["error"]);

if (isset($_POST["cells"]))
{
    $_SESSION["cells"] = $_POST["cells"];
}

if(isset($_POST["button"]))
{
    include "classes/Point.php";
    include "classes/PathSearch.php";

    if(isset($_POST["fromX"]) && isset($_POST["fromY"]) && isset($_POST["toX"]) && isset($_POST["toY"]))
    {
        try {
            $from = new Point($_POST["fromX"], $_POST["fromY"]);
            $to = new Point($_POST["toX"], $_POST["toY"]);
            $search = new PathSearch($_SESSION["cells"], $from, $to);
            $path = $search->getShortestPath();
        }
        catch (TypeError $ex)
        {
            $_SESSION["error"] = "Точки входа не могут иметь пустые координаты";
        }
        catch(Exception $ex)
        {
            $_SESSION["error"] = $ex -> getMessage();
        }
    }
}


