<?php

$operation              = $_GET["operation"];
$cod                    = $_GET["cod"];

switch($operation) {
    case 0:
        include_once("list.php");
        exit();
        break;
    case 1:
        include_once("doDelete.php");
        exit();
        break;
    case 2:
    case 3:
    case 4:
        include_once("report.php");
        exit();
        break;
    case 5:
        include_once("doBlock.php");
        exit();
        break;
    default:
        include_once("list.php");
        exit();
        break;    
}

?>