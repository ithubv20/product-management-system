<?php
session_start();
include('../includes/config.php');

if (empty($_SESSION['user_id'])){
  header('Location: ../index.php');
}
else if(isset($_GET['make_id'])){
  $make_id = intval($_GET['make_id']);
  $sql = "UPDATE `tbl_sales_orders` SET make_status = 1 WHERE id = :make_id";
  $query = $dbconn -> prepare($sql);
  $query->bindParam(':make_id',$make_id, PDO::PARAM_INT);
  $query->execute();
  $count =$query->rowCount();
  if($count > 0){
    echo ('<script>window.location.href = "sellsorders.php";</script>');
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
      <li><a href="buymaterials.php">Open</a></li>
      <li>|</li>
      <li><a href="receivedmaterials.php" class="active1" style="color:#FFFFFF;  background: #1cc88a;">Received Materials</a></li>
    </ul>

  </div>


  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-success">All</h6>
    </div>
    <div class="table-responsive">
      <?php
      $sql = "SELECT tbl_buy_materials.*, tbl_materials.material_name, tbl_materials.purchase_price FROM tbl_buy_materials INNER JOIN tbl_materials ON tbl_buy_materials.material_id = tbl_materials.id WHERE tbl_buy_materials.status = 1";
      $querry=$dbconn->prepare($sql);
      $querry->execute();
      $rows = $querry->fetchAll(PDO::FETCH_OBJ);
      $count = $querry->rowCount();
      $cnt = 1;?>
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

        <thead>
          <tr>
            <th>Order #</th>
            <th>Supplier</th>
            <th>Total amount</th>
            <th>Expected arrival</th>
            <th>Delivery</th>
          </tr>
        </thead>
        <tbody>
          <?php if($count > 0)
          {
            foreach($rows as $row) {
              ?>
              <tr>
                <td><a href="#" class="prod" style="color: #1cc88a;"><?php echo htmlentities("PO-".$row->id);?></a></td>
                <td><?php echo htmlentities($row->material_name);?></td>
                <td><?php echo htmlentities(number_format($row->buy_quantity * $row->purchase_price));?></td>
                <td><?php echo htmlentities($row->arrival_date);?></td>

                <td><div style="color: blue">Received</div></td>
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
