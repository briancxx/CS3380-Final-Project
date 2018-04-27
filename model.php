<?php

class Gradebook_model{
    
    private $mysqli;
    
    public function __construct() {
        //don't know wha tthis does
			session_start();
			$this->initDatabaseConnection();
		}
    
    public function __destruct() {
			if ($this->mysqli) {
				$this->mysqli->close();
			}
		}
    
    private function initDatabaseConnection() {
			require('db_credentials.php');
			$this->mysqli = new mysqli($servername, $username, $password, $dbname);
        
            if ($mysqli->connect_error) {
                die("<p>Connection failed: " . $mysqli->connect_error . "</p>");
            } 
            else{
                echo "<p>Connected successfully</p>";
                echo $_POST["login"] ;
            }
		}
    //handle for duplicates on add account
    
    public function check_login(){
        $login=$_POST["login"];
        $password=$_POST["password"];
        $status=$_POST["status"];
        
        $sql="SELECT * FROM " .$status . " WHERE Username='" . $login . "' AND Password='" . $password . "'";
        echo $sql;
        if ($result = $this->mysqli->query($sql)) {
				if ($result->num_rows == 1) {
                    echo "<p>succesful login</p>";
                    $row = mysqli_fetch_row($result);
                    $ID=$row[0];
                    echo $ID;
                    $_SESSION['ID'] = $ID;
				}
				$result->close();
			} 
        else {
                echo "<p>login failed</p>";
			}   
    }
    
    public function addGrade($add_grade_data){
        $points=$add_grade_data[0];
        $assignment_id=$add_grade_data[1];
        $student_id=$add_grade_data[2]; 
        
        $points = $this->mysqli->real_escape_string($points);
        $assignment_id = $this->mysqli->real_escape_string($assignment_id);
        $student_id = $this->mysqli->real_escape_string($student_id);
        
        $sql = "INSERT INTO grades (EarnedPoints, AssignmentID, StudentID) VALUES ('$points', '$assignment_id', '$student_id')";
        echo $sql;
        
        if (! $result = $this->mysqli->query($sql)) {
				$this->error = $this->mysqli->error;
                echo "<p>insert failed</p>";
			}
    }
    
    public function editGrade($edit_grade_data){
        
        //$change=$_POST["change"];
        //$studentid=$_POST["studentid"];
        
        $change=$edit_grade_data[0];
        $studentid=$edit_grade_data[1];
        
        $change = $this->mysqli->real_escape_string($change);
        $studentid = $this->mysqli->real_escape_string($studentid);
        
        $sql="UPDATE grades SET EarnedPoints=" . $change . " WHERE StudentID=" . $studentid;
        echo $sql;
        
        if (! $result = $this->mysqli->query($sql)) {
				$this->error = $this->mysqli->error;
                echo "<p>Update failed</p>";
			}   
    }
    
    public function removeGrade($remove_grade_data){
        
        //$studentid=$_POST["studentid"];
        
        $studentid=$remove_grade_data[0];
        
        $studentid = $this->mysqli->real_escape_string($studentid);
        
        $sql="DELETE FROM grades WHERE StudentID=" . $studentid;
        echo $sql;
        
        if (! $result = $this->mysqli->query($sql)) {
				$this->error = $this->mysqli->error;
                echo "<p>Update failed</p>";
			}  
    }   
    
    public function addStudent($add_student_data){
        //$firstname=$_POST["firstname"];
        //$lastname=$_POST["lastname"];
        //$login=$_POST["login"];
        //$password=$_POST["password"];
        
        $firstname=$add_student_data[0];
        $lastname=$add_student_data[1];
        $login=$add_student_data[2];
        $username=$add_student_data[3];
        
        $firstname = $this->mysqli->real_escape_string($firstname);
        $lastname = $this->mysqli->real_escape_string($lastname);
        $login = $this->mysqli->real_escape_string($login);
        $password = $this->mysqli->real_escape_string($password);
        
        $sql = "INSERT INTO students (FirstName,LastName,Username,Password) VALUES ('$firstname', '$lastname', '$login','$password')";
        echo $sql;
        
        if (! $result = $this->mysqli->query($sql)) {
				$this->error = $this->mysqli->error;
                echo "<p>insert failed</p>";
			}   
    }
    
    public function addAssignment($add_assignment_data){
        
        $name=$add_assignment_data[0];
        $points=$add_assignment_data[1];
        
        $name = $this->mysqli->real_escape_string($name);
        $points = $this->mysqli->real_escape_string($points);
        
        $sql = "INSERT INTO assignments (Name,TotalPoints) VALUES ('$name', '$points')";
        echo $sql;
        
        if (! $result = $this->mysqli->query($sql)) {
				$this->error = $this->mysqli->error;
                echo "<p>insert failed</p>";
			}     
    }
    
    public function removeAssignment($remove_assignment_data){
        
        $assignment_name=$remove_assignment_data[0];
        
        $assignment_name = $this->mysqli->real_escape_string($assignment_name);
        
        $sql="DELETE FROM assignments WHERE Name='" . $assignment_name . "'";
        echo $sql;
        
        if (! $result = $this->mysqli->query($sql)) {
				$this->error = $this->mysqli->error;
                echo "<p>Update failed</p>";
			}  
    }
    
    public function viewGrades(){
        
        echo $_SESSION['ID'];
        
        $id_from_cookie=1;
        
        $sql="SELECT * FROM grades WHERE StudentID=" . $id_from_cookie;
        
        if (! $result = $this->mysqli->query($sql)) {
				$this->error = $this->mysqli->error;
                echo "<p>Update failed</p>";
			}
        
        else
            $task = $result->fetch_assoc();
            return $task;
    }
}

//$add_grade_data = array("96", "2", "1");
//$add_student_data=array("Steve","Smith","ss","password");
//$add_assignment_data=array("play in traffic","1000");
//$edit_grade_data=array(0,69);

//$delete_grade_data=array('play in traffic');

$gradebook_model=new Gradebook_model();
$gradebook_model->check_login();
//$gradebook_model->add_grade($add_grade_data);
//$gradebook_model->add_student($add_student_data);
//$gradebook_model->add_assignment($add_assignment_data);
//$gradebook_model->edit_grade($edit_grade_data);
//$gradebook_model->remove_grade($delete_grade_data);
//$gradebook_model->remove_assignment($delete_grade_data);

$gradebook_model->viewGrades();
?>