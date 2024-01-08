<?php
require_once "dbcontroller.php";
$db_handle = new DBController();

// Handle the form submission from the new form
if (isset($_POST["newstudentID"])) {
    // Extract and clean the form data
    $newstudentID = $db_handle->cleanData($_POST['newstudentID']);
    $newName = $db_handle->cleanData($_POST['newName']);
    $newMajor = $db_handle->cleanData($_POST['newMajor']);
    $newDate = $db_handle->cleanData($_POST['newDate']);
    $newStatus = $db_handle->cleanData($_POST['newStatus']);
    $newNotes = $db_handle->cleanData($_POST['newNotes']);

    // Insert the new assignment into the database
    $sql = "INSERT INTO `attendance`(`studentName`, `studentID`, `major`, `date`, `status`, `notes`)
    VALUES ('$newName', '$newstudentID', '$newMajor', '$newDate', '$newStatus', '$newNotes');";
    $insertedId = $db_handle->executeInsert($sql);

    // Output the newly inserted row
    echo '<tr>';
    echo '<td data-id="student_id">' . $newstudentID . '</td>';
    echo '<td data-id="student_name">' . $newName . '</td>';
    echo '<td data-id="student_major">' . $newMajor . '</td>';
    echo '<td data-id="student_date">' . $newDate . '</td>';
    echo '<td data-id="student_status">' . $newStatus . '</td>';
    echo '<td data-id="student_notes">' . $newNotes . '</td>';
    echo '<td>';
    echo '<button class="edit btn btn-success"><i class="fas fa-pencil" aria-hidden="true"></i></button>';
    echo '<button class="save btn btn-success" style="display:none;" data-id="' . $newstudentID . '"><i class="fas fa-check" aria-hidden="true"></i></button>';
    echo '<button class="cancel btn btn-danger" style="display:none;"><i class="fas fa-times" aria-hidden="true"></i></button>';
    echo '<button class="del btn btn-warning" data-id="' . $newstudentID . '"><i class="fas fa-trash" aria-hidden="true"></i></button>';
    echo '</td>';
    echo '</tr>';
    exit; // Exit to prevent further processing
}

// Handle the form submission for update
elseif (isset($_POST["student_id"])) {
    // Extract and clean the form data
    $student_id = $db_handle->cleanData($_POST['student_id']);
    $student_name = $db_handle->cleanData($_POST['student_name']);
    $student_major = $db_handle->cleanData($_POST['student_major']);
    $student_date = $db_handle->cleanData($_POST['student_date']);
    $student_status = $db_handle->cleanData($_POST['student_status']);
    $student_notes = $db_handle->cleanData($_POST['student_notes']);

    // Update or insert into the database
    if (isset($_POST['id'])) {
        $sql = "UPDATE `attendance`
        SET
            `studentID` = '$student_id', 
            `studentName` = '$student_name',
            `major` = '$student_major',
            `date` = '$student_date',
            `status` = '$student_status',
            `notes` = '$student_notes'
        WHERE
            `attendance`.`studentID` = '$student_id'";

        
        $db_handle->executeInsert($sql);
    } else {
        $sql = "INSERT INTO `attendance`(`studentName`, `studentID`, `major`, `date`, `status`, `notes`)
        VALUES ('$newName', '$newstudentID', '$newMajor', '$newDate', '$newStatus', '$newNotes');";

        $db_handle->executeInsert($sql);
    }

    // Fetch all rows to send them back to the client after update
    $sql = "SELECT `studentID` AS ID , `studentName` AS Name, `major` AS Major , `date` AS Date, `status` AS Status, `notes` AS Notes FROM `attendance`;";
    $allRows = $db_handle->readData($sql);
}

// Output all rows after update
if (!empty($allRows)) {
    $html = '';
    foreach ($allRows as $row) {
        $html .= '<tr>';
        $html .= '<td data-id="student_id">' . $row['ID'] . '</td>';
        $html .= '<td data-id="student_name">' . $row['Name'] . '</td>';
        $html .= '<td data-id="student_major">' . $row['Major'] . '</td>';
        $html .= '<td data-id="student_date">' . $row['Date'] . '</td>';
        $html .= '<td data-id="student_status">' . $row['Status'] . '</td>';
        $html .= '<td data-id="student_notes">' . $row['Notes'] . '</td>';
        $html .= '<td>';
        $html .= '<button class="edit btn btn-success"><i class="fas fa-pencil" aria-hidden="true"></i></button>';
        $html .= '<button class="save btn btn-success" style="display:none;" data-id="' . $row['ID'] . '"><i class="fas fa-check" aria-hidden="true"></i></button>';
        $html .= '<button class="cancel btn btn-danger" style="display:none;"><i class="fas fa-times" aria-hidden="true"></i></button>';
        $html .= '<button class="del btn btn-warning" data-id="' . $row['ID'] . '"><i class="fas fa-trash" aria-hidden="true"></i></button>';
        $html .= '</td>';
        $html .= '</tr>';
    }
    echo $html;
    exit; // Exit to prevent further processing
}

// Handle delete action
if (isset($_POST['action']) && $_POST['action'] == 'del') {
    $id = $db_handle->cleanData($_POST['id']);
    if ($id > 0) {
        $sql = "DELETE FROM attendance WHERE studentID = '$id'";
        $result = mysqli_query($db_handle->connectDB(), $sql); // Use mysqli_query for delete operation
        if ($result) {
            echo 1;
            exit;
        } else {
            echo 0;
            exit;
        }
    }
}
?>
