<?php
if (!empty($_FILES)) {
   var_dump($_FILES);
   die();
   $uploadDir = "uploads/";
   $fileName = basename($_FILES['file']['name']);
   $uploadFilePath = $uploadDir . $fileName;

   if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath)) {
      $insert = $db->query("INSERT INTO files (file_name, uploaded_on) VALUES ('" . $fileName . "', NOW())");
   }
}
