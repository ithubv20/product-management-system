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
  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-success">All Orders</h6>
    </div>
    <div class="table-responsive">
      <?php
      $sql = "SELECT tbl_sales_orders.*, tbl_items.item_name, tbl_items.item_materials, tbl_items.item_operations, tbl_stock.in_stock, tbl_stock.expected_date FROM tbl_sales_orders INNER JOIN tbl_stock ON tbl_sales_orders.item = tbl_stock.item_name INNER JOIN tbl_items ON tbl_sales_orders.item = tbl_items.id WHERE order_status = 2";
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
            <th>Product</th>
            <th>Quantity</th>
            <th>Prod. time</th>
            <th>Prod. deadline</th>
            <th>Production</th>

          </tr>
        </thead>
        <tbody>
          <?php if($count > 0)
          {
            foreach($rows as $row) {
              $order_status =  $row->order_status;
              $order_id = $row->id;
              $d_deadline = $row->delivery_deadline;
              $item_material = $row->item_materials;
              ?>
              <tr>
                <td><?php echo($cnt);?></td>
                <td><a href="orderdetails.php?order_id=<?php echo($order_id);?>" class="prod" style="color: #1cc88a;"><?php echo htmlentities($row->order_number);?></a></td>
                <td><?php echo htmlentities($row->customer_name);?></td>
                <td><?php echo htmlentities($row->item_name);?></td>
                <td><?php echo htmlentities($row->order_quantity);?></td>
                <?php
                $required_operations = unserialize($row->item_operations);
                $production_period = 0;
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
                }?>
                <td><?php echo htmlentities($production_period." hrs");?></td>
                <td><?php echo htmlentities($d_deadline);?></td>
                <?php if($order_status == 1){?>
                  <td style="background-color: #fea349; color: #000">In progress</td>
                <?php }
                else{?>
                  <td style="background-color: #34b08b; color: #fff">Completed</td>
                <?php }?>
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
