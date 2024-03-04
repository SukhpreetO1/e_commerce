<?php
include dirname(__DIR__, 3) . "/common/config/config.php";

$edit_admin_first_name = $edit_admin_first_name_err = "";
$edit_admin_last_name = $edit_admin_last_name_err = "";
$edit_admin_email = $edit_admin_email_err = "";
$edit_admin_username = $edit_admin_username_err = "";
$edit_admin_mobile_number = $edit_admin_mobile_number_err = "";
$edit_admin_date_of_birth = $edit_admin_date_of_birth_err = "";
$edit_admin_password = $edit_admin_password_err = "";
$edit_admin_confirm_password = $edit_admin_confirm_password_err = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   $edit_admin_first_name = trim($_POST["edit_admin_first_name"]);
   $edit_admin_last_name = trim($_POST["edit_admin_last_name"]);
   $edit_admin_email = trim($_POST["edit_admin_email"]);
   $edit_admin_username = trim($_POST["edit_admin_username"]);
   $edit_admin_mobile_number = trim($_POST["edit_admin_mobile_number"]);
   $edit_admin_date_of_birth = trim($_POST["edit_admin_date_of_birth"]);
   $edit_admin_password = trim($_POST["edit_admin_password"]);
   $edit_admin_confirm_password = trim($_POST["edit_admin_confirm_password"]);
   $edit_admin_id = trim($_POST["edit_admin_id"]);


   $errors = array();

   function validate_input($inputValue, $requiredMessage, $formatMessage, $validationRegex)
   {
      $errorMessages = '';
      if (trim($inputValue) === '') {
         $errorMessages = $requiredMessage;
      } elseif ($validationRegex && !preg_match($validationRegex, $inputValue)) {
         $errorMessages = $formatMessage;
      }
      return $errorMessages;
   }

   $errors["edit_admin_first_name"] = validate_input($edit_admin_first_name, 'First name is required.', 'Only letters are allowed.', '/^[a-zA-Z]+$/');
   $errors["edit_admin_last_name"] = validate_input($edit_admin_last_name, 'Last name is required.', 'Only letters are allowed.', '/^[a-zA-Z]+$/');
   $errors["edit_admin_email"] = validate_input($edit_admin_email, 'Email is required.', 'Invalid email format. Format should be like abc@gmail.com.', '/^\w+([.-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/');
   $errors["edit_admin_username"] = validate_input($edit_admin_username, 'Username is required.', 'Only letters and numbers are allowed.', '/^[a-zA-Z0-9]+$/');
   $errors["edit_admin_mobile_number"] = validate_input($edit_admin_mobile_number, 'Mobile number is required.', 'Mobile number must be between 10 and 12 characters long.', '/^(?=.*\d)(?=.*[a-z]|[A-Z]).{6,20}$/');
   $errors["edit_admin_date_of_birth"] = validate_input(strval($edit_admin_date_of_birth), 'Date of birth is required.', null, null);
   $errors["edit_admin_password"] = validate_input($edit_admin_password, 'Password is required.', 'Password must contain at least 6 characters, 1 capital letter and 1 number.', '/^(?=.*\d)(?=.*[a-z]|[A-Z]).{6,20}$/');
   $errors["edit_admin_confirm_password"] = validate_input($edit_admin_confirm_password, 'Confirm password is required.', 'Confirm password must contain at least 6 characters, 1 capital letter and 1 number.', '/^[a-zA-Z]+$/');

   if (count($errors) > 0) {
      $check_sql = "SELECT * from users WHERE id = $edit_admin_id";
      $check_stmt = mysqli_prepare($database_connection, $check_sql);
      mysqli_stmt_bind_param($check_stmt, "i", $edit_admin_id);
      mysqli_stmt_execute($check_stmt);

      $check_result = mysqli_stmt_get_result($check_stmt);
      $user_data = mysqli_fetch_assoc($check_result);

      if ($user_data) {
         if ($user_data['active'] === 1) {
            $original_date = $edit_admin_date_of_birth;
            $new_date = DateTime::createFromFormat('m/d/Y', $original_date)->format('Y-m-d');

            $update_sql = "UPDATE users SET first_name=?, last_name=?, username=?, email=?, mobile_number=?, date_of_birth=?, password=?, updated_at = CURRENT_TIMESTAMP  WHERE id=?";
            $update_stmt = mysqli_prepare($database_connection, $update_sql);
            mysqli_stmt_bind_param($update_stmt, "ssssissi", $param_first_name, $param_last_name, $param_username, $param_email, $param_mobile_number, $param_date_of_birth, $param_password, $edit_admin_id);
            mysqli_stmt_execute($update_stmt);

            $param_first_name = $edit_admin_first_name;
            $param_last_name = $edit_admin_last_name;
            $param_username = $edit_admin_username;
            $param_email = $edit_admin_email;
            $param_mobile_number = $edit_admin_mobile_number;
            $param_date_of_birth = $new_date;
            $param_password = password_hash($edit_admin_password, PASSWORD_DEFAULT);
            if (mysqli_stmt_execute($update_stmt)) {
               $response['success'] = "Admin details updated successfully.";
            } else {
               $response['error'] = "Account not created. Please contact admin.";
            }
         } else {
            $response['error'] = "This admin is not active.";
         }
      } else {
         $response['error'] = "This admin does not exists.";
      }
   } else {
      echo json_encode($errors, JSON_UNESCAPED_SLASHES);
   }
   echo json_encode($response, JSON_UNESCAPED_SLASHES);
   mysqli_close($database_connection);
}
