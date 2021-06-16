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
        <h6 class="m-0">Add a new item</h6>
      </div>
    </div>
  </div>

  <div class="card-body">
    <div class="container-fluid">

      <form action="items_processor.php" method="POST">
        <div class="row">
          <div class="col-lg-6 form-group">
            <!-- <label> Username </label> -->
            <input type="text" name="item_name" class="form-control" placeholder="item name" required>
          </div>
          <div class="col-lg-5 form-group">
            <!-- <label>Email</label> -->
            <input type="text" name="item_code" class="form-control" placeholder="item code" required>
          </div>
          <select class="col-lg-6 form-group form-select" name="item_category">
            <option selected>Select item category</option>
            <?php
            $sql ="SELECT * FROM tbl_categories";
            $query= $dbconn -> prepare($sql);
            $query-> execute();
            $results = $query -> fetchAll(PDO::FETCH_OBJ);
            $cnt=1;
            if($query -> rowCount() > 0)
            {
              foreach ($results as $result) {
                // below code fetches data in the user_roles tables
                ?>
                <option value="<?php echo htmlentities($result->id) ?>"> <?php echo htmlentities($result->category_description) ?> </option>
              <?php  }

            } ?>
          </select>
          <div class=" col-lg-5 form-group">
            <!-- <label>Email</label> -->
            <input type="number" id="selling_price" onblur="totalIt()" name="item_default_selling_price" class="form-control" placeholder="default selling price" required>
          </div>

        <div class="col-lg-3 form-group">
          <div class="form-group">
            <label><strong>Required materials</strong></label>
          </div>
          <?php
          $sql ="SELECT * FROM tbl_materials";
          $query= $dbconn -> prepare($sql);
          $query-> execute();
          $results = $query -> fetchAll(PDO::FETCH_OBJ);
          $cnt=1;
          if($query -> rowCount() > 0)
          {
            foreach ($results as $result) {
              // below code fetches data in the user_roles tables
              // ?>
                <div class="table_items"><input type="checkbox" name="required_materials[]" value="<?php echo htmlentities($result->id);?>">&nbsp &nbsp<?php echo htmlentities($result->material_name);?></input></div>
            <?php }} ?>
        </div>

        <div class="col-lg-4 form-group">
          <div class="form-group">
            <label><strong>Required Operations</strong></label>
          </div>
          <?php
          $sql ="SELECT * FROM tbl_operations";
          $query= $dbconn -> prepare($sql);
          $query-> execute();
          $results = $query -> fetchAll(PDO::FETCH_OBJ);
          $cnt=1;
          if($query -> rowCount() > 0)
          {
            foreach ($results as $result) {
              // below code fetches data in the user_roles tables
              // ?>
                <div class="table_items"><input type="checkbox" name="required_operations[]" value="<?php echo htmlentities($result->id);?>">&nbsp &nbsp<?php echo htmlentities($result->operation_description);?></input></div>
            <?php }} ?>
        </div>
        <div class="col-lg-4 form-group">
          <div class="form-group">
            <label><strong>Resources</strong></label>
          </div>
          <?php
          $sql ="SELECT * FROM tbl_resources";
          $query= $dbconn -> prepare($sql);
          $query-> execute();
          $results = $query -> fetchAll(PDO::FETCH_OBJ);
          $cnt=1;
          if($query -> rowCount() > 0)
          {
            foreach ($results as $result) {
              // below code fetches data in the user_roles tables
              // ?>
                <div class="table_items"><input type="checkbox" name="human_resource[]" value="<?php echo htmlentities($result->id);?>">&nbsp &nbsp<?php echo htmlentities($result->resource_description);?></input></div>
            <?php }} ?>
        </div>
      </div>
      <div align="right" class="col form-group">
        <button type="submit" name="create_item" class="btn btn-success">Add an Item</button>
      </div>
        </form>

      </div>
    </div>
  </div>
  <!-- <script>
  function totalIt() {
  var sells_amount = document.getElementsById("sells_amount").value;
  var total = 0;
  var sells_quantity = +document.getElementById("sells_quantity").value;
  alert(sells_quantity);
  total = sells_quantity * sells_amount;
  document.getElementById("sells_price").value = document.getElementsById("sells_amount").value;
  document.getElementById("total_price").value = total.toFixed(2);
}
</script> -->
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
