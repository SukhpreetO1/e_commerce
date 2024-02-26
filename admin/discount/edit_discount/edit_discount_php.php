<?php
include dirname(__DIR__, 3) . "/common/config/config.php";

$edit_discount_input_code_name = $edit_discount_code_name_err = "";
$edit_discount_input_discount_type = $edit_discount_discount_type_err = "";
$edit_discount_input_discount_active_inactive = $edit_discount_active_inactive_err = "";
$edit_discount_amount = $edit_discount_price_err = "";
$edit_discount_expire_date = $edit_discount_expire_date_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $edit_discount_input_code_name = trim($_POST["edit_discount_input_code_name"]);
   $edit_discount_input_discount_type = trim($_POST["edit_discount_input_discount_type"]);
   $edit_discount_input_discount_active_inactive = trim($_POST["edit_discount_input_discount_active_inactive"]);
   $edit_discount_amount = trim($_POST["edit_discount_amount"]);
   $edit_discount_expire_date = trim($_POST["edit_discount_expire_date"]);
   $discount_amount_type = trim($_POST["discount_amount_type"]);
   $edit_discount_id = trim($_POST["edit_discount_id"]);

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

   $edit_discount_code_name_err = validateInput($edit_discount_input_code_name, 'Discount name is required.', 'Discount name must be between 5 and 15 characters long.', 'Only alphabets and numbers are allowed.', '/^[a-zA-Z0-9]+$/');
   if ($edit_discount_code_name_err !== '') {
      $errors['edit_discount_input_code_name'] = $edit_discount_code_name_err;
   }

   $edit_discount_discount_type_err = validateInput($edit_discount_input_discount_type, 'Discount type is required.', 'Discount type must be between 5 and 15 characters long.', 'Only alphabets and numbers are allowed.', '/^[a-zA-Z0-9\s]+$/');
   if ($edit_discount_discount_type_err !== '') {
      $errors['edit_discount_input_discount_type'] = $edit_discount_discount_type_err;
   }

   $edit_discount_active_inactive_err = validateInput($edit_discount_input_discount_active_inactive, 'Please select an option', '', '', '');
   if ($edit_discount_active_inactive_err !== '') {
      $errors['edit_discount_input_discount_active_inactive'] = $edit_discount_active_inactive_err;
   }

   $edit_discount_price_err = validateInput($edit_discount_amount, 'Discount price is required.', '', 'Only numbers are allowed.', '/^(0+(\.\d+)?|[1-9]\d*(\.\d+)?)$/');
   if ($edit_discount_price_err !== '') {
      $errors['edit_discount_amount'] = $edit_discount_price_err;
   }

   $edit_discount_expire_date_err = validateInput($edit_discount_expire_date, 'Expire date is required.', '', 'Invalid date format.', '/^\d{2}\/\d{2}\/\d{4}$/');
   if ($edit_discount_expire_date_err !== '') {
      $errors['edit_discount_expire_date'] = $edit_discount_expire_date_err;
   }

   if (empty($errors)) {
      $check_sql = "SELECT discount WHERE id = $edit_discount_id AND code_name = ? AND discount_type = ?";
      $check_stmt = mysqli_prepare($database_connection, $check_sql);
      mysqli_stmt_bind_param($check_stmt, "iss",$edit_discount_id, $edit_discount_input_code_name, $edit_discount_input_discount_type);
      mysqli_stmt_execute($check_stmt);
      mysqli_stmt_store_result($check_stmt);

      $response = array();
      mysqli_stmt_bind_result($check_stmt, $result);
      mysqli_stmt_fetch($check_stmt);

      if (mysqli_stmt_num_rows($check_stmt) != 0) {
         $response['error'] = "This discount does not exists.";
      } else {
         $original_date = $edit_discount_expire_date;
         $new_date = DateTime::createFromFormat('m/d/Y', $original_date)->format('Y-m-d');

         if ($edit_discount_input_discount_active_inactive === 'active') {
            $edit_discount_input_discount_active_inactive = 1;
         } else if ($edit_discount_input_discount_active_inactive === 'inactive') {
            $edit_discount_input_discount_active_inactive = 0;
         }

         if ($discount_amount_type === '%') {
            $discount_amount_type = 1;
         } else if ($discount_amount_type === '₹') {
            $discount_amount_type = 0;
         }

         $update_sql = "UPDATE discount SET code_name=?, discount_type=?, activate=?, amount=?, rupees_or_percentage=?, expiration_date=?, updated_at = CURRENT_TIMESTAMP  WHERE id=?";
         $update_stmt = mysqli_prepare($database_connection, $update_sql);
         mysqli_stmt_bind_param($update_stmt, "ssiiisi", $edit_discount_input_code_name, $edit_discount_input_discount_type, $edit_discount_input_discount_active_inactive, $edit_discount_amount, $discount_amount_type, $new_date, $edit_discount_id);
         mysqli_stmt_execute($update_stmt);

         $response['success'] = "Discount updated successfully.";
         $response['url'] = '/admin/discount/discount.php';
      }

      echo json_encode($response, JSON_UNESCAPED_SLASHES);
      mysqli_stmt_close($update_stmt);
   } else {
      echo json_encode($errors, JSON_UNESCAPED_SLASHES);
   }
   mysqli_close($database_connection);
}
