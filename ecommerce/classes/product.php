<?php 
$filepath = realpath(dirname(__FILE__));

include_ONCE ($filepath."/../lib/Database.php");
include_ONCE ($filepath."/../helpers/Format.php");


?>

<?php
class Product{
	
	private $db;
	private $fm;
	
	function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
		
	}

	public function productInsert($data, $file){
	$productName =$this->fm->validation($data['productName']);
	$catId    =$this->fm->validation($data['catId']);
	$brandId  =$this->fm->validation($data['brandId']);
	
	$price    =$this->fm->validation($data['price']);
	$type     =$this->fm->validation($data['type']);



    $productName = mysqli_real_escape_string($this->db->link, $productName);
    $catId   = mysqli_real_escape_string($this->db->link, $catId);
    $brandId = mysqli_real_escape_string($this->db->link, $brandId);
    $body    = mysqli_real_escape_string($this->db->link, $data['body']);
    $price   = mysqli_real_escape_string($this->db->link, $price);
    $type    = mysqli_real_escape_string($this->db->link, $type);

    $permited  = array('jpg', 'jpeg', 'png', 'gif');
    $file_name = $file['image']['name'];
    $file_size = $file['image']['size'];
    $file_temp = $file['image']['tmp_name'];

    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
    $uploaded_image = "uploads/".$unique_image;

    if ($productName == "" || $catId == "" || $brandId == "" || $body == "" || $price == "" || $file_name == "" || $type == "") {

    	$msg = "<span class='error'>Product Fields Must Not be Empty</span>";
		return $msg;
}elseif ($file_size >1048567) {
     echo "<span class='error'>Image Size should be less then 1MB!
     </span>";
    } elseif (in_array($file_ext, $permited) === false) {
     echo "<span class='error'>You can upload only:-"
     .implode(', ', $permited)."</span>";
    }else{
	move_uploaded_file($file_temp, $uploaded_image);

	$query = "INSERT INTO tbl_product(productName, catId, brandId, body, price, image, type) VALUES('$productName', '$catId', '$brandId', '$body', '$price', '$uploaded_image', '$type')";

	 $inserted_row = $this->db->insert($query);
				 if ($inserted_row) {
				 	$msg = "<span class='success'>Product Inserted successfully</span>";
				    return $msg;

				 }else{
				 	$msg = "<span class='error'>Product Not Inserted !</span>";
				    return $msg;
				 }
}


}

public function getAllProduct(){
	$query = "SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName 
	FROM tbl_product
	INNER JOIN tbl_category
	ON tbl_product.catId = tbl_category.catId
		INNER JOIN tbl_brand
	ON tbl_product.brandId = tbl_brand.brandId
	ORDER BY tbl_product.productId DESC";
	$result = $this->db->select($query);
	return $result;
}

public function getProById($id){
 		$query = "SELECT * FROM tbl_product WHERE productId = '$id'";
		$result = $this->db->select($query);
		return $result;

}

public function productUpdate($data, $file, $id){

		$productName =$this->fm->validation($data['productName']);
	$catId    =$this->fm->validation($data['catId']);
	$brandId  =$this->fm->validation($data['brandId']);
	$body     =$this->fm->validation($data['body']);
	$price    =$this->fm->validation($data['price']);
	$type     =$this->fm->validation($data['type']);



    $productName = mysqli_real_escape_string($this->db->link, $productName);
    $catId   = mysqli_real_escape_string($this->db->link, $catId);
    $brandId = mysqli_real_escape_string($this->db->link, $brandId);
    $body    = mysqli_real_escape_string($this->db->link, $body);
    $price   = mysqli_real_escape_string($this->db->link, $price);
    $type    = mysqli_real_escape_string($this->db->link, $type);

    $permited  = array('jpg', 'jpeg', 'png', 'gif');
    $file_name = $file['image']['name'];
    $file_size = $file['image']['size'];
    $file_temp = $file['image']['tmp_name'];

    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
    $uploaded_image = "uploads/".$unique_image;

    if ($productName == "" || $catId == "" || $brandId == "" || $body == "" || $price == ""  || $type == "") {

    	$msg = "<span class='error'>Product Fields Must Not be Empty</span>";
		return $msg;
}else{
if (!empty($file_name)) {



		if ($file_size >1048567) {
		     echo "<span class='error'>Image Size should be less then 1MB!
		     </span>";
		    } elseif (in_array($file_ext, $permited) === false) {
		     echo "<span class='error'>You can upload only:-"
		     .implode(', ', $permited)."</span>";
		    }else{
			move_uploaded_file($file_temp, $uploaded_image);

			$query ="UPDATE tbl_product
			SET
			productName = '$productName',
			catId = '$catId',
			brandId = '$brandId',
			body = '$body',
			price = '$price',
			image = '$uploaded_image',
			type = '$type'
			WHERE productId = '$id'";

			 $updated_row = $this->db->update($query);
						 if ($updated_row) {
						 	$msg = "<span class='success'>Product updated successfully</span>";
						    return $msg;

						 }else{
						 	$msg = "<span class='error'>Product Not updated !</span>";
						    return $msg;
						 }
			}
		}else{
			$query ="UPDATE tbl_product
			SET
			productName = '$productName',
			catId = '$catId',
			brandId = '$brandId',
			body = '$body',
			price = '$price',
			
			type = '$type'
			WHERE productId = '$id'";

			 $updated_row = $this->db->update($query);
						 if ($updated_row) {
						 	$msg = "<span class='success'>Product updated successfully</span>";
						    return $msg;

						 }else{
						 	$msg = "<span class='error'>Product Not updated !</span>";
						    return $msg;
						 }

		   }
		}
}

public function delProById($id){

	$query = "SELECT * FROM tbl_product WHERE productID = '$id'";
	$getData = $this->db->select($query);
	if ($getData) {
		while ($delImg = $getData->fetch_assoc()) {
			$dellink = $delImg['image'];
			unlink($dellink);
		}
	}

    $delquery = "DELETE FROM tbl_product WHERE productId='$id'";
				$deldata = $this->db->delete($delquery);
				if($deldata){
					$msg = "<span class='success'>Product deleted successfully !</span>";
			        return $msg;
					
				}else{
					$msg = "<span class='error'>Product not deleted !</span>";
			        return $msg;
				}
}

public function getFeaturedProduct(){
	$query = "SELECT * FROM tbl_product WHERE type = '0' ORDER BY productId DESC LIMIT 4";
		$result = $this->db->select($query);
		return $result;
}

public function getNewProduct(){
	$query = "SELECT * FROM tbl_product WHERE type = '1' ORDER BY productId DESC LIMIT 4";
		$result = $this->db->select($query);
		return $result;

}

public function getsingleProduct($id){
	$query = "SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName 
	FROM tbl_product
	INNER JOIN tbl_category
	ON tbl_product.catId = tbl_category.catId
		INNER JOIN tbl_brand
	ON tbl_product.brandId = tbl_brand.brandId AND tbl_product.productId = $id";
	$result = $this->db->select($query);
	return $result;

}

public function getIphoneproduct(){

            $query = "SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName
        FROM tbl_product
        INNER JOIN tbl_category
        ON tbl_product.catId = tbl_category.catId
            INNER JOIN tbl_brand
        ON tbl_product.brandId = tbl_brand.brandId
         WHERE tbl_product.brandId = '2' order by tbl_product.productId desc";
        $result = $this->db->select($query);
        return $result;




}

public function getSamsungproduct(){

            $query = "SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName
        FROM tbl_product
        INNER JOIN tbl_category
        ON tbl_product.catId = tbl_category.catId
            INNER JOIN tbl_brand
        ON tbl_product.brandId = tbl_brand.brandId
         WHERE tbl_product.brandId = '3' order by tbl_product.productId desc";
        $result = $this->db->select($query);
        return $result;




}

public function getAcerproduct(){

            $query = "SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName
        FROM tbl_product
        INNER JOIN tbl_category
        ON tbl_product.catId = tbl_category.catId
            INNER JOIN tbl_brand
        ON tbl_product.brandId = tbl_brand.brandId
         WHERE tbl_product.brandId = '4' order by tbl_product.productId desc";
        $result = $this->db->select($query);
        return $result;




}

public function getCanonproduct(){

            $query = "SELECT tbl_product.*, tbl_category.catName, tbl_brand.brandName
        FROM tbl_product
        INNER JOIN tbl_category
        ON tbl_product.catId = tbl_category.catId
            INNER JOIN tbl_brand
        ON tbl_product.brandId = tbl_brand.brandId
         WHERE tbl_product.brandId = '5' order by tbl_product.productId desc";
        $result = $this->db->select($query);
        return $result;




}

public function productByCat($id){
	
	$query = "SELECT * FROM tbl_product WHERE catId = '$id'";
		$result = $this->db->select($query);
		return $result;



}

public function insertCompareData($cmpid, $cmrId){
	$cmrId    = mysqli_real_escape_string($this->db->link, $cmrId);
	$productId    = mysqli_real_escape_string($this->db->link, $cmpid);

	$cquery = "select * from tbl_compare where cmrId = '$cmrId' AND productId = '$productId'";
	$check = $this->db->select($cquery);
	if ($check) {
		$msg = "<span class='error'>Product Allready Inserted !</span>";
			return $msg;
	}

	$query = "select * from tbl_product where productId = '$productId'";
    $result = $this->db->select($query)->fetch_assoc();
    if($result){
    
        $productid = $result['productId'];
        $productname = $result['productName'];
        $price = $result['price'];
        $image = $result['image'];

       $query = "INSERT INTO tbl_compare(cmrId, productId, productName, price, image) VALUES('$cmrId', '$productId', '$productname', '$price', '$image')";
        $inserted_rows = $this->db->insert($query);
        if ($inserted_rows) {
        	$msg = "<span class='success'>Product Inserted to Compare !</span>";
			return $msg;
        }else{
        	$msg = "<span class='error'>Product Not Inserted to Compare !</span>";
			return $msg;
        }
    }




}


public function getCompareData($cmrId){

	$query = "SELECT * FROM tbl_compare WHERE cmrId = '$cmrId' ORDER BY id DESC";
	$result = $this->db->select($query);
	return $result;
}

public function delCompareData($cmrId){
	$query = "DELETE FROM tbl_compare WHERE cmrId='$cmrId'";
	$deldata = $this->db->delete($query);
	return $deldata;


}

public function saveWishListData($id, $cmrId ){
	$cquery = "select * from tbl_wlist where cmrId = '$cmrId' AND productId = '$id'";
	$check = $this->db->select($cquery);
	if ($check) {
		$msg = "<span class='error'>Product Allready Added !</span>";
			return $msg;
	}
	$pquery = "select * from tbl_product where productId = '$id'";
    $result = $this->db->select($pquery)->fetch_assoc();
    if($result){
        $productid = $result['productId'];
        $productname = $result['productName'];
        $price = $result['price'];
        $image = $result['image'];

   		$query = "INSERT INTO tbl_wlist(cmrId,  	productId, productName, price, image) VALUES('$cmrId', '$productid', '$productname', '$price', '$image')";
        $inserted_rows = $this->db->insert($query);
          if ($inserted_rows) {
        	$msg = "<span class='success'>Added || Check wishlist Page!</span>";
			return $msg;
        }else{
        	$msg = "<span class='error'>Product Not Added to wishlist !</span>";
			return $msg;
        }   
                  


            }
    }

	public function getWlistData($cmrId){
	$query = "SELECT * FROM tbl_wlist WHERE cmrId = '$cmrId' ORDER BY id DESC";
	$result = $this->db->select($query);
	return $result;
}

public function delWlistData($cmrId, $productId){
	$query = "DELETE FROM tbl_wlist WHERE cmrId='$cmrId' AND productId= '$productId' ";
	$deldata = $this->db->delete($query);
	return $deldata;

}



}

?>