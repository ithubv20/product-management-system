<?php
session_start();
include('../includes/config.php');

if (empty($_SESSION['user_id'])){
  header('Location: ../index.php');
}

if(isset($_POST['update_price'])){
  $sells_price = $_POST['sells_price'];
  $prod_id = $_POST['prod_id'];

  $sql ="UPDATE `tbl_items` SET default_sales_price = :sells_price WHERE id=:prod_id";
  $query = $dbconn->prepare($sql);
  $query->bindParam(':sells_price', $sells_price, PDO::PARAM_STR);
  $query->bindParam(':prod_id', $prod_id, PDO::PARAM_STR);
  $query->execute();
  $count =$query->rowCount();
  if($count > 0){
    echo ('<script>alert("Sells price updated successfully.")</script>');
    echo ('<script>window.location.href = "items.php";</script>');
  }
  else {
    echo ('<script>alert("Somethin went wrong.")</script>');
  }
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

      <form method="POST">
        <?php
        $o_id=intval($_GET['p_id']);
        $sql = "SELECT tbl_items.*, tbl_categories.category_description FROM tbl_items INNER JOIN tbl_categories ON tbl_items.category = tbl_categories.id WHERE tbl_items.id = :o_id";
        $query = $dbconn->prepare($sql);
        $query->bindParam(':o_id',$o_id, PDO::PARAM_INT);
        $query->execute();
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        if($results){
          foreach ($results as $result) {
            ?>
            <div class="row">
              <div class="col-lg-5 form-group">
                <label class="tiny-font">Product </label>
                <input type="text" name="item_name" class="form-select" value="<?php echo htmlentities($result->item_name);?>" readonly>
              </div>

              <input type="text" name="prod_id" value="<?php echo($o_id);?>" hidden/>

              <div class="col-lg-3 form-group">
                <label class="tiny-font">Sells Price </label>
                <input type="text" name="sells_price" class="form-control" value="<?php echo htmlentities($result->default_sales_price);?>" >
              </div>

              <div class="col-lg-3 form-group">
              <input type="submit" name="update_price" value="Update Price" class="btn btn-success"/>
              </div>
              <div class="col-lg-3 form-group">
                <label class="tiny-font">Code</label>
                <input type="text" name="item_name" class="form-select" value="<?php echo htmlentities($result->variant_code);?>" readonly>
              </div>
              </div>
              <label><br><strong>Ingredients</strong> </label><br>
              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                <thead>
                  <tr>
                    <th>item </th>
                    <th>cost </th>
                  </tr>
                </thead>
                <tbody>

                  <?php
                  $required_materials = unserialize($result->item_materials);

                  foreach ($required_materials as $materials) {
                    // get a sum of prices for all required materials
                    $sql = "SELECT * FROM tbl_materials WHERE id = $materials";
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
                          <td> <?php echo ($row->purchase_price); ?></td>
                          </tr>
                        <?php } }}?>
                      </tbody>
                    </table>

                    <div class="row">
                      <div class="col">
                        <label><br><strong>Operations: </strong> </label>
                      </div>
                      <div><br>
                          </div>
                        </div><br>
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

                          <thead>
                            <tr>
                              <th>Operation step </th>
                              <th>Resource</th>
                              <th>Time </th>
                              <th>Cost </th>
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

                                  </tr>
                                <?php } }}?>
                              </tbody>
                            </table>
                          <?php }}?>

                      </form>

                    </div>
                  </div>
                </div>
                <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
                <script>
                function changeProductionStatus(o_id) {
                  var production_status = document.getElementById("production_status").value;

                  $.ajax({
                    'url': 'orderdetails.php',
                    'method': 'POST',
                    'data': {'order_id': o_id, 'order_status': production_status},
                    success: function(response)
                    {
                      window.location.reload();
                    }
                  });
                }
                </script>

                <?php
                include('includes/scripts.php');
                include('includes/footer.php');

              }?>
