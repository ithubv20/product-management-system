<?php
session_start();
include('../includes/config.php');

if (empty($_SESSION['user_id'])){
  header('Location: ../index.php');
}
if(isset($_GET['quote_id'])){
  $quote_id = intval($_GET['quote_id']);
  $sql = "UPDATE `tbl_sales_orders` SET order_status = 1 WHERE id = :quote_id";
  $query = $dbconn -> prepare($sql);
  $query->bindParam(':quote_id',$quote_id, PDO::PARAM_INT);
  $query->execute();
  $count =$query->rowCount();
  if($count > 0){
    echo ("<script>alert('order confirmed successfully')</script>");
    echo ('<script>window.location.href = "sellsquote.php";</script>');
  }
  else{
    echo ("<script>alert('something went wrong')</script>");
  }
}
if(isset($_GET['del_id'])){
  $delete_id = intval($_GET['del_id']);
  $sql = "DELETE FROM `tbl_sales_orders` WHERE id = :delete_id";
  $query = $dbconn -> prepare($sql);
  $query->bindParam(':delete_id',$delete_id, PDO::PARAM_INT);
  $query->execute();
  $count =$query->rowCount();
  if($count > 0){
    echo ("<script>alert('quotation deleted successfully')</script>");
    echo ('<script>window.location.href = "sellsquote.php";</script>');
  }
  else{
    echo ("<script>alert('something went wrong')</script>");
  }
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
      <li><a href="sellsquote.php" class="active1" style="color:#FFFFFF;  background: #1cc88a;">Quotation</a></li>
      <li>|</li>
      <li><a href="sellsorders.php">Sales Orders</a></li>
    </ul>

  </div>


  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="row mb-12">
        <div class="col mb-7 font-weight-bold text-success"
        <h6 class="m-0"><a class="btn btn-success" href="generate_quotation.php"> Download Quotation</a></h6>
      </div>
      <div align="right" class="col">
        <a href="createsellsquote.php">
          + Create a new quotation
        </a>
      </div>
    </div>
  </div>
  <div class="table-responsive">
    <?php
    $sql = "SELECT tbl_sales_orders.id, tbl_sales_orders.order_number, tbl_sales_orders.item, tbl_sales_orders.customer_name, tbl_sales_orders.total_amount, tbl_sales_orders.delivery_deadline, tbl_items.item_name FROM tbl_sales_orders INNER JOIN tbl_items ON tbl_sales_orders.item = tbl_items.id WHERE tbl_sales_orders.order_status = 0";
    $querry=$dbconn->prepare($sql);
    $querry->execute();
    $rows = $querry->fetchAll(PDO::FETCH_OBJ);
    $count = $querry->rowCount();
    $cnt = 1;?>
    <table class="table table-bordered" id="dataTable" width="120%" cellspacing="0">

      <thead>
        <tr>
          <th>Rank</th>
          <th>Quote #</th>
          <th>Item</th>
          <th>Customer</th>
          <th>Total Amount</th>
          <th>Valid up-to</th>
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
              <td><?php echo htmlentities($row->order_number);?></td>
              <td><?php echo htmlentities($row->item_name);?></td>
              <td><?php echo htmlentities($row->customer_name);?></td>
              <td><?php echo htmlentities($row->total_amount);?></td>
              <td><?php echo htmlentities($row->delivery_deadline);?></td>
              <td><a href="sellsquote.php?quote_id=<?php echo $row->id ?>" onclick="return confirm('confirm quotation?')">Confirm Order</a> | <a href="sellsquote.php?del_id=<?php echo $row->id ?>"  onclick="return confirm('Delete quotation?')">Delete</a></td>
            </tr>
            <?php $cnt++;}}?>

          </tbody>
        </table>

      </div>
    </div>
    <!-- /.container-fluid -->
    <!-- /.container-fluid -->
    <?php
    include('includes/scripts.php');
    include('includes/footer.php');

  }?>
  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>
