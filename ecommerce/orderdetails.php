<?php
include "inc/header.php";


?>
<?php
$login = Session:: get("cuslogin");
if ($login == false) {
header("location:login.php");
}
?>
<?php
if (isset($_GET['customerId'])) {
	$id=$_GET['customerId'];
	$date=$_GET['time'];
	$price=$_GET['price'];

	$confirm = $ct->productShiftConfirm($id, $date, $price);
}
?>

	<div class="contentsection contemplete clear">
		<div class="maincontent clear">
			<div class="about">
				<div class="notfound">
    				<p>Your order details</p>
    				<table class="tblone">
							<tr>
								<th>No</th>
								<th>Productname</th>
								<th>image</th>
								<th>Quantity</th>
								<th>Total price</th>
								<th>Date</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						 	<?php
						 	$cmrId = session::get('cmrid');
						 	$getOrder = $ct->getOderedProduct($cmrId);

			               	
									if($getOrder){
										$i = 0;
									while($result=$getOrder->fetch_assoc()){

									$i++;

			               ?>	
			              
			 				<tr>
			                     <td><?php echo $i;?></td>
								<td><?php echo $result['productName'];?></td>
								<td><img src="admin/<?php echo $result['image'];?>" alt=""/></td>
								<td><?php echo $result['quantity'];?></td>
								<td>$<?php echo $result['price'];?></td>
								<td><?php echo $fm->formatDate($result['date']);?></td>
								<td>
								<?php 
								if ($result['status'] == '0') {
									echo 'Pending';
								}elseif ($result['status'] == '1'){ 
									echo "shifted";
								 }else{ 
									echo "OK";
						 			} 

								?>
									
								</td>

								<?php

								if ($result['status'] == '1') { ?>
									<td><a href="?customerId=<?php echo $cmrId;?>&price=<?php echo $result['price'];?>&time=<?php echo $result['date'];?>">Confirm</a></td>

								<?php } elseif($result['status'] == '2') { ?>
									<td>OK</td>
									<?php }elseif ($result['status'] == '0') { ?>
										<td>N/A</td>
								<?php	} ?>
								
								
							</tr>
						
							
					
								<?php } } ?>
							
							
							
							</table>
    			</div>
	        </div>
		</div>
	
		<?php include "inc/footer.php";?>