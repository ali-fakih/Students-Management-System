<?php
require_once "dbcontroller.php";
$db_handle = new DBController();

// Handle the form submission from the new form
if (isset($_POST["newstudentID"])) {
    // Extract and clean the form data
    $newstudentID = $db_handle->cleanData($_POST['newstudentID']);
    $newName = $db_handle->cleanData($_POST['newName']);
    $newGrade = $db_handle->cleanData($_POST['newGrade']);


    // Insert the new assignment into the database
    $sql = "INSERT INTO grades (studentID, fullName, grade)
    VALUES ('$newstudentID','$newName','$newGrade');";
    $insertedId = $db_handle->executeInsert($sql);

    // Output the newly inserted row
    echo '<tr>';
    echo '<td data-id="student_id">' . $newstudentID . '</td>';
    echo '<td data-id="student_name">' . $newName . '</td>';
    echo '<td data-id="student_grade">' . $newGrade . '</td>';
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
    $student_grade = $db_handle->cleanData($_POST['student_grade']);


    // Update or insert into the database
if (isset($_POST['student_id'])) {
    $sql = "UPDATE grades
            SET 
                `studentID` = '$student_id',
                `fullName` = '$student_name',
                `grade` = '$student_grade'
            WHERE
                `grades`.`studentID` = '$student_id'";

    $db_handle->executeInsert($sql);
} else {
    $sql = "INSERT INTO grades (studentID, fullName, grade)
    VALUES ('$newstudentID','$newName','$newGrade');";

    $db_handle->executeInsert($sql);
}


    // Fetch all rows to send them back to the client after update
    $sql = "SELECT
    G.studentID AS StudentID,
    G.fullName AS Name,
    G.grade AS Grade
    FROM
    grades G;";
    $allRows = $db_handle->readData($sql);
}

// Output all rows after update
if (!empty($allRows)) {
    $html = '';
    foreach ($allRows as $row) {
        $html .= '<tr>';
        $html .= '<td data-id="student_id">' . $row['StudentID'] . '</td>';
        $html .= '<td data-id="student_name">' . $row['Name'] . '</td>';
        $html .= '<td data-id="student_grade">' . $row['Grade'] . '</td>';
        $html .= '<td>';
        $html .= '<button class="edit btn btn-success"><i class="fas fa-pencil" aria-hidden="true"></i></button>';
        $html .= '<button class="save btn btn-success" style="display:none;" data-id="' . $row['StudentID'] . '"><i class="fas fa-check" aria-hidden="true"></i></button>';
        $html .= '<button class="cancel btn btn-danger" style="display:none;"><i class="fas fa-times" aria-hidden="true"></i></button>';
        $html .= '<button class="del btn btn-warning" data-id="' . $row['StudentID'] . '"><i class="fas fa-trash" aria-hidden="true"></i></button>';
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
        $sql = "DELETE FROM grades WHERE StudentID = '$id'";
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
