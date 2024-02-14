<?php
$database_connection = mysqli_connect('localhost', 'root', 'root', 'e-commerce');

if (!$database_connection) {
    echo "ERROR: Could not connect. " . mysqli_connect_error();
}
