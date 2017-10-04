<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

// Create a function to be able to call on a page
function showSchool($conn)
{
  // Set a URL to be able to update the school details and send the GET values through this
  $update_school_script_URL = WEBURL.DOCROOT."scripts/parents-evening/admin/update-script.php?table_name=school_data&id={$_SESSION['school_id']}";

  // Select all the data from the school table where the id is equal to the school_id that the user account has
  $sql = "SELECT * FROM school_data WHERE id = {$_SESSION['school_id']}";

  // Store the result inside of a variable
  $result = mysqli_query($conn, $sql);

  // Store the values in an associative array from the result variable
  $row = mysqli_fetch_assoc($result);

  // Begin a form inside of a variable with the relevant details as the values of the row
  $record = "<form action='$update_school_script_URL' method='post'>";

      $record .= "<div class='form-group row'>";

          $record .= "<label for='school_name' class='col-2 col-form-label'>School Name</label>";

          $record .= "<div class='col-10'>";
              $record .= "<input type='text' class='form-control' name='school_name' value='{$row['school_name']}'>";
          $record .= "</div>";

      $record .= "</div>";

      $record .= "<div class='form-group row'>";

          $record .= "<label for='school_address' class='col-2 col-form-label'>School Address</label>";

          $record .= "<div class='col-10'>";
              $record .= "<input type='text' class='form-control' name='school_address' value='{$row['school_address']}'>";
          $record .= "</div>";

      $record .= "</div>";

      $record .= "<div class='form-group row'>";

          $record .= "<label for='school_email_address' class='col-2 col-form-label'>School Email Address</label>";

          $record .= "<div class='col-10'>";
              $record .= "<input type='text' class='form-control' name='school_email_address' value='{$row['school_email_address']}'>";
          $record .= "</div>";

      $record .= "</div>";

      $record .= "<div class='form-group row'>";

          $record .= "<label for='school_referral_code' class='col-2 col-form-label'>School Referral Code</label>";

          $record .= "<div class='col-10'>";
              $record .= "<input type='text' readonly class='form-control' name='school_referral_code' value='{$row['school_referral']}'>";
          $record .= "</div>";

      $record .= "</div>";

      $record .= "<div class='form-group row'>";

          $record .= "<label for='school_teacher_code' class='col-2 col-form-label'>Teacher Referral Code</label>";

          $record .= "<div class='col-10'>";
              $record .= "<input type='text' readonly class='form-control' name='school_teacher_code' value='{$row['school_teacher_code']}'>";
          $record .= "</div>";

      $record .= "</div>";

      $record .= "<button type='submit' class='btn btn-success btn-block'>Update School Details</button>";

  $record .= "</form>";

  // Output the variable record
  echo $record;
}
?>
