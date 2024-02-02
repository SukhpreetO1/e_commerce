<?php
$database_connection = mysqli_connect('localhost', 'root', '', 'e-commerce');

if ($database_connection) {
    // echo "Connection successful!";
} else {
    echo "ERROR: Could not connect. " . mysqli_connect_error();
}
