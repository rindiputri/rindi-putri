<?php
include "src/Controller.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $_POST;

    echo $controller->editContact($data["id"], $data["name"], $data["email"], $data["phone"], $data["img"]);
}
?>