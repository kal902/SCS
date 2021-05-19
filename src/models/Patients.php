<?php
require_once "../config/constants.php";
require_once "../config/database.php";
require_once "../src/helpers/patient_data_helper.php";

/*
	table patients: stu_id,pat_id,first_name, last_name, gender, age, phone_num, departement, date_of_reg
*/

/*
table patients_history: pat_id, staff_id, service, diagnosis, date
*/

class Patients extends PatientDataHelper{
	private $tbl_patients = "patients";
	private $tbl_pat_hist = "patient_history";
	private $current_date;

	function __construct(){
		$db = new Database();
		$this->conn = $b->get->connection();
		$this->current_date = 'none';
		if($this->conn==null) die;
		// todo init database
	}

	public function add_patient($patient_data){
		extract($patient_data);
		$pat_id = $this->_get_new_id($first_name);
		$date_of_reg = "none"; // todo get current date.

		$stmt = "INSERT INTO $this->tbl_name(stu_id,pat_id,first_name, last_name, gender, age, phone_num, departement, date_of_reg)";
		$stmt .= "VALUES ('$stu_id', '$pat_id', '$first_name', '$last_name', '$gender', '$age', '$phone_num','$departement', $date_of_reg')";
		if(mysqli_query($this->conn, $stmt)){
			Constants::$SUCCESS;
		}else{
			Constants::$DATABASE_ERROR;
		}
	}

	// data to update:- firstname, lastname, department, phonenum, age, gender
	public function update_patient($patient_id, $new_data){
		extract($new_data)
		if($this->_patient_exists($patient_id)){
			$stmt = "UPDATE $this->tbl_patients SET first_name='$first_name', last_name='$last_name', department='$department',phone_num='$phone_num', age='$age', gender='$gender' WHERE pat_id='$patient_id'";
			if(mysqli_query($this->conn, $stmt)){
				Constants::$SUCCESS;
			}else{
				Constants::$DATABASE_ERROR;
			}
		}else{
			return Constants::$USER_DOESNT_EXIST;
		}
	}

	public function delete_patient($patient_id){
		if(mysqli_query($this->conn, "DELETE FROM $this->tbl_patients WHERE pat_id='$pat_id'")){
			return Constants::$SUCCESS;
		}else{
			return Constants::$DATABASE_ERROR;
		}
	}

/***********************************************************************/
	// fetch a patients history from the "patients_history" table.
	public function get_patient_history($patient_id){
		$query = mysqli_query($this->conn, "SELECT * FROM $this->tbl_pat_hist WHERE pat_id='$patient_id'");
		if(mysqli_num_rows($query)>0){
			$patient_hist = array();
			$count = 0;
			while($row=mysqli_fetch_array($query)){
				$patient_hist[$count]=$row;
				$count = $count+1;
			}
			return $patient_hist;
		}
		return null; // no patient history
	}

	public function add_patient_history($patient_history){
		$stmt = "INSERT INTO $tbl_pat_hist(pat_id, staff_id, service, diagnosis, date)";
		$stmt .= " VALUES ('$pat_id','$staff_id', '$service', '$diagnosis', '$this->current_date')";
		if(mysqli_query($this->conn, $stmt)){
			return true;
		}
		return false;
	}

}

?>