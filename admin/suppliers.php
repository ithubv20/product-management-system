<?php
session_start();
include('../includes/config.php');

if (empty($_SESSION['user_id'])){
  header('Location: ../index.php');
}

// start of add supplier code
if(isset($_POST['add_supplier'])){
  $supplier_name = $_POST['supplier_name'];
  $supplier_email = $_POST['supplier_email'];
  $admin_comment = $_POST['admin_comment'];

  $sql = "INSERT INTO `tbl_suppliers`(supplier_name, supplier_email, admin_comment) VALUES(:supplier_name, :supplier_email, :admin_comment)";
  $query = $dbconn->prepare($sql);
  $query->bindParam(':supplier_name', $supplier_name, PDO::PARAM_STR);
  $query->bindParam(':supplier_email', $supplier_email, PDO::PARAM_STR);
  $query->bindParam(':admin_comment', $admin_comment, PDO::PARAM_STR);
  $query->execute();
  $lastInsertId = $dbconn->lastInsertId();
  if($lastInsertId){
    echo ('<script>alert("A new supplier has been added successfully.")</script>');
    echo ('<script>window.location.href = "suppliers.php";</script>');
  }
  else {
    echo ('<script>alert("Sorry, there was an error in adding a supplier.")</script>');
  }
}

if(isset($_GET['sid'])){
      $sid=intval($_GET['sid']);
      $sql = "DELETE FROM `tbl_suppliers` WHERE id = :sid";
      $query = $dbconn -> prepare($sql);
      $query->bindParam(':sid',$sid, PDO::PARAM_INT);
      $query->execute();
      $count =$query->rowCount();
      if($count > 0){
        echo ("<script>alert('This supplier has been deleted successfully')</script>");
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

  <div class="modal fade" id="addnewsupplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <img src="../assets/img/logo/logo.png" style="height:30px"><h5 class="modal-title" id="exampleModalLabel">&nbsp | Add New Supplier</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form  method="POST">

          <div class="modal-body">

            <div class="form-group">
              <!-- <label> customer name </label> -->
              <input type="text" name="supplier_name" class="form-control" placeholder="supplier name" required>
            </div>
            <div class="form-group">
              <!-- <label>Email</label> -->
              <input type="email" id="emailid"  onBlur="checkAvailability()" name="supplier_email" class="form-control" placeholder="supplier email" required>
            </div>
            <div class="form-group">
              <label>comment(optional)</label>
              <textarea name="admin_comment" class="form-control"></textarea>
            </div>
        <div class="form-group">
          <button type="submit" id="add_supplier" name="add_supplier" class="btn btn-success form-control">Add Supplier</button>
        </div>
        <div class="modal-footer">
          <span id="user-availability-status" style="font-size:12px;"></span>
        </div>
      </div>

    </form>

  </div>
  </div>
  </div>

  <!-- end of add new user modal -->

  <div class="nav1">
    <ul>
      <li><a href="customers.php" >Customers</a></li>
      <li>|</li>
      <li><a href="suppliers.php" class="active1" style="color:#FFFFFF;  background: #1cc88a;">Suppliers</a></li>
    </ul>

  </div>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="row mb-12">
        <div class="col mb-7 font-weight-bold text-success"
        <h6 class="m-0">All Suppliers</h6>
      </div>
      <div align="right" class="col">
        <a href="#" data-toggle="modal" data-target="#addnewsupplier">
          + Add a new supplier
        </a>
      </div>
    </div>
  </div>
  <div class="table-responsive">
    <?php
    $sql = "SELECT * FROM tbl_suppliers";
    $querry=$dbconn->prepare($sql);
    $querry->execute();
    $rows = $querry->fetchAll(PDO::FETCH_OBJ);
    $count = $querry->rowCount();
    ?>
    <table class="table table-bordered" id="dataTable" width="120%" cellspacing="0">

      <thead>
        <tr>
          <th>Name</th>
          <th>Email address</th>
          <th>Comment</th>
          <th>Action</th>

        </tr>
      </thead>
      <tbody>
        <?php if($count > 0)
        {
          foreach($rows as $row) {
            ?>
            <tr>
              <td><?php echo htmlentities($row->supplier_name);?></a></td>
              <td><?php echo htmlentities($row->supplier_email);?></td>
              <td><?php echo htmlentities($row->admin_comment);?></td>
              <td><a style="color: red" href="suppliers.php?sid=<?php echo htmlentities($row->id);?>" onclick="return confirm('Delete Supplier?')">Delete</a></td>

          </tr>
        <?php }}?>
      </tbody>
    </table>

  </div>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');

}?>
<!-- Page level custom scripts -->
<script src="js/demo/datatables-demo.js"></script>
