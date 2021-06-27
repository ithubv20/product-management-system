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

  <!-- Required meta tags always come first -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <!-- Bootstrap CSS -->
  <!-- <link rel="stylesheet" href="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/css/bootstrap.css"> -->

  <style type="text/css">

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

  <div class="nav1">
    <ul>
      <li><a href="items.php" class="active1" style="color:#FFFFFF;  background: #1cc88a;" >Products</a></li>
      <li>|</li>
      <li><a href="materials.php">Materials</a></li>
    </ul>

  </div>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="row mb-12">
        <div class="col mb-7 font-weight-bold text-success"
        <h6 class="m-0">All</h6>
      </div>
      <div align="right" class="col">
        <a href="addnewitem.php">
          + Add a new item
        </a>
      </div>
    </div>
  </div>
  <div class="table-responsive">
    <?php
    $sql = "SELECT tbl_items.*, tbl_categories.category_description FROM tbl_items INNER JOIN tbl_categories ON tbl_items.category = tbl_categories.id";
    $querry=$dbconn->prepare($sql);
    $querry->execute();
    $rows = $querry->fetchAll(PDO::FETCH_OBJ);
    $count = $querry->rowCount();
    ?>
    <table class="table table-bordered" id="dataTable" width="120%" cellspacing="0">

      <thead>
        <tr>
          <th>Item Name</th>
          <th>Variant Code</th>
          <th>Category</th>
          <th>Default Sales price</th>
          <th>Production Cost</th>
          <th>Profit</th>
          <th>Margin</th>
          <th>Prod. Time</th>

        </tr>
      </thead>
      <tbody>
        <?php if($count > 0)
        {
          foreach($rows as $row) {
            $default_sales_price = $row->default_sales_price;
            ?>
            <tr>
              <td><a href="productdetails.php?p_id=<?php echo($row->id);?>" class="prod" style="color: #1cc88a;"><?php echo htmlentities($row->item_name);?></a></td>
              <td><?php echo htmlentities($row->variant_code);?></td>
              <td><?php echo htmlentities($row->category_description);?></td>
              <td><?php echo htmlentities(number_format($row->default_sales_price));?></td>

                <?php
                $required_materials = unserialize($row->item_materials);
                $required_operations = unserialize($row->item_operations);
                $required_resources = unserialize($row->item_resources);
                $total_cost = 0;
                $production_period = 0;
                $req_resources = 0;
                foreach ($required_materials as $materials) {
                  // get a sum of prices for all required materials
                  $sql = "SELECT purchase_price FROM tbl_materials WHERE id = $materials";
                  $querry=$dbconn->prepare($sql);
                //  $querry->bindParam(':materials', $materials, PDO::PARAM_STR);
                  $querry->execute();
                  $rows = $querry->fetchAll(PDO::FETCH_OBJ);
                  $count = $querry->rowCount();
                  if($count > 0)
                  {
                    foreach($rows as $row) {
                        $total_cost += $row->purchase_price;
                     }
                  }
                }

                foreach ($required_operations as $operations) {
                  // get a sum of prices for all required materials
                  $sql = "SELECT time_taken FROM tbl_operations WHERE id = $operations";
                  $querry=$dbconn->prepare($sql);
                  $querry->execute();
                  $rows = $querry->fetchAll(PDO::FETCH_OBJ);
                  $count = $querry->rowCount();
                  if($count > 0)
                  {
                    foreach($rows as $row) {
                        $production_period += $row->time_taken;
                     }
                  }
                }

                foreach ($required_resources as $charge_per_hour) {
                  // get a sum of prices for all required materials
                  $sql = "SELECT resource_amount_per_hour FROM tbl_resources WHERE id = $charge_per_hour";
                  $querry=$dbconn->prepare($sql);
                  $querry->execute();
                  $rows = $querry->fetchAll(PDO::FETCH_OBJ);
                  $count = $querry->rowCount();
                  if($count > 0)
                  {
                    foreach($rows as $row) {
                        $req_resources += $row->resource_amount_per_hour;
                     }
                  }
                }
              $total = $total_cost + ($req_resources * $production_period);
              $profit = $default_sales_price - $total;?>
              <td><?php echo htmlentities(number_format($total));?></td>
              <td><?php echo htmlentities(number_format($profit));?></td>
              <td><?php echo htmlentities(round(($profit * 100) / $default_sales_price, 1))."%";?></td>
              <td><?php echo htmlentities($production_period." hrs");?></td>
              <!-- <td>0 Pcs</td>
              <td> <form action="" method="post">
              <input type="hidden" name="edit_id" value="">
              <button  type="submit" name="edit_btn" class="btn btn-success"><i class="fa fa-plus-square" aria-hidden="true"></i> </button>
            </form></td> -->
          </tr>
        <?php }}?>
      </tbody>
    </table>

  </div>
</div>

<script>
function totalIt() {
  var input = document.getElementsByName("required_materials[]");
  var total = 0;
  var selling_total = +document.getElementById("selling_price").value;
  for (var i = 0; i < input.length; i++) {
    if (input[i].checked) {
      total += parseFloat(input[i].value);
    }
  }
  total += (20 * selling_total)/100;
  document.getElementById("total").value = total.toFixed(2);
}
</script>
<?php
include('includes/scripts.php');
include('includes/footer.php');

}?>
<!-- Page level custom scripts -->
<script src="js/demo/datatables-demo.js"></script>
