<?php
require_once "../src/helpers/Accounts_data_helper.php";
require_once "../config/constants.php";
require_once "../config/database.php";
/*
	table accounts: staff_id, first_name, last_name, password, work_position, date_of_register,phone_num
*/
class Accounts extends AccountsDataHelper{
	private $conn;
	private $tbl_name = "staff_accounts";

	public function __construct(){
		$db = new Database();
		$this->conn = $db->get_connection();
		if($this->conn==null) die;
	}
	/*
		@param $user_data:- array containing user info submited from the form.
		keys:- field name of the table "staff_accounts".
		
		eg. $user['first_name']

	*/
	public function add_user($user){
		// mysql will throw error if $user[''] is used in the statment string.
		$res = extract($user); // extract the array
		$date_of_reg = "none"; // Todo:- set the current time
		$staff_id = $this->_get_new_id(); // get new unique id;
		$pass = md5($password); // encrypt the password

		$stmt = "INSERT INTO $this->tbl_name(staff_id, first_name, last_name, password, work_position, date_of_register, phone_num)";
		$stmt .= "VALUES ('$staff_id','$first_name', '$last_name', '$pass', '$work_position', '$date_of_reg', '$phone_num')";
		if(mysqli_query($this->conn, $stmt)){
			Constants::$SUCCESS;
		}else{
			Constants::$DATABASE_ERROR;
		}

	}

	public function delete_user($user_id){
		if($this->_account_exists($user_id)){
			if (mysqli_query($this->conn, "DELETE FROM $this->tbl_name WHERE staff_id='$user_id'")){
				Constants::$SUCCESS;
			}else{
				Constants::$DATABASE_ERROR;
			}
		}else{
			return Constants::$USER_DOESNT_EXIST;
		}
	}

	public function update_user($user_id, $new_data){
		extract($new_data)
		if($this->_account_exists($user_id)){
			$stmt = "UPDATE $this->tbl_name SET first_name='$first_name', last_name='$last_name', work_position='$work_position',phone_num='$phone_num' WHERE staff_id='$staff_id'";
			if(mysqli_query($this->conn, $stmt)){
				Constants::$SUCCESS;
			}else{
				Constants::$DATABASE_ERROR;
			}
		}else{
			return Constants::$USER_DOESNT_EXIST;
		}
	}
	
	public function auth($user_id, $pass){
		return $this->_check_password($user_id, $pass);
	}

	public function account_type($user_id){
		return $this->_account_type($user_id);
	}
}