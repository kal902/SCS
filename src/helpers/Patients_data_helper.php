<?php
require_once "../config/constants.php";
class PatientDataHelper{
	public $conn; // super class must set this variable on initialization.
	private $tbl_patients = "patients";
	private $tbl_pat_hist = "patient_history";

	protected function _patient_exists($id){
		$query = mysqli_query($this->conn, "SELECT * FROM $this->tbl_patients WHERE patient_id='$id'");
		if(mysqli_num_rows($query)>0){
			return true;
		}else{
			return false;
		}
	}
	
	protected function _get_new_id($patient_name){
		$new_id;
		while(true){
			$rand_int = rand(1000,6000);
			$new_id = "$patient_name".$rand_int;
			if($this->_patient_exists($new_id)!=true){
				break;
			}
		}
		return $new_id;
	}

}