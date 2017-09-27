<?php include_ONCE "../classes/Category.php";?>
<?php include 'inc/header.php';?>
<?php include 'inc/sidebar.php';?>
<?php

if(!isset($_GET['catid']) || $_GET['catid']==NULL){
  echo "<script>window.location = 'catlist.php';</script>";
}else{
  $id=$_GET['catid'];
  $id = mysqli_real_escape_string($db->link,$id);
}


$cat = new Category();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $catName = $_POST['catName'];

    $updateCat = $cat->catUpdate($catName,$id);
}


?>
        <div class="grid_10">
            <div class="box round first grid">
             <div class="block copyblock"> 
               <?php
               if (isset($updateCat)) {
                   echo "$updateCat";
               }

               ?>

               <?php
                  $getCat = $cat->getCatById($id);

                  if ($getCat) {
                    while ($result = $getCat->fetch_assoc()) {
                      
               ?>


                 <form action="" method="POST">
                    <table class="form">					
                        <tr>
                            <td>
                                <input type="text" name="catName" value="<?php echo $result['catName'];?>"   class="medium" />
                            </td>
                        </tr>
						<tr> 
                            <td>
                                <input type="submit" name="submit" Value="Save" />
                            </td>
                        </tr>
                    </table>
                    </form>
                    <?php }} ?>

                </div>
            </div>
        </div>
<?php include 'inc/footer.php';?>