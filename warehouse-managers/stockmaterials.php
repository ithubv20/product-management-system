<?php
session_start();
include('../includes/config.php');

if (empty($_SESSION['user_id'])){
  header('Location: ../index.php');
}

// start of buy material code
if(isset($_POST['buy_materials'])){
  $material_id = $_POST['material_id'];
  $material_quantity = $_POST['quantity'];
  $arrival_date = $_POST['arrival_date'];

  $sql = "INSERT INTO `tbl_buy_materials`(material_id, buy_quantity, arrival_date) VALUES(:material_id, :material_quantity, :arrival_date)";
  $query = $dbconn->prepare($sql);
  $query->bindParam(':material_id', $material_id, PDO::PARAM_STR);
  $query->bindParam(':material_quantity', $material_quantity, PDO::PARAM_STR);
  $query->bindParam(':arrival_date', $arrival_date, PDO::PARAM_STR);
  $query->execute();
  $lastInsertId = $dbconn->lastInsertId();
  if($lastInsertId){
    echo ('<script>alert("A new material purchase has been established")</script>');
    echo ('<script>window.location.href = "stockmaterials.php";</script>');
  }
  else {
    echo ('<script>alert("Sorry, there was an error in adding a supplier.")</script>');
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
          <img src="../assets/img/logo/logo.png" style="height:30px"><h5 class="modal-title" id="exampleModalLabel">&nbsp | New purchase order</h5>
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
                <input type="number" id="quantity"  name="quantity" class="form-select" required>
              </div>
              <div class="col-lg-5 form-group">
                <label class="tiny-font">Excess in stock</label>
                <strong><p class="form-select" id="in_stock">0.0</p></strong>
              </div>

              <div class="col-lg-6 form-group">
                <label class="tiny-font">Supplier</label>
                <strong><p class="form-select" id="supplier_name">supplier name</p></strong>
              </div>

              <div class="col-lg-5 form-group">
                <label class="tiny-font">Expected arrival</label>
                  <?php
                  $sql = "SELECT delivery_time FROM tbl_general_settings";
                  $querry=$dbconn->prepare($sql);
                  $querry->execute();
                  $rows = $querry->fetchAll(PDO::FETCH_OBJ);
                  $count = $querry->rowCount();
                  if($count > 0)
                  {
                    foreach($rows as $row) {
                      $date = date("Y-m-d");
                      //increment days
                      $mod_date = strtotime($date."+".$row->delivery_time."days"); ?>
                      <strong><input type="text" class="form-select" name="arrival_date" value="<?php echo date("Y-m-d",$mod_date);?>" readonly/></strong>
                  <?php  }
                  }?>

              </div>

              <div class="col form-group">
                <button type="submit" id="add_customer" name="buy_materials" class="btn btn-success form-control">Create and open order</button>
              </div>
            </div>
            <div class="modal-footer">
              <span id="user-availability-status" style="font-size:12px;"></span>
            </div>
          </div>

        </form>

      </div>
    </div>
  </div>

  <!-- end of buy material section -->


  <div class="nav1">
    <ul>
      <li><a href="stock.php" >Products</a></li>
      <li>|</li>
      <li><a href="stockmaterials.php"  class="active1" style="color:#FFFFFF;  background: #1cc88a;">Materials</a></li>
    </ul>

  </div>


  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-success">Materials in Stock</h6>
    </div>
    <div class="table-responsive">
      <?php
      $sql = "SELECT tbl_materials.id, tbl_stock_material.in_stock, tbl_materials.material_name, tbl_materials.material_code, tbl_categories.category_description, tbl_suppliers.supplier_name
      FROM tbl_stock_material INNER JOIN tbl_materials ON tbl_stock_material.material_name = tbl_materials.id
      INNER JOIN tbl_categories ON tbl_stock_material.material_category = tbl_categories.id
      INNER JOIN tbl_suppliers ON tbl_stock_material.material_supplier = tbl_suppliers.id";

      $querry=$dbconn->prepare($sql);
      $querry->execute();
      $rows = $querry->fetchAll(PDO::FETCH_OBJ);
      $count = $querry->rowCount();
      $cnt = 1;?>

      <table class="table table-bordered" id="dataTable" width="120%" cellspacing="0">

        <thead>
          <tr>
            <th>Name</th>
            <th>Variant Code</th>
            <th>Category</th>
            <th>Supplier</th>
            <th>In Stock</th>
            <th>Action</th>

          </tr>
        </thead>
        <tbody>
          <?php if($count > 0)
          {
            foreach($rows as $row) {
              ?>
              <tr>
                <td><?php echo htmlentities($row->material_name);?></td>
                <td><?php echo htmlentities($row->material_code);?></td>
                <td><?php echo htmlentities($row->category_description);?></td>
                <td><?php echo htmlentities($row->supplier_name);?></td>
                <td><?php echo htmlentities($row->in_stock);?></td>              <td>
                <a onclick="modalFunction(<?php echo($row->id);?>, '<?php echo($row->in_stock);?>', '<?php echo($row->material_name);?>', '<?php echo htmlentities($row->supplier_name);?>');" href="#" class="tiny-font"> <i class="fa fa-plus-square" aria-hidden="true"></i> Buy</a>
              </td>
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
function modalFunction(material_id, in_stock, material_name, supplier_name){
  $("#buymaterial").modal('show');
  document.getElementById("material_id").value = material_id;
  $("#in_stock").html(in_stock);
  $("#material_name").html(material_name);
  document.getElementById("supplier_name").innerHTML = supplier_name;
};

</script>
