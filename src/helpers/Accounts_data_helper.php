<?php
require_once "../config/constants.php";
class AccountDataHelper{
	public $conn; // super class must set this variable on initialization.
	private $tbl_name = "staff_accounts";

	protected function _account_exists($id){
		$query = mysqli_query($this->conn, "SELECT * FROM $this->tbl_name WHERE staff_id='$id'");
		if(mysqli_num_rows($query)>0){
			return true;
		}else{
			return false;
		}
	}
	// return work position
	protected function _account_type($id){
		$query = mysqli_query($this->conn, "SELECT * FROM $this->tbl_name WHERE staff_id='$id'");
		$row = mysqli_fetch_array($query);
		return $row['work_position'];
	}
	// id = first name + random number. i.e baya2222.
	protected function _get_new_id($staff_name){
		$new_id;
		while(true){
			$rand_int = rand(1000,6000);
			$new_id = "$staff_name".$rand_int;
			if($this->_account_exists($new_id)!=true){
				break;
			}
		}
		return $new_id;
	}

	protected function _check_password($id, $pass){
		$query = mysqli_query($this->conn, "SELECT * FROM $this->tbl_name WHERE staff_id='$id'");
		$row = mysqli_fetch_array($query);
		$password = $row['password']; // returns md5 hash
		return $password==md5($pass); // the string $pass should be encrypted for comparition, b/c decription of md5 hash is not possible;
	}

}