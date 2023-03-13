<?php
include_once("connectToDatabase.php");
$conn = connect();
if (isset($_GET['input'])) {
    $array = [];
    $town = $_GET['input'];
    $sql = "SELECT id from towns WHERE name LIKE '$town'";
    $result = $conn->query($sql);
    $fetch = $result->fetch_assoc();
    $town_id = $fetch['id'];
    $sql1 = "SELECT n.name FROM towns_neighborhoods t_n 
    JOIN neighborhoods n ON t_n.neighborhood_id = n.id WHERE t_n.town_id LIKE '$town_id' ";
    $result = $conn->query($sql1);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row["name"] . '">' . $row["name"] . '</option>';
        }
    }
}
$conn->close();
