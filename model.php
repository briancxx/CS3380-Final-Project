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

				}
				$result->close();
			} 
        else {
                echo "<p>login failed</p>";
			}   
    }
    
    public function add_grade($add_grade_data){
        $points=$add_grade_data[0];
        $assignment_id=$add_grade_data[1];
        $student_id=$add_grade_data[2]; 
        
        $points = $this->mysqli->real_escape_string($points);
        $assignment_id = $this->mysqli->real_escape_string($assignment_id);
        $student_id = $this->mysqli->real_escape_string($student_id);
        
        $sql = "INSERT INTO grades (Points, AssignmentID, StudentID) VALUES ('$points', '$assignment_id', '$student_id')";
        echo $sql;
        
        if (! $result = $this->mysqli->query($sql)) {
				$this->error = $this->mysqli->error;
                echo "<p>insert failed</p>";
			}
    }
    
    public function add_student($add_student_data){
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
    
    public function add_assignment($add_assignment_data){
        
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
}

//$add_grade_data = array("69", "69", "69");
//$add_student_data=array("Steve","Smith","ss","password");
$add_assignment_data=array("play in traffic","1000");
    
$gradebook_model=new Gradebook_model();
$gradebook_model->check_login();
//$gradebook_model->add_grade($add_grade_data);
//$gradebook_model->add_student($add_student_data);
$gradebook_model->add_assignment($add_assignment_data);

?>