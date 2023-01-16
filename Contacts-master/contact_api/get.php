<?php
include "src/Controller.php";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $data = $_POST;

    echo $controller->getAllContact();
}
?>