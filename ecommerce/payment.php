<?php include "inc/header.php";?>
<?php
$login = Session:: get("cuslogin");
if ($login == false) {
header("location:login.php");
}
?>


 <div class="main">
    <div class="content">
    	<div class="section group">
    	<div class="payment">
    		<h2>Choose payment option</h2>
    		<a href="paymentoffline.php">Offline payment</a>
    		<a href="paymentonline.php">Online payment</a>
    	</div>
    	<div class="back">
    		<a href="cart.php">Previous</a>
    	</div>


 				</div>
 		</div>
 	</div>
	<?php include "inc/footer.php";?>