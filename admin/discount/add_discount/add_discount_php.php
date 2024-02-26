<?php
include dirname(__DIR__, 3) . "/common/config/config.php";

$add_discount_input_code_name = $add_discount_code_name_err = "";
$add_discount_input_discount_type = $add_discount_discount_type_err = "";
$add_discount_input_discount_active_inactive = $add_discount_active_inactive_err = "";
$add_discount_amount = $add_discount_price_err = "";
$add_discount_expire_date = $add_discount_expire_date_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $add_discount_input_code_name = trim($_POST["add_discount_input_code_name"]);
   $add_discount_input_discount_type = trim($_POST["add_discount_input_discount_type"]);
   $add_discount_input_discount_active_inactive = trim($_POST["add_discount_input_discount_active_inactive"]);
   $add_discount_amount = trim($_POST["add_discount_amount"]);
   $add_discount_expire_date = trim($_POST["add_discount_expire_date"]);
   $discount_amount_type = trim($_POST["discount_amount_type"]);

   $errors = array();
   
   function validateInput($inputValue, $requiredMessage, $lengthMessage, $formatMessage, $validationRegex)
   {
      $errorMessages = '';
      if (trim($inputValue) === '') {
         $errorMessages = $requiredMessage;
      } else if (strlen($inputValue) < 5 || strlen($inputValue) > 15) {
         $errorMessages = $lengthMessage;
      } else if (!preg_match($validationRegex, $inputValue)) {
         $errorMessages = $formatMessage;
      }
      return $errorMessages;
   }

   $add_discount_code_name_err = validateInput($add_discount_input_code_name, 'Discount name is required.', 'Discount name must be between 5 and 15 characters long.', 'Only alphabets and numbers are allowed.', '/^[a-zA-Z0-9]+$/');
   if ($add_discount_code_name_err !== '') {
      $errors['add_discount_input_code_name'] = $add_discount_code_name_err;
   }

   $add_discount_discount_type_err = validateInput($add_discount_input_discount_type, 'Discount type is required.', 'Discount type must be between 5 and 15 characters long.', 'Only alphabets and numbers are allowed.', '/^[a-zA-Z0-9\s]+$/');
   if ($add_discount_discount_type_err !== '') {
      $errors['add_discount_input_discount_type'] = $add_discount_discount_type_err;
   }

   $add_discount_active_inactive_err = validateInput($add_discount_input_discount_active_inactive, 'Please select an option', '', '', '');
   if ($add_discount_active_inactive_err !== '') {
      $errors['add_discount_input_discount_active_inactive'] = $add_discount_active_inactive_err;
   }

   $add_discount_price_err = validateInput($add_discount_amount, 'Discount price is required.', '', 'Only numbers are allowed.', '/^(0+(\.\d+)?|[1-9]\d*(\.\d+)?)$/');
   if ($add_discount_price_err !== '') {
      $errors['add_discount_amount'] = $add_discount_price_err;
   }

   $add_discount_expire_date_err = validateInput($add_discount_expire_date, 'Expire date is required.', '', 'Invalid date format.', '/^\d{2}\/\d{2}\/\d{4}$/');
   if ($add_discount_expire_date_err !== '') {
      $errors['add_discount_expire_date'] = $add_discount_expire_date_err;
   }

   if (empty($errors)) {
      $check_sql = "SELECT * FROM discount WHERE code_name = ? AND discount_type = ?";
      $check_stmt = mysqli_prepare($database_connection, $check_sql);
      mysqli_stmt_bind_param($check_stmt, "ss", $add_discount_input_code_name, $add_discount_input_discount_type);
      mysqli_stmt_execute($check_stmt);
      mysqli_stmt_store_result($check_stmt);

      $response = array();
      mysqli_stmt_bind_result($check_stmt, $result);
      mysqli_stmt_fetch($check_stmt);

      if (mysqli_stmt_num_rows($check_stmt) > 0) {
         $response['error'] = "This discount already exists.";
      } else {
         $original_date = $add_discount_expire_date;
         $new_date = DateTime::createFromFormat('m/d/Y', $original_date)->format('Y-m-d');
 
         if($add_discount_input_discount_active_inactive === 'active'){
            $add_discount_input_discount_active_inactive = 1;
         } else {
            $add_discount_input_discount_active_inactive = 0;
         }

         if($discount_amount_type === '%'){
            $discount_amount_type = 1;
         } else {
            $discount_amount_type = 0;
         }

         $insert_sql = "INSERT INTO discount (code_name, discount_type, activate, amount, rupees_or_percentage, expiration_date) VALUES (?, ?, ?, ?, ?, ?)";
         $insert_stmt = mysqli_prepare($database_connection, $insert_sql);
         mysqli_stmt_bind_param($insert_stmt, "ssiiis", $add_discount_input_code_name, $add_discount_input_discount_type, $add_discount_input_discount_active_inactive, $add_discount_amount, $discount_amount_type, $new_date);
         mysqli_stmt_execute($insert_stmt);

         $response['success'] = "Discount created successfully.";
         $response['url'] = '/admin/discount/discount.php';
      }

      echo json_encode($response, JSON_UNESCAPED_SLASHES);

      mysqli_stmt_close($check_stmt);
      mysqli_stmt_close($insert_stmt);
   } else {
      echo json_encode($errors, JSON_UNESCAPED_SLASHES);
   }
}
