<?php
require_once "php/dbcontroller.php";
$db_handle = new DBController();

$sql = "SELECT studentID, studentName, courseName, date, status FROM assignment;";
$productResult = $db_handle->readData($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/dashboard-menu.css" />
  <link rel="stylesheet" href="./css/assignments-dashboard.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Sharp" rel="stylesheet" />
  <title>Assignments</title>
  
</head>

<body>

<div class="menu">
        <ul>

            <li class="profile">
                <div class="img-box">
                    <img src="./images/logo.jpg" alt="logo image">
                </div>
                <h2>Ali Fakih</h2>
            </li>
            <li>
                <a class="active" href="./profile-dashboard.php">
                    <i class="fas fa-home"></i>
                    <p>Profile</p>
                </a>
            </li>

            <li>
                <a href="./course-dashboard.php">
                    <i class="fas fa-book"></i>
                    <p>Courses</p>
                </a>
            </li>

            <li>
                <a href="./student-dashboard.php">
                    <i class="fas fa-user-group"></i>
                    <p>Students</p>
                </a>
            </li>
            <li>
                <a href="./exam-dashboard.php">
                    <i class="fas fa-pencil-alt"></i>
                    <p>Exams</p>
                </a>
            </li>
            <li>
                <a href="./grades-dashboard.php">
                    <i class="fas fa-graduation-cap"></i>
                    <p>Grades</p>
                </a>
            </li>
            <li>
                <a href="./assignment-dashboard.php">
                    <i class="fas fa-tasks"></i>
                    <p>Assignemts</p>
                </a>
            </li>
            <li>
                <a href="./attendence-dashboard.php">
                    <i class="fas fa-user-check"></i>
                    <p>Attendance</p>
                </a>
            </li>
            <li class="log-out">
                <a href="#">
                    <i class="fas fa-sign-out"></i>
                    <p>Log Out</p>
                </a>
            </li>
        </ul>
    </div>
  
    <div class="container">



    <div class="cont-skill">
      <aside>
        <!-----------------------   Profle Section starts    -------------------------------------------------------------------------------->
        <div class="profilee">
          <div class="top">
            <div class="profilee-photo">
              <img src="./images/teacher.jpg" alt="" />
            </div>
            <div class="para-detials">
              <p>Hey, <b>Dr Ali</b></p>
              <small class="text-muted">20235061</small>
            </div>
          </div>
          <div class="about">
            <div class="doctor-leave-announcements">
              <h4>Doctor Leave Announcements</h4>
              <div class="announcements">
                <div class="message">
                  <div class="message-container">
                    <img src="./images/teacher3.jpg" alt="Dr. Smith's Photo" />
                    <p>
                      <b>Dr. Smith</b> will be on leave for a medical
                      conference.
                    </p>
                  </div>
                  <small class="text-muted">2 Minutes Ago</small>
                </div>

                <div class="message">
                  <div class="message-container">
                    <img src="./images/teacher1.jpg" alt="Dr. Smith's Photo" />
                    <p>
                      <b>Dr. Smith</b> will be on leave for a medical
                      conference.
                    </p>
                  </div>
                  <small class="text-muted">2 Minutes Ago</small>
                </div>

                <div class="message">
                  <div class="message-container">
                    <img src="./images/teacher2.jpg" alt="Dr. Smith's Photo" />
                    <p>
                      <b>Dr. Smith</b> will be on leave for a medical
                      conference.
                    </p>
                  </div>
                  <small class="text-muted">2 Minutes Ago</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </aside>
    </div>

    <section class="main">
        <div class="main-top">
            <h1><i class="fas fa-user-group"></i>Assignments</h1>
        </div>

        <section class="attendance">
            <div class="attendance-list">
                <div class="cont">
                    <h1>Assignments List</h1>
                    <a href="#" class="customButton" id="showForm">
                        <button>Add<i class="fas fa-plus"></i></button>
                    </a>
                </div>



                <div id="list-product">

                    <table id="table1" cellpadding="10" cellspacing="1" class="table-attend">

                        <thead>

                            <tr>
                                <th><strong>ID</strong></th>
                                <th><strong>Name</strong></th>
                                <th><strong>Course</strong></th>
                                <th><strong>Date</strong></th>
                                <th><strong>Status</strong></th>
                                <th><strong>Actions</strong></th>
                            </tr>
                        </thead>

                        <tbody id="ajax-response">
                            <!-- Display existing rows here -->
                            <?php
                            if (!empty($productResult)) {
                                foreach ($productResult as $v) {
                            ?>
                                    <tr>
                                        <td data-id="student_id"><?php echo $v['studentID']; ?></td>
                                        <td data-id="product_name"><?php echo $v['studentName']; ?></td>
                                        <td data-id="product_course"><?php echo $v['courseName']; ?></td>
                                        <td data-id="product_date"><?php echo $v['date']; ?></td>
                                        <td data-id="product_status"><?php echo $v['status']; ?></td>
                                        <td>
                                            <button class="edit"><i class="fas fa-pencil" aria-hidden="true"></i></button>
                                            <button class="save" style="display:none;" data-id="<?php echo $v['studentID']; ?>"><i class="fas fa-check" aria-hidden="true"></i></button>
                                            <button class="cancel" style="display:none;"><i class="fas fa-times" aria-hidden="true"></i></button>
                                            <button class="del" data-id="<?php echo $v['studentID']; ?>"><i class="fas fa-trash" aria-hidden="true"></i></button>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>


        <div id="addModal" class="modal">
            <h2>Add New Assignment</h2>
            <form id="addForm" method="post">

                <div>
                    <label for="newstudentID">ID:</label>
                    <input type="number" id="newstudentID" name="newstudentID" required />
                    <label for="newName">Name:</label>
                    <input type="text" id="newName" name="newName" required />
                    <label for="newCourse">Course:</label>
                    <input type="text" id="newCourse" name="newCourse" required />
                </div>
                <div>
                    <label for="newDate">Date:</label>
                    <input type="datetime" id="newDate" name="newDate" required />
                    <label for="newStatus">Status:</label>
                    <select id="newStatus" name="newStatus">
                        <option value="pending">Pending</option>
                        <option value="ongoing">Ongoing</option>
                        <option value="finished">Finished</option>
                        <option value="freezed">Freezed</option>
                    </select>
                </div>
                <div class="buttons">
                    <button type="button" id="adddata" name="adddata">Add</button>
                    <button type="button" id="closeForm" name="closeForm">Cancel</button>
                </div>
            </form>
        </div>
    </section>

    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="./js/assignment.js"></script>
    
</body>

</html>