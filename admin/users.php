<?php
session_start();
include('includes/header.php');
include('includes/navbar.php');
include('includes/topbar.php');
?>
<style type="text/css">
  .btn-save{
    margin-left: 5%;
  }

</style>

<div class="modal fade" id="addadminprofile" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="code.php" method="POST">

        <div class="modal-body">

            <div class="form-group">
                <label> Username </label>
                <input type="text" name="username" class="form-control" placeholder="Enter Username">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter Email">
            </div>
            <div class="form-group">
                <label> Phone </label>
                <input type="text" name="phone" class="form-control" placeholder="Enter Phone">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter Password">
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirmpassword" class="form-control" placeholder="Confirm Password">
            </div>
            <div>
            <select class="form-select" name="position">
            <option selected>Select User Role</option>
            <option value="Admin">Admin</option>
            <option value="Expert">Expert</option>

            </select>
            </div>


        </div>
        <div class="modal-footer">
          <div class="btn-save" align="left">
           <button type="submit" name="registerbtn" class="btn btn-success">Save</button>
           </div>
            <div align="right">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
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
    <h6 class="m-0 font-weight-bold text-success">Users
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addadminprofile">
              Create User
            </button>
    </h6>
  </div>

  <div class="card-body">
    <?php
    if (isset($_SESSION['success']) && $_SESSION['success']!=''){

      echo '<h2> '.$_SESSION['success'].' </h2>';
      unset($_SESSION['success']);

    }
     ?>

    <div class="table-responsive">

      <?php
      $connection= mysqli_connect("localhost","root","","pms");

      # inner join statement to fetch data from two database tables (Users and user roles) and merge them into one table of users
      $query="SELECT Users.user_name, Users.email, Users.role, user_roles.user_role FROM Users INNER JOIN user_roles ON Users.role = user_roles.user_id";
      $query_run= mysqli_query($connection, $query);

      ?>

      <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

     <thead>
    <tr>
            <th>ID </th>
            <th>Username </th>
            <th>Email </th>
             <th>Role </th>
            <th colspan="2">Action </th>
          </tr>
        </thead>
        <tbody>


          <?php
          if(mysqli_num_rows($query_run) > 0){
            $cnt = 1;
            while ($row= mysqli_fetch_assoc($query_run)) {

              ?>




          <tr>
            <td> <?php echo $cnt; ?> </td>
            <td> <?php echo $row['user_name']; ?></td>
           <td> <?php echo $row['email']; ?></td>
           <td> <?php echo $row['user_role']; ?></td>
            <td>
             <a href="index.php?pid=<?php echo(1);?>"  onclick="return confirm('Edit User?')">Edit</a>
            </td>
            <td>
                <a style="color: red" href="index.php?pid=<?php echo(1);?>" onclick="return confirm('Delete User?')">Delete</a>
            </td>
          </tr>
           <?php
          $cnt++;  }

          }
          else{

            echo "Sorry No Record Was Found!";
          }



          ?>


        </tbody>
      </table>

    </div>
  </div>
</div>

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>
    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>
