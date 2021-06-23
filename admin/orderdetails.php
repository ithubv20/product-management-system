<?php
session_start();
include('../includes/config.php');

if (empty($_SESSION['user_id'])){
  header('Location: ../index.php');
}
else{
  include('includes/header.php');
  include('includes/navbar.php');
  include('includes/topbar.php');
  ?>



  <!-- Begin Page Content -->
  <style type="text/css">

  /*content css*/

  .form-group{
    border: 0px;
    border-bottom: 10px;
    margin-left: 10px;

  }
  #calc{
    border: none;
    border-bottom: solid;
    border-bottom-width: thin;
    margin-left: 50%;
  }
  #label{
    border: none;
    border-bottom: solid;
    border-bottom-width: thin;

  }

  #put{
    border: none;
    margin-left: 65%;
    text-align: center;
  }

  #qoute{
    box-sizing: 50px;

    size: 75px;


  }

  #data{
    border: none;
    border-bottom: #0000 inset solid;
    border-bottom-width: thin;
    box-sizing: 50%

  }


  #dataTable{

    padding: 10px;
    text-align: center;
    table-layout: auto;
    border-radius: 10px;
  }
  /*nav  css*/

  .nav1
  {
    font-size:20px;
    text-decoration:none;
    text-align:center;
    border-bottom: 6px solid  #1cc88a;
  }

  .nav1 ul li
  {
    padding:10px;
    display:inline;
  }

  .nav1 ul li a
  {
    text-decoration:none;
    color:#444;
  }

  .nav1 ul li a:hover
  {
    color:#111;

  }

  .active1
  {
    color:#000;
    border-bottom:5px solid green;
    padding:10px;
  }
  .prod{
    text-decoration-line: underline;

  }
  .table-responsive{
    margin-left: 2%;
    table-layout: auto;

  }
  </style>

  <style type="text/css">



  </style>

  <div class="nav1">
  </div>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="row mb-12">
        <div class="col mb-7 font-weight-bold text-success"
        <h6 class="m-0">Order details</h6>
      </div>
    </div>
  </div>

  <div class="card-body">
    <div class="container-fluid">

      <form action="items_processor.php" method="POST">
        <?php
        $o_id=intval($_GET['order_id']);
        $sql = "SELECT tbl_sales_orders.*, tbl_items.item_name, tbl_items.item_materials, tbl_items.item_operations, tbl_items.item_resources FROM tbl_sales_orders INNER JOIN tbl_items ON tbl_sales_orders.item = tbl_items.id WHERE tbl_sales_orders.id = :o_id";
        $query = $dbconn->prepare($sql);
        $query->bindParam(':o_id',$o_id, PDO::PARAM_INT);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if($results){
          foreach ($results as $result) {
            ?>
            <div class="row">
              <div class="col-lg-6 form-group">
                <label class="tiny-font"> Order number </label>
                <input type="text" name="item_name" class="form-select" value="<?php echo htmlentities($result->order_number);?>" readonly>
              </div>
              <div class="col-lg-5 form-group">
                <label class="tiny-font">Deadline </label>
                <input type="text" name="item_name" class="form-select" value="<?php echo htmlentities($result->delivery_deadline);?>" readonly>
              </div>

              <div class="col-lg-5 form-group">
                <label class="tiny-font">Product </label>
                <input type="text" name="item_name" class="form-select" value="<?php echo htmlentities($result->item_name);?>" readonly>
              </div>

              <div class="col-lg-3 form-group">
                <label class="tiny-font">Quantity </label>
                <input type="text" name="item_name" class="form-select" value="<?php echo htmlentities($result->order_quantity);?>" readonly>
              </div>

              <div class="col-lg-3 form-group">
                <label class="tiny-font">Total cost </label>
                <input type="text" name="item_name" class="form-select" value="<?php echo htmlentities(number_format($result->total_amount));?>" readonly>
              </div>
              <label><br><strong>Ingredients</strong> </label><br>
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                <thead>
                  <tr>
                    <th>item </th>
                    <th>quantity </th>
                    <th>cost </th>
                    <th>availability </th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  $required_materials = unserialize($result->item_materials);

                  foreach ($required_materials as $materials) {
                    // get a sum of prices for all required materials
                    $sql = "SELECT tbl_materials.*, tbl_stock_material.in_stock, tbl_stock_material.m_expected_date FROM  tbl_materials INNER JOIN tbl_stock_material ON tbl_materials.id = tbl_stock_material.material_name WHERE tbl_materials.id = $materials";
                    $querry=$dbconn->prepare($sql);
                    //  $querry->bindParam(':materials', $materials, PDO::PARAM_STR);
                    $querry->execute();
                    $rows = $querry->fetchAll(PDO::FETCH_OBJ);
                    $count = $querry->rowCount();
                    if($count > 0)
                    {
                      foreach($rows as $row) {?>
                        <tr>
                          <td> <?php echo htmlentities($row->material_name); ?> </td>
                          <td> <?php echo ($result->order_quantity); ?></td>
                          <td> <?php echo ($result->order_quantity *  $row->purchase_price); ?></td>
                          <?php
                          if($row->in_stock != 0){?>
                            <td style="background-color: #34b08b; color: #fff"> in stock </td>
                          <?php  }
                          else if($row->in_stock  == 0 AND !empty($row->m_expected_date)){?>
                            <td style="background-color: #fea349; color: #000">
                              Expected<br>
                              <strong> <?php echo($row->m_expected_date);?> </strong></td>
                            <?php  }
                            else{?>
                              <td style="background-color: #e9004e; color: #fff;">not available</td>
                            <?php  } ?>
                          </tr>
                        <?php } }}?>
                      </tbody>
                    </table>

                    <label><br><strong>Operations</strong> </label><br>
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                      <thead>
                        <tr>
                          <th>Operation step </th>
                          <th>Resource</th>
                          <th>Time </th>
                          <th>Cost </th>
                          <th>Status </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php

                        $res_name = 'name';
                        $req_resources = 0;
                        $res_amount_per_hour = 0;
                        $required_resources = unserialize($result->item_resources);
                        foreach ($required_resources as $resource) {
                          // get a sum of prices for all required materials
                          $sql = "SELECT * FROM tbl_resources WHERE id = $resource";
                          $querry=$dbconn->prepare($sql);
                          $querry->execute();
                          $rows = $querry->fetchAll(PDO::FETCH_OBJ);
                          $count = $querry->rowCount();
                          if($count > 0)
                          {
                            foreach($rows as $row) {
                              $req_resources += $row->resource_amount_per_hour;
                              $res_name = $row->resource_description;
                              $res_amount_per_hour = $row->resource_amount_per_hour;
                            }
                          }
                        }?>

                        <?php
                        $required_operations = unserialize($result->item_operations);

                        foreach ($required_operations as $operations) {
                          // get a sum of prices for all required materials
                          $sql = "SELECT * FROM tbl_operations WHERE id = $operations";
                          $querry=$dbconn->prepare($sql);
                          //  $querry->bindParam(':materials', $materials, PDO::PARAM_STR);
                          $querry->execute();
                          $rows = $querry->fetchAll(PDO::FETCH_OBJ);
                          $count = $querry->rowCount();
                          if($count > 0)
                          {
                            foreach($rows as $row) {?>
                              <tr>
                                <td> <?php echo htmlentities($row->operation_description); ?> </td>
                                <td> <?php echo htmlentities($res_name); ?> </td>
                                <td> <?php echo ($row->time_taken." hrs"); ?></td>
                                <td> <?php echo ($row->time_taken *  $res_amount_per_hour); ?></td>
                                <?php if($result->make_status == 1){?>
                                          <td style="background-color: #bfbfbf; color:#000"><a href="#" title="Not started"> <i class="fas fa-play"></i></a></td>
                              <?php  }
                              else if($result->make_status == 2){?>
                                        <td style="background-color: #fea349; color: #000"><a href="#" title="started"> <i class="fa fa-clock"></i></a></td>
                            <?php  }
                            else{ ?>
                                      <td style="background-color: #34b08b; color: #fff"><a href="#" title="done"> <i class="fas fa-check"></i></a></td>
                          <?php  }?>
                              </tr>
                            <?php } }}?>
                          </tbody>
                        </table>
                      <?php }}?>
                    </div>
                  </form>

                </div>
              </div>
            </div>
            <script>
            function myFunction() {
              var item_price = document.getElementById("mySelect").value;
              var item_price_to_array = JSON.parse("[" + item_price + "]");
              var item_quantity = document.getElementById("sells_quantity").value;
              document.getElementById("sells_price").value = item_price_to_array[1];
              document.getElementById("total_price").value = item_quantity * item_price_to_array[1];
              document.getElementById("tot_num").innerHTML= item_quantity;
              document.getElementById("sub_total").innerHTML=   document.getElementById("total_price").value;
              document.getElementById("total_vat").innerHTML= (20 * document.getElementById("total_price").value)/100;
              document.getElementById("total_sells").innerHTML=   "MK" + (+document.getElementById("sub_total").innerHTML +   +document.getElementById("total_vat").innerHTML);
            }
            </script>

            <?php
            include('includes/scripts.php');
            include('includes/footer.php');

          }?>
