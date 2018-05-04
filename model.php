<?php

class Gradebook_model
{
    private $mysqli;
    private $status_for_view;

    public function __construct()
    {
        //don't know wha tthis does
        session_start();
        $this->initDatabaseConnection();
    }

    public function __destruct()
    {
        if ($this->mysqli) {
            $this->mysqli->close();
        }
    }

    public function getStatus()
    {
        return $_SESSION['status'];
    }

    public function logout()
    {
        $_SESSION['status']='';
    }

    private function initDatabaseConnection()
    {
        require('db_credentials.php');
        $this->mysqli = new mysqli($servername, $username, $password, $dbname);

        if ($mysqli->connect_error) {
            die("<p>Connection failed: " . $mysqli->connect_error . "</p>");
        } else {
            echo "<p>Connected successfully</p>";
            echo $_POST["login"] ;
        }
    }
    //handle for duplicates on add account

    public function check_login($login_data)
    {
        $login=$login_data["login"];
        $password=$login_data["password"];
        $status=$login_data["status"];

        $sql="SELECT * FROM " .$status . " WHERE ID='" . $login . "' AND Password='" . $password . "'";
        echo $sql;
        if ($result = $this->mysqli->query($sql)) {
            if ($result->num_rows == 1) {
                echo "<p>succesful login</p>";
                $row = mysqli_fetch_row($result);
                $ID=$row[0];
                echo $ID;
                $_SESSION['ID'] = $ID;
                $_SESSION['status']=$status;
                return array("successful","");
            }
            $result->close();
        } else {
            echo "<p>login failed</p>";
        }
    }

    public function getStudentID_old($firstname, $lastname)
    {
        $sql="SELECT StudentID FROM student WHERE FirstName=" . $firstname . " AND LastName=" . $lastname ;

        if ($result = $this->mysqli->query($sql)) {
            if ($result->num_rows == 1) {
                echo "<p>succesful login</p>";
                $row = mysqli_fetch_row($result);
                $ID=$row[0];
                $result->close();
                $_SESSION["studentid"]=$ID;
            }
        } else {
            echo "<p>could not find student</p>";
            $_SESSION["studentid"]='';
        }
    }
/*
    public function getStudentName($get_data)
    {
        $sql="SELECT FirstName LastName FROM student WHERE ID=" . $get_data['id'];
        
        $name=array();
        
        if ($result = $this->mysqli->query($sql)) {
            if ($result->num_rows == 1) {
                echo "<p>succesful login</p>";
                $row = mysqli_fetch_row($result);
                $ID=$row[0];
                $result->close();
                $_SESSION["studentid"]=$ID;
                
                $row = $result->fetch_assoc();
                $names=array_push($name,$row);
                
                return $names;
            }
        } else {
            echo "<p>could not find student</p>";
            $_SESSION["studentid"]='';
        }
    }*/
    
    public function addGrade($add_grade_data,$get_data)
    {
        echo $get_data["id"];
        //change to assoicate array, not indexed
        $points=$add_grade_data["EarnedPoints"];
        $possible_points=$add_grade_data["PossiblePoints"];
        $assignment_name=$add_grade_data["assignmentName"];
        $student_id=$add_grade_data["addGradeID"];

        $points = $this->mysqli->real_escape_string($points);
        $assignment_id = $this->mysqli->real_escape_string($assignment_id);
        $student_id = $this->mysqli->real_escape_string($student_id);

        $sql = "INSERT INTO grades (EarnedPoints, TotalPoints, AssignmentName, StudentID) VALUES ('$points', '$possible_points', '$assignment_name','$student_id')";
        echo $sql;

        if (! $result = $this->mysqli->query($sql)) {
            $this->error = $this->mysqli->error;
            echo $this->error;
            echo "<p>insert failed</p>";
        }
    }

    public function editGrade($edit_grade_data)
    {
        print_r($edit_grade_data);
        $id=$edit_grade_data["editGradeID"];
        $possible=$edit_grade_data["PossiblePoints"];
        $earned=$edit_grade_data["EarnedPoints"];
        $assignmentname=$edit_grade_data["assignmentName"];

        $id = $this->mysqli->real_escape_string($id);
        $possible = $this->mysqli->real_escape_string($possible);
        $earned = $this->mysqli->real_escape_string($earned);
        $assignmentname = $this->mysqli->real_escape_string($assignmentname);

        $sql="UPDATE grades SET EarnedPoints='" . $earned . "', TotalPoints= '" . $possible . "', AssignmentName='" . $assignmentname .  "' WHERE ID='" . $id . "'";
        echo $sql;

        if (! $result = $this->mysqli->query($sql)) {
            $this->error = $this->mysqli->error;
            echo $this->error;
            echo "<p>Update failed</p>";
        }
    }

    public function removeGrade($data)
    {
        $assignmentid= $this->mysqli->real_escape_string($data['deleteid']);
        
        $sql="DELETE FROM grades WHERE ID=" . $assignmentid;
        echo $sql;

        if (! $result = $this->mysqli->query($sql)) {
            $this->error = $this->mysqli->error;
            echo "<p>Update failed</p>";
        }
    }

    public function addStudent($add_student_data)
    {   
        $teacherid=$_SESSION["ID"];
        $firstname=$add_student_data["addStudentFirstName"];
        $lastname=$add_student_data["addStudentLastName"];
        $password=$add_student_data["addStudentPassword"];

        $teacherid = $this->mysqli->real_escape_string($teacherid);
        $firstname = $this->mysqli->real_escape_string($firstname);
        $lastname = $this->mysqli->real_escape_string($lastname);
        $password = $this->mysqli->real_escape_string($password);

        $sql = "INSERT INTO student (FirstName,LastName,Password,TeacherID) VALUES ('$firstname', '$lastname','$password','$teacherid')";
        echo $sql;

        if (! $result = $this->mysqli->query($sql)) {
            $this->error = $this->mysqli->error;
            echo $this->error;
            echo "<p>insert failed</p>";
        }
    }

    public function viewStudents()
    {
        echo $_SESSION['status'];
        echo $_SESSION['ID'];

        //handle status
        if ($_SESSION['status']=='teacher') {
            $sql="SELECT student.ID, FirstName, LastName
                FROM student
                WHERE TeacherID=" . $_SESSION['ID'];
        } elseif ($_SESSION['status']=='student') {
            $sql="SELECT ID,FirstName, LastName
                FROM student
                WHERE ID=" . $_SESSION['ID'];
        } else {
            echo "<p>something went wrong<p>";
        }

        echo $sql;

        if (! $result = $this->mysqli->query($sql)) {
            $this->error = $this->mysqli->error;
            echo "<p>Update failed</p>";
            echo $this->error;
        } else {
            $tasks=array();
        }
        while ($row = $result->fetch_assoc()) {
            array_push($tasks, $row);
        }
        return $tasks;
    }

    public function viewGrades()
    {
        echo $_SESSION['status'];
        echo $_SESSION['ID'];

        //handle status
        if ($_SESSION['status']=='teacher') {
            $sql="SELECT grades.ID, FirstName, LastName, AssignmentName, EarnedPoints, TotalPoints
                FROM grades
                INNER JOIN student ON grades.StudentID = student.ID WHERE TeacherID=" . $_SESSION['ID'];
        } elseif ($_SESSION['status']=='student') {
            $sql="SELECT grades.ID, AssignmentName, EarnedPoints, TotalPoints
                FROM grades
                INNER JOIN student ON grades.StudentID = student.ID WHERE StudentID=" . $_SESSION['ID'];
        } else {
            echo "<p>something went wrong<p>";
        }

        echo $sql;

        if (! $result = $this->mysqli->query($sql)) {
            $this->error = $this->mysqli->error;
            echo "<p>Update failed</p>";
            echo $this->error;
        } else {
            $tasks=array();
        }
        while ($row = $result->fetch_assoc()) {
            array_push($tasks, $row);
        }
        return $tasks;
    }
}

//$add_grade_data = array("96", "2", "1");
//$add_student_data=array("Steve","Smith","ss","password");
//$add_assignment_data=array("play in traffic","1000");
//$edit_grade_data=array(0,69);
//$login_data=array("login"=>"bbw2","password"=>"password","status"=>"teacher");
//$delete_grade_data=array('play in traffic');

//$gradebook_model=new Gradebook_model();
//$gradebook_model->check_login($login_data);
//$gradebook_model->add_grade($add_grade_data);
//$gradebook_model->add_student($add_student_data);
//$gradebook_model->add_assignment($add_assignment_data);
//$gradebook_model->edit_grade($edit_grade_data);
//$gradebook_model->remove_grade($delete_grade_data);
//$gradebook_model->remove_assignment($delete_grade_data);

//$gradebook_model->viewGrades();
