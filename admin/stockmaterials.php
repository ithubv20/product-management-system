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
      $sql = "SELECT tbl_stock_material.in_stock, tbl_stock_material.expected, tbl_stock_material.committed, tbl_materials.material_name, tbl_materials.material_code, tbl_categories.category_description, tbl_suppliers.supplier_name
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
            <th>Expected</th>
            <th>Committed</th>
            <th>Missing</th>
            <th>Action</th>

          </tr>
        </thead>
        <tbody>
          <?php if($count > 0)
              {
                foreach($rows as $row) {
                  ?>
          <tr>
            <td><a href="#" class="prod" style="color: #1cc88a;"><?php echo htmlentities($row->material_name);?></a></td>
            <td><?php echo htmlentities($row->material_code);?></td>
            <td><?php echo htmlentities($row->category_description);?></td>
            <td><?php echo htmlentities($row->supplier_name);?></td>
            <td><?php echo htmlentities($row->in_stock);?></td>
            <td><?php echo htmlentities($row->expected);?></td>
            <td><?php echo htmlentities($row->committed);?></td>
            <td><?php $missing = ($row->in_stock + $row->expected) - $row->committed;
                 if($missing < 0){?>
                   <div style="color:#f40717"><?php echo htmlentities($missing);?></div>
                 <?php }
                 else
                    echo htmlentities(0); ?>
                   </td>
            <td>
            <a href="#" class="tiny-font"> <i class="fa fa-plus-square" aria-hidden="true"></i> Buy</a>
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
