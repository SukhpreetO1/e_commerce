<?php
$link = mysqli_connect('localhost', 'root', 'root', 'e-commerce'); 

if ($link) {
    // echo "Connection successful!";
} else {
    echo "ERROR: Could not connect. " . mysqli_connect_error();
}

?>