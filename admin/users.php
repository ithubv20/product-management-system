<?php
session_start();
require_once('../includes/config.php');
if (empty($_SESSION['user_id'])){
  header('Location: ../index.php');
}
// start of user registration code
if(isset($_POST['reg_user'])){
  $staff_full_name = $_POST['staff_full_name'];
  // extracting the first name to the fullname and make it user name
  $get_user_name = explode(" ", $staff_full_name);
  $staff_username = $get_user_name[0];

  $staff_password = md5(strtolower($staff_username)); // making the username a default password and hash it using md5 hash algorithm
  $staff_email = $_POST['staff_email'];
  $staff_role = $_POST['staff_role'];

  $sql = "INSERT INTO `users`(full_name, user_name, user_password, email, role) VALUES(:staff_full_name, :staff_username, :staff_password, :staff_email, :staff_role)";
  $query = $dbconn->prepare($sql);
  $query->bindParam(':staff_full_name', $staff_full_name, PDO::PARAM_STR);
  $query->bindParam(':staff_username', $staff_username, PDO::PARAM_STR);
  $query->bindParam(':staff_password', $staff_password, PDO::PARAM_STR);
  $query->bindParam(':staff_email', $staff_email, PDO::PARAM_STR);
  $query->bindParam(':staff_role', $staff_role, PDO::PARAM_STR);
  $query->execute();
  $lastInsertId = $dbconn->lastInsertId();
  if($lastInsertId){
    echo ('<script>alert("A new staff has been added successfully.")</script>');
  }
  else {
    echo ('<script>alert("Sorry, there was an error in adding a new staff.")</script>');
  }
}
if(isset($_GET['arch_id'])){
  $arch_id = intval($_GET['arch_id']);
  $sql = "UPDATE `users` SET user_status = 1 WHERE user_id = :arch_id";
  $query = $dbconn -> prepare($sql);
  $query->bindParam(':arch_id', $arch_id, PDO::PARAM_INT);
  $query->execute();
  $count =$query->rowCount();
  if($count > 0){
    echo ("<script>alert('staff archived successfully')</script>");
    echo ('<script>window.location.href = "users.php";</script>');
  }
  else{
    echo ("<script>alert('something went wrong')</script>");
  }
}

if(isset($_GET['activate_user'])){
  $activate_user = intval($_GET['activate_user']);
  $sql = "UPDATE `users` SET user_status = 0 WHERE user_id = :activate_user";
  $query = $dbconn -> prepare($sql);
  $query->bindParam(':activate_user', $activate_user, PDO::PARAM_INT);
  $query->execute();
  $count =$query->rowCount();
  if($count > 0){
    echo ("<script>alert('staff activated successfully')</script>");
    echo ('<script>window.location.href = "users.php";</script>');
  }
  else{
    echo ("<script>alert('something went wrong')</script>");
  }
}

if(isset($_GET['make_admin'])){
  $make_admin = intval($_GET['make_admin']);
  $sql = "UPDATE `users` SET role = 1 WHERE user_id = :make_admin";
  $query = $dbconn -> prepare($sql);
  $query->bindParam(':make_admin', $make_admin, PDO::PARAM_INT);
  $query->execute();
  $count =$query->rowCount();
  if($count > 0){
    echo ("<script>alert('staff role updated successfully')</script>");
    echo ('<script>window.location.href = "users.php";</script>');
  }
  else{
    echo ("<script>alert('something went wrong')</script>");
  }
}
// --- end of user registration code ---

include('includes/header.php');
include('includes/navbar.php');
include('includes/topbar.php');
?>
<style type="text/css">
.btn-save{
  margin-left: 5%;
}

</style>
<script>
function checkAvailability() {
  $("#loaderIcon").show();
  jQuery.ajax({
    url: "check_availability.php",
    data:'emailid='+$("#emailid").val(),
    type: "POST",
    success:function(data){
      $("#user-availability-status").html(data);
      $("#loaderIcon").hide();
    },
    error:function (){}
  });
}
</script>
<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <img src="../assets/img/logo/logo.png" style="height:30px"><h5 class="modal-title" id="exampleModalLabel">&nbsp | Create User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="users.php" method="POST">

        <div class="modal-body">

          <div class="form-group">
            <!-- <label> Username </label> -->
            <input type="text" name="staff_full_name" class="form-control" placeholder="Enter Full Staff Name" required>
          </div>
          <div class="form-group">
            <!-- <label>Email</label> -->
            <input type="email" id="emailid"  onBlur="checkAvailability()" name="staff_email" class="form-control" placeholder="Enter Email" required>
          </div>
      <div>
        <select class="form-select" name="staff_role">
          <option selected>Select User Role</option>
          <?php
          $sql ="SELECT * FROM user_roles";
          $query= $dbconn -> prepare($sql);
          $query-> execute();
          $results = $query -> fetchAll(PDO::FETCH_OBJ);
          $cnt=1;
          if($query -> rowCount() > 0)
          {
            foreach ($results as $result) {
              // below code fetches data in the user_roles tables
              ?>
              <option value="<?php echo htmlentities($result->user_id) ?>"> <?php echo htmlentities($result->user_role) ?> </option>
            <?php  }

          } ?>
        </select>
        <br><br>
      </div>
      <div class="form-group">
        <button type="submit" id="reg_user" name="reg_user" class="btn btn-success form-control">Register User</button>
      </div>
      <div class="modal-footer">
        <span id="user-availability-status" style="font-size:12px;"></span>
      </div>
    </div>

  </form>

</div>
</div>
</div>

<div class="container-fluid">

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="row mb-12">
        <div class="col mb-7"
        <h6 class="m-0 font-weight-bold text-success">Users
        </h6>
      </div>
      <div align="right" class="col">
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addadminprofile">
          Create User
        </button>
      </div>
    </div>
  </div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item">
      <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Active Users</a>
    </li>
    <li class="nav-item">
      <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Archived Users</a>
    </li>
  </ul>

  <div class="tab-content">
    <div class="tab-pane active" id="home" role="tabpanel" aria-labelledby="home-tab">
      <div class="card-body">
        <?php
        if (isset($_SESSION['success']) && $_SESSION['success']!=''){

          echo '<h2> '.$_SESSION['success'].' </h2>';
          unset($_SESSION['success']);

        }
        ?>

        <div class="table-responsive">

          <?php
          # inner join statement to fetch data from two database tables (Users and user roles) and merge them into one table of users
          $sql="SELECT Users.user_id, Users.full_name, Users.user_status, Users.user_name, Users.email, Users.role, user_roles.user_role FROM Users INNER JOIN user_roles ON Users.role = user_roles.user_id WHERE user_status = 0";
          $cnt = 1;
          $query = $dbconn -> prepare($sql);
          $query->execute();
          $rows = $query->fetchAll(PDO::FETCH_OBJ);
          $count = $query->rowCount();
          ?>

          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>ID </th>
                <th>Full name </th>
                <th>Username </th>
                <th>Email </th>
                <th>Role </th>
                <th>Action </th>
              </tr>
            </thead>
            <tbody>

              <?php
              if($count > 0){
                foreach ($rows as $row) {
                  ?>
                  <tr>
                    <td> <?php echo $cnt; ?> </td>
                    <td> <?php echo $row->full_name; ?></td>
                    <td> <?php echo $row->user_name; ?></td>
                    <td> <?php echo $row->email; ?></td>
                    <td> <?php echo $row->user_role; ?></td>
                    <td>
                      <?php
                      if($row->user_role == 'admin'){?>
                        <a style="color: red" href="users.php?arch_id=<?php echo($row->user_id);?>" onclick="return confirm('Send to archive?')">Send to Archive</a>
                    <?php  }
                    else{ ?>
                        <a style="color: red" href="users.php?arch_id=<?php echo($row->user_id);?>" onclick="return confirm('Send to archive?')">Send to Archive</a>&nbsp | &nbsp <a href="users.php?make_admin=<?php echo($row->user_id);?>"  onclick="return confirm('Make admin?')">Make admin</a>
                <?php    } ?>
                    </td>
                  </tr>
                  <?php
                  $cnt++;  }

                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
    </div>

    <div class="tab-pane" id="profile" role="tabpanel" aria-labelledby="profile-tab">
      <div class="card-body">
        <?php
        if (isset($_SESSION['success']) && $_SESSION['success']!=''){

          echo '<h2> '.$_SESSION['success'].' </h2>';
          unset($_SESSION['success']);

        }
        ?>

        <div class="table-responsive">

          <?php
          # inner join statement to fetch data from two database tables (Users and user roles) and merge them into one table of users
          $sql="SELECT Users.user_id, Users.full_name, Users.user_status, Users.user_name, Users.email, Users.role, user_roles.user_role FROM Users INNER JOIN user_roles ON Users.role = user_roles.user_id WHERE user_status = 1";
          $cnt = 1;
          $query = $dbconn -> prepare($sql);
          $query->execute();
          $rows = $query->fetchAll(PDO::FETCH_OBJ);
          $count = $query->rowCount();
          ?>

          <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>ID </th>
                <th>Full name </th>
                <th>Username </th>
                <th>Email </th>
                <th>Role </th>
                <th>Action </th>
              </tr>
            </thead>
            <tbody>

              <?php
              if($count > 0){
                foreach ($rows as $row) {
                  ?>
                  <tr>
                    <td> <?php echo $cnt; ?> </td>
                    <td> <?php echo $row->full_name; ?></td>
                    <td> <?php echo $row->user_name; ?></td>
                    <td> <?php echo $row->email; ?></td>
                    <td> <?php echo $row->user_role; ?></td>
                    <td><a  href="users.php?activate_user=<?php echo($row->user_id);?>" onclick="return confirm('Activate this user?')">Activate User</a>
                    </td>
                  </tr>
                  <?php
                  $cnt++;  }

                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
    </div>
  </div>

  </div>

  <?php
  include('includes/scripts.php');
  include('includes/footer.php');
  ?>
  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>
