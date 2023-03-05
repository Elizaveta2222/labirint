<?php
session_start();
unset($_SESSION["error"]);
//$_SESSION["error"] = "";
if (isset($_POST["cells"]))
{
    $_SESSION["cells"] = $_POST["cells"];
}

$cells = $_SESSION["cells"];
$path = array();

if(isset($_POST["button"]))
{
    include "classes/Point.php";
    include "classes/PathSearch.php";

    if(isset($_POST["fromX"]) && isset($_POST["fromY"]) && isset($_POST["toX"]) && isset($_POST["toY"]))
    {
        try {
            $from = new Point($_POST["fromX"], $_POST["fromY"]);
            $to = new Point($_POST["toX"], $_POST["toY"]);
        }
        catch (TypeError $ex)
        {
            $_SESSION["error"] = "Точки входа не могут иметь пустые координаты";
        }
        try {
            $search = new PathSearch($cells, $from, $to);
            $path = $search->getShortestPath();
        }
        catch(Exception $ex)
        {
            $_SESSION["error"] = $ex -> getMessage();
        }
    }
}


