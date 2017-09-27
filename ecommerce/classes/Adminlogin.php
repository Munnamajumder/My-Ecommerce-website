<?php 
$filepath = realpath(dirname(__FILE__));
include_ONCE ($filepath."/../lib/Session.php");
Session::checkLogin();

include_ONCE ($filepath."/../lib/Database.php");
include_ONCE ($filepath."/../helpers/Format.php");

?>

<?php

class Adminlogin{

	private $db;
	private $fm;
	
	function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
		
	}

public function adminLogin($adminUser,$adminPass){
	        $adminUser =$this->fm->validation($adminUser);
			$adminPass = $this->fm->validation($adminPass);
			$adminUser = mysqli_real_escape_string($this->db->link,$adminUser);
			$adminPass = mysqli_real_escape_string($this->db->link,$adminPass);
		if (empty($adminUser) || empty($adminPass)) {
				$loginmsg = "Username or Password Must Not be Empty";
				return $loginmsg;
			}else{
				$query = "select * from tbl_admin where adminUser = '$adminUser' AND adminPass = '$adminPass'";
				$result = $this->db->select($query);
					if($result != false){
						$value = $result->fetch_assoc();
						session::set('adminlogin',true);
						session::set('adminId',$value['adminId']);
						session::set('adminUser',$value['adminUser']);
						session::set('adminName',$value['adminName']);
						header("location:dashbord.php");

			}else{
				$loginmsg = "Username or Password Not Matched";
				return $loginmsg;
			}


			}

}
}

?>
