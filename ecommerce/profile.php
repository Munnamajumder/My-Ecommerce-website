<?php include "inc/header.php";?>
<?php
$login = Session:: get("cuslogin");
if ($login == false) {
header("location:login.php");
}
?>
<style>
	.tblone{width: 550px; margin: 0 auto; border: 1px solid #ddd;}
	.tblone tr td{text-align: justify;}
	.tblone input[type='text']{width: 400px;padding: 5px;font-size: 15px}
</style>

 <div class="main">
    <div class="content">
    	<div class="section group">
    	<?php
    	$id = Session:: get("cmrid");
    	$getdata= $cmr->getCustomerData($id);
    	
					if($getdata){
					while($result=$getdata->fetch_assoc()){
    	?>
				<table class="tblone">
				   <tr>
						<td>Your Profile Details ......</td>
					</tr>
					<tr>
						<td >Name</td>
						<td>:</td>
						<td><?php echo $result['name'];?></td>
					</tr>
					<tr>
						<td>Phone</td>
						<td>:</td>
						<td><?php echo $result['phone'];?></td>
					</tr>
					<tr>
						<td>Email</td>
						<td>:</td>
						<td><?php echo $result['email'];?></td>
					</tr>
					<tr>
						<td>Address</td>
						<td>:</td>
						<td><?php echo $result['address'];?></td>
					</tr>
					<tr>
						<td>City</td>
						<td>:</td>
						<td><?php echo $result['city'];?></td>
					</tr>
					<tr>
						<td>Zip-code</td>
						<td>:</td>
						<td><?php echo $result['zip'];?></td>
					</tr>						
					<tr>
						<td>Country</td>
						<td>:</td>
						<td><?php echo $result['country'];?></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td><a href="editprofile.php">Update Profile</a></td>
					</tr>

				</table>
    	<?php } } ?>
 				</div>
 		</div>
 	</div>
	<?php include "inc/footer.php";?>