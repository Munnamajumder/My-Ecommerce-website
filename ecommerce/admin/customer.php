<?php include_ONCE "../classes/Category.php";?>
<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php 
$filepath = realpath(dirname(__FILE__));

include_ONCE ($filepath."/../classes/Customer.php");


?>
<?php
$db = new Database();

if(!isset($_GET['cusId']) || $_GET['cusId']==NULL){
  echo "<script>window.location = 'inbox.php';</script>";
}else{
  $id=$_GET['cusId'];
  $id = mysqli_real_escape_string($db->link,$id);
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
   echo "<script>window.location = 'inbox.php';</script>";
}


?>
        <div class="grid_10">
            <div class="box round first grid">
            <h2>Customer Details</h2>
             <div class="block copyblock"> 

               <?php
                  $cus = new Customer();
                  $getCust = $cus->getCustomerData($id);

                  if ($getCust) {
                    while ($result = $getCust->fetch_assoc()) {
                      
               ?>


                 <form action="" method="POST">
                    <table class="form">					
                        <tr>
                        <td>Name</td>
                            <td>
                                <input type="text" readonly="readonly" value="<?php echo $result['name'];?>"   class="medium" />
                            </td>
                        </tr>
                         <tr>
                        <td>Address</td>
                            <td>
                                <input type="text" readonly="readonly" value="<?php echo $result['address'];?>"   class="medium" />
                            </td>
                        </tr>

                         <tr>
                        <td>City</td>
                            <td>
                                <input type="text" readonly="readonly" value="<?php echo $result['city'];?>"   class="medium" />
                            </td>
                        </tr>

                         <tr>
                        <td>Zip code</td>
                            <td>
                                <input type="text" readonly="readonly" value="<?php echo $result['zip'];?>"   class="medium" />
                            </td>
                        </tr>

                         <tr>
                        <td>Phone</td>
                            <td>
                                <input type="text" readonly="readonly" value="<?php echo $result['phone'];?>"   class="medium" />
                            </td>
                        </tr>

                         <tr>
                        <td>Email</td>
                            <td>
                                <input type="text" readonly="readonly" value="<?php echo $result['email'];?>"   class="medium" />
                            </td>
                        </tr>

                         <tr>
                        <td>Name</td>
                            <td>
                                <input type="text" readonly="readonly" value="<?php echo $result['name'];?>"   class="medium" />
                            </td>
                        </tr>
						<tr> 
                            <td>
                                <input type="submit" name="submit" Value="Ok" />
                            </td>
                        </tr>
                    </table>
                    </form>
                    <?php }} ?>

                </div>
            </div>
        </div>
<?php include 'inc/footer.php';?>