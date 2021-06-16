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
      $sql = "SELECT tbl_sales_orders.*, tbl_items.item_materials, tbl_stock.in_stock, tbl_stock.expected_date FROM tbl_sales_orders INNER JOIN tbl_stock ON tbl_sales_orders.item = tbl_stock.item_name INNER JOIN tbl_items ON tbl_sales_orders.item = tbl_items.id WHERE tbl_sales_orders.order_status = 1";
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

          </tr>
        </thead>
        <tbody>
          <?php if($count > 0)
          {
            foreach($rows as $row) {
              $make_status =  $row->make_status;
              $order_id = $row->id;
              ?>
              <tr>
                <td><?php echo($cnt);?></td>
                <td><a href="#" class="prod" style="color: #1cc88a;"><?php echo htmlentities($row->order_number);?></a></td>
                <td><?php echo htmlentities($row->customer_name);?></td>
                <td><?php echo htmlentities(number_format($row->total_amount));?></td>
                <td><?php echo htmlentities($row->delivery_deadline);?></td>
                <?php
                $stock_status = $row->in_stock;
                $expected_stock = $row->expected_date;
                if($stock_status == 0 AND $expected_stock == ""){?>
                  <td style="background-color: #e9004e; color: #fff;">not available</td>
                <?php }
                else if($stock_status == 0 AND $expected_stock != ""){?>
                  <td style="background-color: #fea349; color: #000">
                    Expected<br>
                    <strong> <?php echo("$expected_stock");?> </strong></td>
                  <?php }
                  else{?>
                    <td style="background-color: #34b08b; color: #fff"> in stock </td>
                  <?php  }

                    //materials section
                      $stock_materials = unserialize($row->item_materials);
                      $any_stock_out = 'False';
                      $m_expected_date = Array();
                      $not_available = '';

                      foreach ($stock_materials as $materials) {
                        // get a sum of prices for all required materials
                        $sql = "SELECT * FROM tbl_stock_material WHERE id = $materials";
                        $querry=$dbconn->prepare($sql);
                        //  $querry->bindParam(':materials', $materials, PDO::PARAM_STR);
                        $querry->execute();
                        $rows = $querry->fetchAll(PDO::FETCH_OBJ);
                        $count = $querry->rowCount();
                        if($count > 0)
                        {
                          foreach($rows as $row) {
                            if($row->in_stock == 0){
                              $any_stock_out = 'True';
                            }
                            $m_expected_date[] = $row->m_expected_date;
                          }
                        }
                      }
                      if($stock_status != 0){?>
                          <td style="background-color: #34b08b; color: #fff"> processed </td>
                    <?php  }
                    else if($stock_status == 0 AND $any_stock_out == 'False'){?>
                        <td style="background-color: #34b08b; color: #fff"> in stock </td>
                  <?php  }
                      else if($any_stock_out == 'True' AND !empty($m_expected_date)){?>
                        <td style="background-color: #fea349; color: #000">
                          Expected<br>
                          <strong> <?php echo(max($m_expected_date));?> </strong></td>
                    <?php  }
                      else{?>
                        <td style="background-color: #e9004e; color: #fff;">not available</td>
                    <?php  }

                      //production section
                      if($stock_status != 0){?>
                          <td style="background-color: #34b08b; color: #fff"> Done </td>
                    <?php  }
                    else if($stock_status == 0 AND $make_status == 0){?>
                      <td> <a href="sellsorders.php?make_id=<?php echo $order_id ?>"><i class="fa fa-plus-square"></i> Make</a></td>
                <?php  }
                else if($stock_status == 0 AND $make_status == 1){?>
                  <td style="background-color: #bfbfbf; color:#000"> Not started</td>
            <?php  }
                else{ ?>
                  <td style="background-color: #34b08b; color: #fff"> Not started </td>
            <?php  } ?>
                    <td class="delivery-background"><select class="form-select delivery-background" name="delivery_status">
                      <option value="">Not shipped</option>
                      <option value="1">Delivered</option>
                    </select></td>
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
