<?php
$servername = "localhost";
$username = "root";
$password = "root";  
$dbname = "php2";  


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM students";
$result = $conn->query($sql);


if ($result->num_rows > 0) {

 
    $xml = new DOMDocument("1.0", "UTF-8");
    $xml->formatOutput = true;


    $students = $xml->createElement("students");
    $xml->appendChild($students);

    while ($row = $result->fetch_assoc()) {
        $student = $xml->createElement("student");

        $id = $xml->createElement("id", $row["id"]);
        $name = $xml->createElement("name", $row["name"]);
        $age = $xml->createElement("age", $row["age"]);
        $email = $xml->createElement("email", $row["email"]);


        $student->appendChild($id);
        $student->appendChild($name);
        $student->appendChild($age);
        $student->appendChild($email);

        $students->appendChild($student);
    }

    $xml->save("students.xml");

    echo "✅ Data exported successfully to students.xml";

} else {
    echo "No records found in students table.";
}

$conn->close();
?>
