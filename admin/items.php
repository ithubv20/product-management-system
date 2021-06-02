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
      <li><a href="items.php" class="active1" style="color:#FFFFFF;  background: #1cc88a;" >Products</a></li>
      <li>|</li>
      <li><a href="materials.php">Materials</a></li>
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
        <a href="#"  data-toggle="modal" data-target="#addnewitem">
          + Add a new item
        </a>
      </div>
    </div>
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
  <!-- modal-->
  <div class="modal fade" id="addnewitem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <img src="../assets/img/logo/logo.png" style="height:30px"><h5 class="modal-title" id="exampleModalLabel">&nbsp | Add New Item</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="users.php" method="POST">

          <div class="modal-body">

            <div class="form-group">
              <!-- <label> Username </label> -->
              <input type="text" name="item_name" class="form-control" placeholder="item name" required>
            </div>
            <div class="form-group">
              <!-- <label>Email</label> -->
              <input type="text" name="item_code" class="form-control" placeholder="item code" required>
            </div>
            <div class="form-group">
              <!-- <label>Email</label> -->
              <input type="number" name="item_default_selling_price" class="form-control" placeholder="default selling price" required>
            </div>
        <div>
          <select class="form-group form-select" name="item_category">
            <option selected>Select item category</option>
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
          <div class="form-group">Required materials</div>
          <div class="form-group">
            <div class="row mb-12">
            <?php
            $sql ="SELECT * FROM tbl_materials";
            $query= $dbconn -> prepare($sql);
            $query-> execute();
            $results = $query -> fetchAll(PDO::FETCH_OBJ);
            $cnt=1;
            if($query -> rowCount() > 0)
            {
              foreach ($results as $result) {
                // below code fetches data in the user_roles tables
                ?>
            <div class="col mb-7">
            <input type="checkbox" id="material" name="required_materials" value="<?php echo htmlentities($result->id);?>"/>
            <label for="material"><?php echo htmlentities($result->material_name); ?></label>
          </div>
          <?php }}?>
        </div>
          </div>
          <div class="form-group">
            <label> Total Cost</label>
            <input type="text" id="item_cost" class="form-control" name="item_cost" readonly>
          </div>
        </div>
        <div class="form-group">
          <button type="submit" name="create_item" class="btn btn-success form-control">Add an Item</button>
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
