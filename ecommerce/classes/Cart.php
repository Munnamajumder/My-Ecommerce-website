<?php 
$filepath = realpath(dirname(__FILE__));

include_ONCE ($filepath."/../lib/Database.php");
include_ONCE ($filepath."/../helpers/Format.php");


?>

<?php

class Cart{
	
	private $db;
	private $fm;
	
	function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
		
	}

	public function addToCart($quantity, $id){
		$quantity =$this->fm->validation($quantity);
		$quantity = mysqli_real_escape_string($this->db->link,$quantity);
		$productId = mysqli_real_escape_string($this->db->link,$id);
		$sId = session_id();

		$squery = "SELECT * FROM tbl_product WHERE productId = '$productId'";
		$result = $this->db->select($squery)->fetch_assoc();

		$productName = $result['productName'];
		$price = $result['price'];
		$image = $result['image'];

		$cquery = "select * from tbl_cart where productId = '$productId' AND sId='$sId'";
		$getproduct = $this->db->select($cquery);
		if ($getproduct) {
			$msg = "Product already added !!!";
			return $msg;
		}else{

		$query = "INSERT INTO tbl_cart(sId, productId, productName, price, quantity, image) VALUES('$sId', '$productId', '$productName', '$price', '$quantity', '$image')";

	 $inserted_row = $this->db->insert($query);
				 if ($inserted_row) {
				 	header('location:cart.php');

				 }else{
				 	header('location:404.php');

				 }
				}



	}

	public function getCartProduct(){
		$sId = session_id();
		$query = "SELECT * FROM tbl_cart WHERE sId = '$sId'";
		$result = $this->db->select($query);
		return $result;

	}

	public function updateCartQuantity($cartId, $quantity){

		$cartId = mysqli_real_escape_string($this->db->link,$cartId);
	    $quantity = mysqli_real_escape_string($this->db->link,$quantity);

		$query = "UPDATE tbl_cart
		SET
		quantity='$quantity'
		where cartId='$cartId'";
		$updated_row = $this->db->update($query);
		
		if($updated_row){
			 header("location:cart.php");


			
		}else{
			$msg = "<span class='error'>quantity  updated</span>";
			return $msg;
		}
	}

	public function delProductBycart($delId){
		$delquery = "DELETE FROM tbl_cart WHERE cartId='$delId'";
		$delpro = $this->db->delete($delquery);
		if($delpro){
			 echo "<script>window.location = 'cart.php';</script>";

			
		}else{
			$msg = "<span class='error'>product not deleted</span>";
			return $msg;
		}
	}

	public function checkCartTable(){
		$sid = session_id();
       	$query = "select * from tbl_cart where sid = '$sid'";
       	$result = $this->db->select($query);
       	return $result;

	}

	public function orderProduct($cmrId){

		$sid = session_id();
    $query = "select * from tbl_cart where sid = '$sid'";
    $getproduct = $this->db->select($query);
    if($getproduct){
    while($result=$getproduct->fetch_assoc()){
        $productid = $result['productId'];
        $productname = $result['productName'];
        $quantity = $result['quantity'];
        $price = $result['price']*$quantity;
        $image = $result['image'];

       $query = "INSERT INTO tbl_order(cmrId, productId, productName, quantity, price, image) VALUES('$cmrId', '$productId', '$productname', '$quantity', '$price', '$image')";
        $inserted_rows = $this->db->insert($query);
        $query = "DELETE FROM tbl_cart WHERE sid = '$sid'";
            $this->db->delete($query);
            header("location:success.php");
           
                  }


            }
	}


	public function delCustomerCart(){
		$sid = Session_id();
		$query = "DELETE FROM tbl_cart WHERE sid = '$sid'";
		$result = $this->db->delete($query);
		return $result;
	}


	public function payableAmount($cmrId){

		$query = "SELECT price FROM tbl_order where cmrId = '$cmrId' AND date = now() ";
            $result = $this->db->select($query);
            return $result;

          
	}

	public function getOderedProduct($cmrId){

		$query = "select * from tbl_order where cmrId = '$cmrId' ORDER BY date ASC";

		$result = $this->db->select($query);
		return $result;
	}

	public function checkOrder($cmrId){
       	$query = "select * from tbl_order where cmrId = '$cmrId' ";
       	$result = $this->db->select($query);
       	return $result;

	}

	public function getAllOrderProduct(){
		$query = "select * from tbl_order ORDER BY date DESC";
       	$result = $this->db->select($query);
       	return $result;

	}

	public function productShifted($id, $date, $price){

		$id = mysqli_real_escape_string($this->db->link,$id);
		$date = mysqli_real_escape_string($this->db->link,$date);
		$price = mysqli_real_escape_string($this->db->link,$price);
		$query = "UPDATE tbl_order
					  SET
			          status='1'
					  where cmrId = '$id' AND date = '$date' AND price = '$price'";

			$updated_row = $this->db->update($query);
			if($updated_row){
						$msg = "<span class='success'> Updated successfully !</span>";
				        return $msg;
						
					}else{
						$msg = "<span class='error'>Not Updated !</span>";
				        return $msg;
					}

	}

	public function delproductShifted($id, $date, $price){
		$id = mysqli_real_escape_string($this->db->link,$id);
		$date = mysqli_real_escape_string($this->db->link,$date);
		$price = mysqli_real_escape_string($this->db->link,$price);

		$query = "DELETE FROM tbl_order where cmrId='$id' AND date='$date' AND price='$price'";
					$deldata = $this->db->delete($query);
					if($deldata){
						$msg = "<span class='success'>Data deleted successfully !</span>";
				        return $msg;
						
					}else{
						$msg = "<span class='success'>Data not deleted !</span>";
				        return $msg;
					}

	}

	public function productShiftConfirm($id, $date, $price){

		$id = mysqli_real_escape_string($this->db->link,$id);
		$date = mysqli_real_escape_string($this->db->link,$date);
		$price = mysqli_real_escape_string($this->db->link,$price);
		$query = "UPDATE tbl_order
					  SET
					  status='2'
					  where cmrId='$id' AND date='$date' AND price='$price'";

			$updated_row = $this->db->update($query);
			if($updated_row){
						$msg = "<span class='success'> Updated successfully !</span>";
				        return $msg;
						
					}else{
						$msg = "<span class='error'>Not Updated !</span>";
				        return $msg;
					}


	}


	}








?>