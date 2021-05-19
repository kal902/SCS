<?php
require_once "../config/constants.php";
require_once "../config/database.php";
/* table pending_patients:- pat_id(text), pat_name(text), reg_time(text) */
class PendingPatients{
    private $tbl_name = "pending_patients";
    private $current_date;
    private $conn;

    public function __construct(){
        $db = new Database();
        $this->conn = $db->get_connection();
        $this->current_date = 'none'; 
    }

    public function set_appointment($patient_id,$patient_name){
        $stmt = "INSERT INTO $this->tbl_name(pat_id, pat_name, date_time)";
        $stmt .= "VALUSE ('$patient_id', '$patient__name', '$this->current_date')";
        if(mysqli_query($this->conn, $stmt)){
            return true;
        }
        return false;
    }

    public function remove_appointment($patient_id){
        if(mysqli_query($this->conn, "DELETE FROM $this->tbl_name WHERE pat_id='$patient_id'")){
            return true;
        }
        return false;
    }

    public function get_appointments(){
        $stmt = "SELECT * FROM $this->tbl_name";
        $query = mysqli_query($this->conn, $stmt);
        if(mysqli_num_rows($query)>0){
            $appointments = array();
            $i = 0;
            while($row=mysqli_fetch_array($query)){
                $appointments[$i] = $row;
                $i+=1;
            }
            return $appointments;
        }
        return null;
    }
}

?>