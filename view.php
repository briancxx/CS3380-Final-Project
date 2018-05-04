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
          $body = "<h1>Gradebook</h1>";

          $body .= "<table>";

          foreach ($students as $student) {
              $id = $student['ID'];
              $username = $student['Username'];
              $firstName = $student['FirstName'];
              $lastName = $student['LastName'];

              $body .= "<tr>";
              $body .= "<td><form action='index.php' method='get'>
              <input type='hidden' name='action' value='add_grade' />
              <input type='submit' name='Add Student' value='Add Student' ='index.php?view=addStudentView'/>
              <a class='logoutButton' href='index.php?logout=1'>Logout</a>
              <input type='hidden' name='id' value='$id' /><input type='submit' value='Add Grade'></form></td>";
              $body .= "<td>$username</td><td>$firstName</td><td>$lastName</td>";
              $body .= "<tr>";
          }

          $body .= "</table>";

          // CREATE GRADES TABLE ---

          $body .= "<table>";

          foreach ($grades as $grade) {
              $id = $student['ID'];
              $firstName = $grade['FirstName'];
              $lastName = $grade['LastName'];
              $assignmentName = $grade['AssignmentName'];
              $earnedPoints = $grade['EarnedPoints'];
              $totalPoints = $grade['TotalPoints'];


              $body .= "<tr>";
              $body .= "<td><form action='index.php' method='post'><input type='hidden' name='action' value='delete_grade' /><input type='hidden' name='id' value='$id' /><input type='submit' value='Delete'></form></td>";
              $body .= "<td><form action='index.php' method='post'><input type='hidden' name='action' value='edit_grade' /><input type='hidden' name='id' value='$id' /><input type='submit' value='Edit'></form></td>";
              $body .= "<td>$firstName</td><td>$lastName</td><td>$assignmentName</td><td>$earnedPoints</td><td>$totalPoints</td>";
              $body .= "</tr>\n";
          }

          $body .= "</table>";

          return $this->page($body);
      }

      public function loginFormView($data = null, $message = '')
      {
          $loginID = '';
          if ($data) {
              $loginID = $data['login'];
          }

          $body = "<h1>Gradebook</h1>\n";

          if ($message) {
              $body .= "<p class='message'>$message</p>\n";
          }

          $body .= <<<EOT
  <form action='index.php' method='post'>
  <input type='hidden' name='action' value='login' />
  <p>User ID<br />
    <input type="text" name="login" value="$loginID" placeholder="login id" maxlength="50" size="50"></p>
  <p>Title<br />
    <input type="password" name="password" value="" placeholder="password" maxlength="255" size="80"></p>
    <input type="text" name="status" value="teacher"></p>
    <input type="submit" name='submit' value="Login">
  </form>
EOT;

          return $this->page($body);
      }

      public function addStudentView()
      {
          $body = "<h1>Add Student</h1>\n";

          $body .= "<tr>";
          $body .= "<td><form action='index.php' method='post'><input type='test' name='First Name'/>
          <input type='text' name='Last Name'/>
          <input type='text' name='username'/>
          <input type='text' name='password'>
          </form></td>";
          $body .= "</tr>\n";

          return $this->page($body);
      }

      public function gradeFormAddView($data, $message)
      {
          $body .= <<<EOT
      <form action='index.php' method='post'>
      <input type='hidden' name='action' value='add_grade' />
      <p>Assignment Name<br />
      <input type="text" name="assignmentName" value="" placeholder="assignment name" maxlength="50" size="50"></p>
      <p>Points Earned<br />
      <input type="number" name="pointsEarned" value="" placeholder="" maxlength="50" size="50"></p>
      <input type="submit" name='submit' value="Submit">
      </form>
EOT;

          return $this->page($body);
      }

      public function gradeFormEditView($data, $message)
      {
          $body .= <<<EOT
      <form action='index.php' method='post'>
      <input type='hidden' name='action' value='edit_grade' />
      <p>Assignment Name<br />
      <input type="text" name="assignmentName" value="" placeholder="assignment name" maxlength="50" size="50"></p>
      <p>Points Earned<br />
      <input type="number" name="pointsEarned" value="" placeholder="" maxlength="50" size="50"></p>
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
        <link rel="stylesheet" type="text/css" href="{$this->stylesheet}">
        <link rel="stylesheet" type="text/css" href="{$this->bootstrap}">
        <link rel="stylesheet" type="text/css" href="{$this->font}">
        </head>
        <body>
        <div class="container">
        $body
        </div>
        </body>
        </html>
EOT;
          return $html;
      }
  }
