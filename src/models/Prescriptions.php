<?php
require_once "../config/constants.php";
require_once "../config/database.php";
/* table prescriptions:-  pat_id(text), staff_id(text), medicine(text), strength(text) */

class Prescriptions{
    private $tbl_name = "prescriptions";
    private $conn;
    private $current_date;
    
    public function __construct(){
        $db = new Database();
        $this->conn = $db->get_connection();
        $this->current_date = "none";
    }

    public function prescribe($prescription_data){
        $extract($prescription_data)
        $stmt = "INSERT INTO $this->tbl_name(pat_id, staff_id, medicine, strength) ";
        $stmt .= "VALUES ('$pat_id', '$staff_id', '$medicine', '$strength')"
        if(mysqli_query($this->conn, $stmt)){
            return true;
        }
        return false;
    }

    public function remove_prescription($pat_id){
        if(mysqli_query($this->conn, "DELETE FROM $this->tbl_name WHERE pat_id='$pat_id'")){
            return true;
        }
        return false;
    }

    public function get_prescriptions(){
        $query = mysqli_query($this->stmt, "SELECT * FROM $this->tbl_name");
        if(mysqli_num_rows($query)>0){
            $prescriptions = array();
            $i = 0;
            while($row=mysqli_fetch_array($query)){
                $prerscriptions[$i] = $row;
                $i+=1;
            }
            return $prescriptions;
        }
        return null;
    }
}
?>