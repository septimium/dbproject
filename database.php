<?php
$sqlQuery = $_GET['sql'];

$servername="localhost";
$username= "root";
$password= "";
$dbname= "database";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("". $conn->connect_error);
}
$result = $conn->query($sqlQuery);
if ($result) {
    // Display the results
    while ($row = $result->fetch_assoc()) {
        echo "<p>" . json_encode($row) . "</p>";
    }
} else {
    echo "Error: " . $sqlQuery . "<br>" . $conn->error;
}

$conn->close();
?>