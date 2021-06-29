<?php
session_start();
include('../includes/config.php');

if (empty($_SESSION['user_id'])){
  header('Location: ../index.php');
}
// start of material creation code
if(isset($_POST['create_material'])){
  $material_name = $_POST['material_name'];
  $material_code = $_POST['material_code'];
  $material_category = $_POST['material_category'];
  $material_supplier = $_POST['material_supplier'];
  $material_price = $_POST['material_price'];

  $sql = "INSERT INTO `tbl_materials`(material_name, material_code, category, default_supplier, purchase_price) VALUES(:material_name, :material_code, :material_category, :material_supplier, :material_price)";
  $query = $dbconn->prepare($sql);
  $query->bindParam(':material_name', $material_name, PDO::PARAM_STR);
  $query->bindParam(':material_code', $material_code, PDO::PARAM_STR);
  $query->bindParam(':material_category', $material_category, PDO::PARAM_STR);
  $query->bindParam(':material_supplier', $material_supplier, PDO::PARAM_STR);
  $query->bindParam(':material_price', $material_price, PDO::PARAM_STR);
  $query->execute();
  $lastInsertId = $dbconn->lastInsertId();
  if($lastInsertId){
    echo ('<script>alert("A new material has been added successfully.")</script>');
  }
  else {
    echo ('<script>alert("Sorry, there was an error in adding a new material.")</script>');
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
      <li><a href="items.php" >Products</a></li>
      <li>|</li>
      <li><a href="materials.php" class="active1" style="color:#FFFFFF;  background: #1cc88a;">Materials</a></li>
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
        <a href="#"  data-toggle="modal" data-target="#addnewmaterial">
          + Create a new material
        </a>
      </div>
    </div>
    </div>
    <div class="table-responsive">
      <?php
      $sql = "SELECT tbl_materials.material_name, tbl_materials.material_code, tbl_materials.default_supplier, tbl_materials.purchase_price, tbl_suppliers.supplier_name, tbl_categories.category_description FROM tbl_materials INNER JOIN tbl_suppliers ON tbl_materials.default_supplier = tbl_suppliers.id INNER JOIN tbl_categories ON tbl_materials.category = tbl_categories.id";
    	$querry=$dbconn->prepare($sql);
    	$querry->execute();
    	$rows = $querry->fetchAll(PDO::FETCH_OBJ);
    	$count = $querry->rowCount();
      ?>
      <table class="table table-bordered" id="dataTable" width="120%" cellspacing="0">

        <thead>
          <tr>
            <th>Material Name</th>
            <th>Variant Code</th>
            <th>Category</th>
            <th>Default Supplier</th>
            <th>Default Purchase Price</th>
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
            <td><?php echo htmlentities($row->purchase_price);?></td>
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
  <!-- modal-->
  <div class="modal fade" id="addnewmaterial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <img src="../assets/img/logo/logo.png" style="height:30px"><h5 class="modal-title" id="exampleModalLabel">&nbsp | Create New Material</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form  action="materials_processor.php" method="POST">

          <div class="modal-body">

            <div class="form-group">
              <!-- <label> Username </label> -->
              <input type="text" name="material_name" class="form-control" placeholder="material name" required>
            </div>
            <div class="form-group">
              <!-- <label>Email</label> -->
              <input type="text" name="material_code" class="form-control" placeholder="material code" required>
            </div>
        <div class="form-group">
          <select class="form-select" name="material_category">
            <option selected>select category</option>
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
        </div>
        <div class="form-group">
          <select class="form-select" name="material_supplier">
            <option selected>select supplier</option>
            <?php
            $sql ="SELECT * FROM tbl_suppliers";
            $query= $dbconn -> prepare($sql);
            $query-> execute();
            $results = $query -> fetchAll(PDO::FETCH_OBJ);
            $cnt=1;
            if($query -> rowCount() > 0)
            {
              foreach ($results as $result) {
                // below code fetches data in the user_roles tables
                ?>
                <option value="<?php echo htmlentities($result->id) ?>"> <?php echo htmlentities($result->supplier_name) ?> </option>
              <?php  }

            } ?>
          </select>
        </div>
        <div class="form-group">
          <!-- <label>Email</label> -->
          <input type="number" name="material_price" class="form-control" placeholder="default purchase price" required>
        </div>
        <div class="form-group">
          <button type="submit" id="reg_user" name="create_material" class="btn btn-success form-control">Create Material</button>
        </div>
        <div class="modal-footer">
          <span id="user-availability-status" style="font-size:12px;"></span>
        </div>
      </div>

    </form>

  </div>
  </div>
  </div>
  <?php
  include('includes/scripts.php');
  include('includes/footer.php');

}?>
<!-- Page level custom scripts -->
<script src="js/demo/datatables-demo.js"></script>
