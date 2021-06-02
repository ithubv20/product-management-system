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
  <link rel="stylesheet" href="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/css/bootstrap.css">

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
      <li><a href="#">Materials</a></li>
    </ul>

  </div>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-success">All</h6>
    </div>
    <div class="table-responsive">
      <?php
      $sql = "SELECT tbl_items.id, tbl_items.item_name, tbl_items.variant_code, tbl_items.default_sales_price, tbl_items.cost, tbl_items.category, tbl_items.prod_time, tbl_categories.category_description FROM tbl_items INNER JOIN tbl_categories ON tbl_items.category = tbl_categories.id";
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
              $profit = $row->default_sales_price -  $row->cost;
              ?>
          <tr>
            <td><a href="#" class="prod" style="color: #1cc88a;"><?php echo htmlentities($row->item_name);?></a></td>
            <td><?php echo htmlentities($row->variant_code);?></td>
            <td><?php echo htmlentities($row->category_description);?></td>
            <td><?php echo htmlentities($row->default_sales_price);?></td>
            <td><?php echo htmlentities($row->cost);?></td>
            <td><?php echo htmlentities($profit);?></td>
            <td><?php echo htmlentities(($profit * 100) / $row->default_sales_price)."%";?></td>
            <td><?php echo htmlentities($row->prod_time);?></td>
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
  <!-- /.container-fluid -->

  <?php
  include('includes/scripts.php');
  include('includes/footer.php');

}?>
<!-- Page level custom scripts -->
<script src="js/demo/datatables-demo.js"></script>
