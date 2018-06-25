<?php


if (isset($_GET['id'])) {
	$id = ($_GET['id']);
}

$conn = new mysqli('localhost', 'root', '', 'venta_ci' );

$query = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($query);
$output = array();
$output = $result->fetch_all(MYSQLI_ASSOC);

header("Content-Type: application/json; charset=UTF-8");
echo json_encode($output);