<?php include "inc/header.php";?>

<?php
$login = Session:: get("cuslogin");
if ($login == false) {
header("location:login.php");
}
?>
<style>
.content {
  background: #fff none repeat scroll 0 0;
  border: 1px solid #9c9c9c;
  line-height: 35px;
  margin: 20px auto;
  padding: 125px;
  position: relative;
  width: 500px;
  text-align: center;
}
.content h2 {
  color: #6c6c6c;
  font-family: "Monda",sans-serif;
  font-size: 23px;
  text-align: center;
}
    
</style>


 <div class="main">
    <div class="content">
        <div class="section group">
        <div class="psuccess">
            <h2>Success</h2>
            <p>Payment successful.......</p>
            <?php
            $cmrId = session::get('cmrid');
            $amount = $ct->payableAmount($cmrId);
              if ($amount) {
                $sum = 0;
                while ($result = $amount->fetch_assoc()) {
                   $price = $result['price'];
                   $sum = $sum + $price;

                }
            }
            ?>
            <p>Total payable amount(including vat) :$
            <?php

                $vat = $sum * 0.1 ;
                $total = $sum + $vat ;
                echo $total;


            ?>

            </p>
            <p>Thanks for purchase.Receive your order successfully.We will contact you ASAP with delivery details.Here is your order details....<a href="orderdetails.php">Visit here</a></p>
        </div>


                </div>
        </div>
    </div>
    <?php include "inc/footer.php";?>