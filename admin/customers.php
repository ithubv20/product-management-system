<?php
session_start();
include('../includes/config.php');

if (empty($_SESSION['user_id'])){
  header('Location: ../index.php');
}

// start of user registration code
if(isset($_POST['add_customer'])){
  $customer_name = $_POST['customer_name'];
  $customer_email = $_POST['customer_email'];
  $customer_phone_number = $_POST['customer_phone_number'];
  $admin_comment = $_POST['admin_comment'];

  $sql = "INSERT INTO `tbl_customer`(cus_name, cus_email, phone_number, admin_comment) VALUES(:customer_name, :customer_email, :customer_phone_number, :admin_comment)";
  $query = $dbconn->prepare($sql);
  $query->bindParam(':customer_name', $customer_name, PDO::PARAM_STR);
  $query->bindParam(':customer_email', $customer_email, PDO::PARAM_STR);
  $query->bindParam(':customer_phone_number', $customer_phone_number, PDO::PARAM_STR);
  $query->bindParam(':admin_comment', $admin_comment, PDO::PARAM_STR);
  $query->execute();
  $lastInsertId = $dbconn->lastInsertId();
  if($lastInsertId){
    echo ('<script>alert("A new customer has been added successfully.")</script>');
    echo ('<script>window.location.href = "customers.php";</script>');
  }
  else {
    echo ('<script>alert("Sorry, there was an error in adding a new customer.")</script>');
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

  <div class="modal fade" id="addnewcustomer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <img src="../assets/img/logo/logo.png" style="height:30px"><h5 class="modal-title" id="exampleModalLabel">&nbsp | Add New Customer</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form  method="POST">

          <div class="modal-body">

            <div class="form-group">
              <!-- <label> customer name </label> -->
              <input type="text" name="customer_name" class="form-control" placeholder="Enter Customer Name" required>
            </div>
            <div class="form-group">
              <!-- <label>Email</label> -->
              <input type="email" id="emailid"  onBlur="checkAvailability()" name="customer_email" class="form-control" placeholder="Enter Email" required>
            </div>
            <div class="form-group">
              <!-- <label>phone number</label> -->
              <input type="number" id="phone_num" name="customer_phone_number" class="form-control" placeholder="Enter phone number" required>
            </div>
            <div class="form-group">
            <label>comment(optional)</label> 
              <textarea name="admin_comment" class="form-control"></textarea>
            </div>
        <div class="form-group">
          <button type="submit" id="add_customer" name="add_customer" class="btn btn-success form-control">Add Customer</button>
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
      <li><a href="customers.php" class="active1" style="color:#FFFFFF;  background: #1cc88a;" >Customers</a></li>
      <li>|</li>
      <li><a href="suppliers.php">Suppliers</a></li>
    </ul>

  </div>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="row mb-12">
        <div class="col mb-7 font-weight-bold text-success"
        <h6 class="m-0">All customers</h6>
      </div>
      <div align="right" class="col">
        <a href="#" data-toggle="modal" data-target="#addnewcustomer">
          + Add a new customer
        </a>
      </div>
    </div>
  </div>
  <div class="table-responsive">
    <?php
    $sql = "SELECT * FROM tbl_customer";
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
          <th>Phone number</th>
          <th>Comment</th>

        </tr>
      </thead>
      <tbody>
        <?php if($count > 0)
        {
          foreach($rows as $row) {
            ?>
            <tr>
              <td><?php echo htmlentities($row->cus_name);?></a></td>
              <td><?php echo htmlentities($row->cus_email);?></td>
              <td><?php echo htmlentities($row->phone_number);?></td>
              <td><?php echo htmlentities($row->admin_comment);?></td>

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
