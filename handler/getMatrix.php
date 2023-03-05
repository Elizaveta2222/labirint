<?php
session_start();
$_SESSION["error"] = "";
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

    if(isset($_POST["fromX"]) && isset($_POST["fromY"]))
        $from = new Point($_POST["fromX"], $_POST["fromY"]);
    else
        $from = new Point(0, 0);
    if(isset($_POST["toX"]) && isset($_POST["toY"]))
        $to = new Point($_POST["toX"], $_POST["toY"]);
    else
        $to = new Point(count($cells)-1, count($cells[0])-1);

    $error = "";
    try
    {
        $search = new PathSearch($cells, $from, $to);
        $path = $search->getShortestPath();
    }
    catch(Exception $ex)
    {
        $_SESSION["error"] = $ex -> getMessage();
    }
}


