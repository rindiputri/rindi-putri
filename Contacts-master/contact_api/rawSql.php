<?php
include "src/Controller.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $_POST;

    echo $controller->raw($data["sql"]);
}
?>