<?php
include 'Database.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
class Controller
{
    private $db;

    function __construct($db)
    {
        $this->db = $db;
    }

    function addContact($name, $email, $phone, $img)
    {
        $conn = $this->db->connect();

        $sql = "INSERT INTO contact (
            name,
            email,
            phone,
            img
        ) VALUES (
            '$name',
            '$email',
            '$phone',
            '$img'
        );";

        if ($conn->query($sql) != TRUE) {
            return 0;
        }


        $this->db->close($conn);
        return $conn->insert_id;
    }

    function getAllContact()
    {
        $conn = $this->db->connect();
        $sql = "SELECT * FROM contact;";
        $result = $conn->query($sql);

        if ($result == false) {
            return false;
        }

        $contactList = [];
        while ($row = $result->fetch_assoc()) {
            $this->db->close($conn);


            array_push($contactList, [
                "id" => $row["id"],
                "name" => $row["name"],
                "email" => $row["email"],
                "phone" => $row["phone"],
                "img" => $row["img"]
            ]);
        }

        return json_encode($contactList);
    }


    function editContact($id, $name, $email, $phone, $img)
    {
        $conn = $this->db->connect();

        $sql = "UPDATE contact SET name='$name',email='$email',phone='$phone',img='$img' WHERE id=$id;";

        if ($conn->query($sql) != TRUE) {
            return 0;
        }

        $this->db->close($conn);
        return 1;
    }

    function deleteContact($id)
    {
        $conn = $this->db->connect();

        $sql = "DELETE FROM contact WHERE id=$id;";

        if ($conn->query($sql) != TRUE) {
            return 0;
        }

        $this->db->close($conn);
        return 1;
    }

    function raw($sql)
    {
        $conn = $this->db->connect();
        $result = $conn->query($sql);

        if ($result != TRUE) {
            return 0;
        }

        $this->db->close($conn);

        if (is_bool($result)) {
            return $result;
        } else {
            $data = [];
            while ($row = $result->fetch_assoc()) {
                array_push($data, $row);
            }
            return json_encode($data);
        }
    }
}

$controller = new Controller($db);