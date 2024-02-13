<?php 
$add_category_title_input_name = "";
$add_category_title_name_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $add_category_title_input_name = trim($_POST["add_category_title_input_name"]);
   $add_category_title_name_err = '';

   if (empty($add_category_title_input_name)) {
      $add_category_title_name_err = "Category name is required.";
   } else if (strlen($add_category_title_input_name) <= 3 || strlen($add_category_title_input_name) > 10) {
      $add_category_title_name_err = "Category name must be between 3 and 10 characters long.";
   } else if (!preg_match('/^[a-zA-Z]+$/', $add_category_title_input_name)) {
      $add_category_title_name_err = "Only alphabets are allowed.";
   }

   if (empty($add_category_title_name_err)) {
      $sql = "INSERT INTO clothes_categories (name) VALUES (?)";
      
      if ($stmt = mysqli_prepare($database_connection, $sql)) {
         mysqli_stmt_bind_param($stmt, "s", $param_name);
         $param_name = $add_category_title_input_name;
         if (mysqli_stmt_execute($stmt)) {
            $add_category_title_success = "Category created successfully.";
         } else {
            echo "Oops! Something went wrong. Please try again later.";
         }
         mysqli_stmt_close($stmt);
      }
   }
   mysqli_close($database_connection);
}
?>