<?php

$servername = "localhost";
$username = "root";
$password = "root"; 
$dbname = "php2"; 

$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$xml = simplexml_load_file("students.xml") or die("Error: Cannot load students.xml");


foreach ($xml->student as $student) {
    $id = (int)$student->id;
    $name = $conn->real_escape_string((string)$student->name);
    $age = (int)$student->age;
    $email = $conn->real_escape_string((string)$student->email);

    $sql = "INSERT INTO students (id, name, age, email) VALUES ($id, '$name', $age, '$email')
            ON DUPLICATE KEY UPDATE name='$name', age=$age, email='$email'";

    if ($conn->query($sql) === TRUE) {
        echo "Inserted/Updated: $name<br>";
    } else {
        echo "Error inserting $name: " . $conn->error . "<br>";
    }
}

$conn->close();
?>
