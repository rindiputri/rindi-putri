<?php
include "src/Controller.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = $_POST;

    if (!isset($data["img"])) {
        $data["img"] = null;
    }

    echo $controller->addContact($data["name"], $data["email"], $data["phone"], $data["img"]);
}
?>