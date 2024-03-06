<?php
include dirname(__DIR__, 3) . "/common/config/config.php";

if (isset($_POST['category_id']) && !empty($_POST['category_id'])) {
   $category_id = mysqli_real_escape_string($database_connection, $_POST['category_id']);
   $sql = "SELECT * FROM categories_heading WHERE categories_id = $category_id";
   $result = $database_connection->query($sql);
   if ($result->num_rows > 0) {
      $categoryHeaders = array();
      while ($row = $result->fetch_assoc()) {
         $categoryHeaders[] = $row;
      }
      echo json_encode($categoryHeaders);
   } else {
      echo json_encode(array());
   }
} else {
   echo json_encode(array('error' => 'Category ID is missing.'));
}
?>
