<?php 

$conn = new mysqli('localhost', 'root', '', 'venta_ci' );

$query = $conn->query("SELECT * FROM products");




