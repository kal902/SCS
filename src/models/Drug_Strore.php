<?php
require_once "../config/constants.php";
require_once "../config/database.php";
/*
    table: drug_store:- drug_name(text), category(text), desc(text), company(text),
                        quantity(int), date_supplied(date), manu_date(date), exp_date(date)
*/
class DrugStore{
    private $conn;
    private $tbl_name = "drug_store";

    public function __construct(){
        $db = new Database();
        $this->conn = $db->get_connection();
    }

    /* when adding a drug, if the drug already exist,
       only the quantity field will be updated. */
    public function add_drug($drug_data){
        extract($drug_data);
        $date_supplied = 'date';// current date
        if($this->drug_exists($drug_name)==false){ // if drug doesnt exist, insert the new data.
            $stmt = "INSERT INTO $this->tbl_name(drug_name, category, desc, company, quantity, date_supplied, manu_date, exp_date)";
            $stmt .= "VALUES ('$drug_name', '$category', '$desc', '$company', '$quantity', '$date_supplied', '$manu_date', '$exp_date')";
            if(mysqli_query($this->conn, $stmt)){
                return true;
            }
        }else{ // if drug exist, update only the quantity field.
            $qun = $this->drug_quantity($drug_name);
            $quantity = $quantity + $qun;
            $stmt = "UPDATE $this->tbl_name SET quantity=$quantity WHERE drug_name='$drug_name'";
            if(mysqli_query($this->conn, $stmt)){
                return true;
            }
        }
        
        return false;
    }

    // substract x ammount of number from the quantity field of a drug.
    public function withdraw_drug($drug_name, $ammount){
        $ammount_of_drug_in_store = $this->drug_quantity($drug_name);
        if($ammount_of_drug_in_store != null){ // if null then the drug doesnt exist.
            if($ammount_of_drug_in_store > $ammount){ // the ammount of drug in store must be greater than the ammount to be substracted
                $quantity = $ammount_of_drug_in_store - $ammount;
                $stmt = "UPDATE $this->tbl_name SET quantity='$quantity' WHERE drug_name='$drug_name'";
                if(mysqli_query($this->conn, $stmt)){
                    return true;
                }
            }
        }
        return false;
    }

    // remove a drug entity.
    public function remove_drug($drug_name){
        if (mysqli_query($this->conn, "DELETE FROM $this->tbl_name WHERE drug_name='$drug_name'")){
            return true;
        }
        return false;
    }

    // update a drugs full information.
    public function update_drug($drug_name, $new_data){
        extract($new_data);
        $date_supplied = 'date'; // current date;
        $stmt = "UPDATE $this->tbl_name SET quantity=$quantity SET drug_name='$drug_name', category='$category', desc='$desc',";
        $stmt .= "company='$company', quantity='$quantity', date_supplied='$date_supplied', manu_date='$manu_date', exp_date='$exp_date' ";
        $STMT .= "WHERE drug_name=$drug_name";
        if(mysqli_query($this->conn, $stmt)){
            return true;
        }
        return false;
    }
    public function drug_exist($drug_name){
        $query = mysqli_query($this->tbl_name, "SELECT * FROM $this->tbl_name WHERE drug_name='$drug_name'");
        if(mysqli_num_rows($query)>0){
            return true;
        }
        return false;
    }

    // returns the quantity of a drug. (ammount of a drug in the store)
    public function drug_quantity($drug_name){
        $query = mysqli_query($this->tbl_name, "SELECT * FROM $this->tbl_name WHERE drug_name='$drug_name'");
        if(mysqli_num_rows($query)>0){
            $row = mysqli_fetch_array($query);
            return $row['quantity'];
        }
        return null; // if an error occured
    }

    public function get_drugs(){
        $query = mysqli_query($this->stmt, "SELECT * FROM $this->tbl_name");
        if(mysqli_num_rows($query)>0){
            $drugs = array();
            $i = 0;
            while($row=mysqli_fetch_array($query)){
                $drugs[$i]=$row;
                $i+=1;
            }
            return $drugs;
        }
        return null;
    }

    public function get_drug_info($drug_name){
        if($this->drug_exist($drug_name)){
            $query = mysqli_query($this->conn, "SELECT * FROM $this->tbl_name WHERE drug_name='$drug_name'");
            if($query){
                return mysqli_fetch_array($query);
            }
        }
        return null;
    }
}
?>