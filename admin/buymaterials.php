<?php
session_start();
include('../includes/config.php');

if (empty($_SESSION['user_id'])){
  header('Location: ../index.php');
}
else if(isset($_GET['r_id'])){
  $material_id = intval($_GET['r_id']);

  $sql = "SELECT tbl_buy_materials.*, tbl_stock_material.in_stock FROM tbl_buy_materials
  INNER JOIN tbl_stock_material ON tbl_buy_materials.material_id = tbl_stock_material.material_name WHERE tbl_buy_materials.id = :material_id";

  $querry=$dbconn->prepare($sql);
  $querry->bindParam(':material_id', $material_id, PDO::PARAM_INT);
  $querry->execute();
  $results = $querry->fetchAll(PDO::FETCH_OBJ);
  $count = $querry->rowCount();
  if($count > 0)
      {

        foreach ($results as $result) {
          // code...
          $mat_quantity = $result->buy_quantity + $result->in_stock;
          $material = $result->material_id;
          $mat_id = $result->id;

          $sql = "UPDATE `tbl_stock_material` SET in_stock = :mat_quantity WHERE material_name = :material";
          $query = $dbconn -> prepare($sql);
          $query->bindParam(':mat_quantity',$mat_quantity, PDO::PARAM_INT);
          $query->bindParam(':material',$material, PDO::PARAM_INT);
          $query->execute();
          $count =$query->rowCount();
          if($count > 0){
            echo ("<script>alert('material successfully received')</script>");

            $sql = "UPDATE `tbl_buy_materials` SET status = 1 WHERE id = :mat_id";
            $query = $dbconn -> prepare($sql);
            $query->bindParam(':mat_id', $mat_id, PDO::PARAM_INT);
            $query->execute();

            echo ('<script>window.location.href = "buymaterials.php";</script>');
          }
          else{
            echo ("<script>alert('something went wrong')</script>");
          }
        }
      }
      else{
        echo ("<script>alert('something went wrong')</script>");
        echo ('<script>window.location.href = "buymaterials.php";</script>');
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

  <!-- buy material section -->
  <div class="modal fade" id="buymaterial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <img src="../assets/img/logo/logo.png" style="height:30px"><h5 class="modal-title" id="exampleModalLabel">&nbsp | Order details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form  method="POST">

          <div class="modal-body">

            <div class="form-group">
              <!-- <label>Email</label> -->
              <input type="text" id="material_id"  name="material_id" class="form-control" value="yes" hidden=True required>
            </div>
            <div class="form-group">
              <label class="tiny-font">material</label>
              <strong><p class="form-select" id="material_name">material name</p></strong>
            </div>
            <div class="row">
              <div class="col-lg-6 form-group">
                <label class="tiny-font">Quantity</label>
                <input type="number" id="quantity"  name="quantity" class="form-select" value="" readonly/>
              </div>
              <div class="col-lg-5 form-group">
                <label class="tiny-font">Excess in stock</label>
                <strong><p class="form-select" id="in_stock">0.0</p></strong>
              </div>
            </div>
          </div>

        </form>

      </div>
    </div>
  </div>

  <!-- end of buy material section -->

  <div class="nav1">
    <ul>
      <li><a href="buymaterials.php" class="active1" style="color:#FFFFFF;  background: #1cc88a;">Open</a></li>
      <li>|</li>
      <li><a href="receivedmaterials.php">Received Materials</a></li>
    </ul>

  </div>


  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-success">All</h6>
    </div>
    <div class="table-responsive">
      <?php
      $sql = "SELECT tbl_buy_materials.*, tbl_materials.material_name, tbl_materials.purchase_price, tbl_stock_material.in_stock FROM tbl_buy_materials INNER JOIN tbl_materials ON tbl_buy_materials.material_id = tbl_materials.id INNER JOIN tbl_stock_material ON tbl_buy_materials.material_id = tbl_stock_material.material_name WHERE tbl_buy_materials.status = 0";
      $querry=$dbconn->prepare($sql);
      $querry->execute();
      $rows = $querry->fetchAll(PDO::FETCH_OBJ);
      $count = $querry->rowCount();
      $cnt = 1;?>
      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

        <thead>
          <tr>
            <th>Order #</th>
            <th>material</th>
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
                <td><a onclick="modalFunction('<?php echo($row->material_name);?>', '<?php echo($row->buy_quantity);?>', '<?php echo($row->in_stock);?>')" href="#" class="prod" style="color: #1cc88a;"><?php echo htmlentities("PO-".$row->id);?></a></td>
                <td><?php echo htmlentities($row->material_name);?></td>
                <td><?php echo htmlentities(number_format($row->buy_quantity * $row->purchase_price));?></td>
                <td><?php echo htmlentities($row->arrival_date);?></td>

                <td><a onclick="return confirm('mark as received?')" href="buymaterials.php?r_id=<?php echo($row->id);?>">Mark as received</a></td>
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
  <script>
  function modalFunction(material_name, material_quantity, in_stock){
    $("#buymaterial").modal('show');
    $("#in_stock").html(in_stock);
    document.getElementById("quantity").value = material_quantity;
    $("#material_name").html(material_name);
  };

  </script>
