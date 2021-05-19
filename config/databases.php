<?php
	class Database{
		private $host = "localhost";
		private $user = "root";
		private $pass = "";
		private $db_name = "SCS";
		private $conn;
		function get_connection(){
			$this->conn = mysqli_connect($this->host, $this->user, $this->pass,$this->db_name);
			if(mysqli_connect_errno()){
				return null;
			}else{
			 	return $this->conn;
			}
			
		}
		function end_connection(){
			mysqli_close($this->conn);
		}
	}
?>