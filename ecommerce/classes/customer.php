<?php 
$filepath = realpath(dirname(__FILE__));

include_ONCE ($filepath."/../lib/Database.php");
include_ONCE ($filepath."/../helpers/Format.php");


?>


<?php

class Customer{
	
	private $db;
	private $fm;
	
	function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
		
	}

	public function customerRegistration($data){
                   $name = $data['name'];
                   $address = $data['address'];
                   $city = $data['city'];
                   $country = $data['country'];
                   $zip = $data['zip'];
                   $phone = $data['phone'];
                   $email = $data['email'];
                   $pass = $data['pass'];

                   $name = $this->fm->validation($name);
                   $address = $this->fm->validation($address);
                   $city = $this->fm->validation($city);
                   $country = $this->fm->validation($country);
                   $zip = $this->fm->validation($zip);
                   $phone = $this->fm->validation($phone);
                   $email = $this->fm->validation($email);
                   $pass = $this->fm->validation($pass);

                    $name = mysqli_real_escape_string($this->db->link,$name);
                     $address = mysqli_real_escape_string($this->db->link,$address);
                    $city = mysqli_real_escape_string($this->db->link,$city);
                    $country = mysqli_real_escape_string($this->db->link,$country);
                    $zip = mysqli_real_escape_string($this->db->link,$zip);
                    $phone = mysqli_real_escape_string($this->db->link,$phone);
                    $email = mysqli_real_escape_string($this->db->link,$email);
                    $pass = mysqli_real_escape_string($this->db->link,$pass);

                      if(empty($name) || empty($address) || empty($city) || empty($country) || empty($zip) || empty($phone) || empty($email) || empty($pass) ){
                        $msg = "<span class='error'>Field must not be empty !!</span>";
				return $msg;
                        
                    }
                    $mailquery = "SELECT * FROM tbl_customer WHERE email = '$email' LIMIT 1 ";
                    $mailChk = $this->db->select($mailquery);

                    if ( $mailChk !=false) {
                    	$msg = "<span class='error'>Email already exist!!</span>";
				    return $msg;
                    }else{

                    		$query = "INSERT INTO tbl_customer(name, address, city, country, zip, phone, email, pass ) VALUES('$name', '$address', '$city', '$country', '$zip', '$phone', '$email', '$pass')";

	 $inserted_row = $this->db->insert($query);
				 if ($inserted_row) {
				 	$msg = "<span class='success'>Login successfully !!!</span>";
				    return $msg;

				 }else{
				 	$msg = "<span class='error'>Login Failed !!</span>";
				    return $msg;
				 }




                    }


	}

	public function customerLogin($data){
		 $email = $data['email'];
        $pass = $data['pass'];

        $email = $this->fm->validation($email);
        $pass = $this->fm->validation($pass);

        $email = mysqli_real_escape_string($this->db->link,$email);
        $pass = mysqli_real_escape_string($this->db->link,$pass);

        if (empty($email) || empty($pass)) {
			$msg = "<span class='success'>email and password must not be empty !!!</span>";
			return $msg;
		}else{
			$query = "SELECT * FROM tbl_customer WHERE email= '$email' AND pass = '$pass' ";
			$result = $this->db->select($query);
			if ($result != false) {
			$value = $result->fetch_assoc();
			Session:: set("cuslogin", true);
			Session:: set("cmrid",$value['id']);
			Session:: set("cmremail",$value['email']);
			Session:: set("cmrpass",$value['pass']);
			header("location:cart.php");
			}else{
			$msg = "<span class='success'>Username and password not match !!!</span>";
			return $msg;
		}


}

	}

	public function getCustomerData($id){

		$query = "select * from tbl_customer where id = '$id'";
		$result = $this->db->select($query);
		return $result;


	}

	public function customerUpdate($data, $cmrId){
		 $name = $data['name'];
        $phone = $data['phone'];
        $email = $data['email'];
        $address = $data['address'];
        $city = $data['city'];
        $zip = $data['zip'];
        $country = $data['country'];

        $name = $this->fm->validation($name);
        $phone = $this->fm->validation($phone);
        $email = $this->fm->validation($email);
        $address = $this->fm->validation($address);
        $city = $this->fm->validation($city);
        $zip = $this->fm->validation($zip);
        $country = $this->fm->validation($country);

        $name = mysqli_real_escape_string($this->db->link,$name);
        $phone = mysqli_real_escape_string($this->db->link,$phone);
        $email = mysqli_real_escape_string($this->db->link,$email);
        $address = mysqli_real_escape_string($this->db->link,$address);
        $city = mysqli_real_escape_string($this->db->link,$city);
        $zip = mysqli_real_escape_string($this->db->link,$zip);
        $country = mysqli_real_escape_string($this->db->link,$country);

        if (empty($name) || empty($phone) || empty($email) || empty($address) || empty($city) || empty($zip) || empty($country)) {

			$dataupdate="Firld must not be empty !!!";
			echo $dataupdate;}else{
			 $query = "UPDATE tbl_customer
                        SET
                        name='$name',
                        phone='$phone',
                        email='$email',
                        address='$address',
                        city='$city',
                        zip = '$zip',
                        country ='$country'

                        where id='$cmrId'";
                        $updated_row = $this->db->update($query);
                    
                    if($updated_row){
                    	$msg = "<span class='success'>Profile updated Successfully.</span>";
				    return $msg;
                      
                    }else {
                        
                    $msg = "<span class='error'>Profile not updated.</span>";
                    return $msg;
                    }
                    }







	}
}




?>