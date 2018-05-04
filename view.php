<?php
  class Gradebook_views
  {
      private $stylesheet = 'styles.css';
      private $pageTitle = 'Gradebook';
      private $bootstrap = 'https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css';
      private $font = 'https://fonts.googleapis.com/css?family=Lato';

      public function __construct()
      {
      }

      public function __destruct()
      {
      }

      public function gradesListView($students, $grades, $message)
      {
          $body = "<p class='actionlinks'>";
          $status = $_SESSION['status'];

          //echo $status;

          if ($status == 'teacher') {
              $body .= "<a href='index.php?view=addStudent'>Add Student</a> | ";
          }

          $body .= "<a class='logoutButton' href='index.php?logout=1'>Logout</a></p>";

          if ($status == 'teacher') {
              $body .= "<h2>Students</h2>";
          } else {
              $body .= "<h2>My Info</h2>";
          }

          $body .= "<table class='table table-bordered'><thead><tr>";
          if ($status == 'teacher') {
              $body .= "<th></th>";
          }
          $body .= "<th>User ID</th><th>First Name</th><th>Last Name</th></tr></thead><tbody>";

          foreach ($students as $student) {
              $id = $student['ID'];
              $firstName = $student['FirstName'];
              $lastName = $student['LastName'];

              $body .= "<tr>";
              //$body .= "<input type='hidden' name='id' value='$id' /><input type='submit' value='Add Grade'></form></td>";
              if ($status == 'teacher') {
                  $body .= "<td><a href='index.php?view=gradeFormAdd&id=$id'>Add Grade</a></td>";
              }
              $body .= "<td>$id</td><td>$firstName</td><td>$lastName</td>";
              $body .= "<tr>";
          }

          $body .= "</tbody></table>";

          // CREATE GRADES TABLE ---

          if ($status == 'teacher') {
              $body .= "<h2>Grades</h2>";
          } else {
              $body .= "<h2>My Grades</h2>";
          }
          $body .= "<table class='table table-bordered'><thead>";
          if ($status == 'teacher') {
              $body .= "<th></th><th></th>";
          }
          $body .= "<th>Assignment Name</th>";
          if ($status == 'teacher') {
              $body .= "<th>First Name</th><th>Last Name</th>";
          }
          $body .= "<th>Earned Points</th><th>Total Points</th></thead><tbody>";

          foreach ($grades as $grade) {
              $id = $grade['ID'];
              $firstName = $grade['FirstName'];
              $lastName = $grade['LastName'];
              $assignmentName = $grade['AssignmentName'];
              $earnedPoints = $grade['EarnedPoints'];
              $totalPoints = $grade['TotalPoints'];


              $body .= "<tr>";
              if ($status == 'teacher') {
                  $body .= "<td><form action='index.php' method='post'><input type='hidden' name='action' value='delete_grade' /><input type='hidden' name='deleteid' value='$id' /><input type='submit' value='Delete'></form></td>";
                  $body .= "<td><a href='index.php?view=gradeFormEdit&id=$id&assignmentName=$assignmentName&earnedPoints=$earnedPoints&totalPoints=$totalPoints' > Edit Grade</a></td>";
              }

              $body .= "<td>$assignmentName</td>";

              if ($status == 'teacher') {
                  $body .= "<td>$firstName</td><td>$lastName</td>";
              }

              $body .= "<td>$earnedPoints</td><td>$totalPoints</td>";
              $body .= "</tr>\n";
          }

          $body .= "</tbody></table>";

          return $this->page($body);
      }

      public function loginFormView($data = null, $message = '')
      {
          $loginID = '';
          if ($data) {
              $loginID = $data['login'];
          }

          $body = "";

          if ($message) {
              $body .= "<p class='message'>$message</p>\n";
          }

          $body .= <<<EOT
  <form action='index.php' method='post'>
  <input type='hidden' name='action' value='login' />
  <p>User ID<br />
    <input type="text" name="login" value="$loginID" placeholder="login id" maxlength="50" size="50"></p>
  <p>Password<br />
    <input type="password" name="password" value="" placeholder="password" maxlength="255" size="80"></p>
  <p>Login as<br />
    <input type="radio" name="status" value="student" checked> Student
    <input type="radio" name="status" value="teacher"> Teacher</p>
    <input type="submit" name='submit' value="Login">
  </form>
EOT;

          return $this->page($body);
      }

      public function addStudentView()
      {
          $body = "<h2>Add Student</h2>\n";

          $body .= "<form action='index.php' method='post'>
          <input type='hidden' name='action' value='add_student'>
          <p>First Name<br/>
            <input type='test' name='addStudentFirstName'/></p>
          <p>Last Name<br/>
            <input type='text' name='addStudentLastName'/></p>
          <p>Password<br/>
            <input type='text' name='addStudentPassword'></p>
          <input type='submit' name='submit' value='Submit' />
          </form>";



          return $this->page($body);
      }

      public function gradeFormAddView($data, $message)
      {
          $body .= <<<EOT
      <h2>Add Grade</h2>
      <form action='index.php' method='post'>
      <input type='hidden' name='action' value='add_grade' />
      <input type='hidden' name='addGradeID' value='{$_GET['id']}' />
      <p>Assignment Name<br />
      <input type="text" name="assignmentName" value="" placeholder="assignment name" maxlength="50" size="50"></p>
      <p>Points Earned<br />
      <input type="number" name="EarnedPoints" value="" placeholder="" maxlength="50" size="50"></p>
      <p>Points Possible<br />
      <input type="number" name="PossiblePoints" value="" placeholder="" maxlength="50" size="50"></p>
      <input type="submit" name='submit' value="Submit">
      </form>
EOT;

          return $this->page($body);
      }

      public function gradeFormEditView($data, $message)
      {
          $body .= <<<EOT
      <h2>Edit Grade</h2>
      <form action='index.php' method='post'>
      <input type='hidden' name='action' value='edit_grade' />
      <input type='hidden' name='editGradeID' value='{$_GET['id']}' />
      <p>Assignment Name<br />
      <input type="text" name="assignmentName" value="{$_GET["assignmentName"]}" placeholder="assignment name" maxlength="50" size="50"></p>
      <p>Points Earned<br />
      <input type="number" name="EarnedPoints" value="{$_GET["earnedPoints"]}" placeholder="" maxlength="50" size="50"></p>
      <p>Points Possible<br />
      <input type="number" name="PossiblePoints" value="{$_GET["totalPoints"]}" placeholder="" maxlength="50" size="50"></p>
      <input type="submit" name='submit' value="Submit">
      </form>
EOT;

          return $this->page($body);
      }

      public function studentFormView($data, $message)
      {
      }

      private function page($body)
      {
          $html = <<<EOT
        <!DOCTYPE html>
        <html>
        <head>
        <title>{$this->pageTitle}</title>
        <link rel="stylesheet" type="text/css" href="/{$this->stylesheet}">
        <link rel="stylesheet" type="text/css" href="{$this->bootstrap}">
        <link rel="stylesheet" type="text/css" href="{$this->font}">
        </head>
        <body>
        <div class="container">
        <h1>Gradebook</h1>
        $body
        </div>
        </body>
        </html>
EOT;
          return $html;
      }
  }
