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
        
        $sql="SELECT * FROM " .$status . " WHERE username='" . $login . "' AND password='" . $password . "'";
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
        
        $sql = "INSERT INTO grades (Points, assignmentID, StudentID) VALUES ('$points', '$assignment_id', '$student_id')";
        echo $sql;
        
        if (! $result = $this->mysqli->query($sql)) {
				$this->error = $this->mysqli->error;
                echo "<p>insert failed</p>";
			}
    }
}

//$add_grade_data = array("69", "69", "69");

$gradebook_model=new Gradebook_model();
$gradebook_model->check_login();
//$gradebook_model->add_grade($add_grade_data);

?>