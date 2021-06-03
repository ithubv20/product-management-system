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
      <li><a href="sellsquote.php">Quotation</a></li>
      <li>|</li>
      <li><a href="sellsorders.php" class="active1" style="color:#FFFFFF;  background: #1cc88a;">Sales Orders</a></li>
    </ul>

  </div>


  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-success">All</h6>
    </div>
    <div class="table-responsive">
      <?php
      $sql = "SELECT * FROM tbl_sales_orders WHERE order_status = 1";
      $querry=$dbconn->prepare($sql);
      $querry->execute();
      $rows = $querry->fetchAll(PDO::FETCH_OBJ);
      $count = $querry->rowCount();
      $cnt = 1;?>
      <table class="table table-bordered" id="dataTable" width="120%" cellspacing="0">

        <thead>
          <tr>
            <th>Rank</th>
            <th>Order #</th>
            <th>Customer</th>
            <th>Total Amount</th>
            <th>Delivery Deadline</th>
            <th>Sales Items</th>
            <th>Ingredients</th>
            <th>Production</th>
            <th>Delivery</th>
            <th>Action</th>

          </tr>
        </thead>
        <tbody>
          <?php if($count > 0)
              {
                foreach($rows as $row) {
                  ?>
          <tr>
            <td><?php echo($cnt);?></td>
            <td><a href="#" class="prod" style="color: #1cc88a;"><?php echo htmlentities($row->order_number);?></a></td>
            <td><?php echo htmlentities($row->customer_name);?></td>
            <td><?php echo htmlentities($row->total_amount);?></td>
            <td><?php echo htmlentities($row->delivery_deadline);?></td>
            <td>In stock</td>
            <td>Processed </td>
            <td>Work in Progress</td>
            <td>Not Delivered</td>
            <td><a href="#">Confirm Order</a></td>
          </tr>
            <?php $cnt++;}}?>

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
