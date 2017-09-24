<?php
// Allows session variables to be used.
session_start();
// Includes the database configuration file.
require($_SERVER['DOCUMENT_ROOT'].'/parents-evening/server/config.php'); //Change to where it is stored in your website.

function showSchool($conn)
{
    $update_school_script_URL = WEBURL.DOCROOT."scripts/parents-evening/admin/update-script.php?table_name=school_data&id={$_SESSION['school_id']}";

    $sql = "SELECT * FROM school_data WHERE id = {$_SESSION['school_id']}";

    $result = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($result);

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

        $record .= "<button type='submit' class='btn btn-success btn-block'>Update School Details</button>";

    $record .= "</form>";
    echo $record;
}
?>
