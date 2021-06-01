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

  <!-- Begin Page Content -->
  <div class="container-fluid">
    <div class="row">
      <div class="col-xl-2 col-md-2 mb-2">
      </div>
      <div class="col-xl-8 col-md-8 mb-8">
        <div class="card shadow">
          <div class="row no-gutters">
            <div class="col-md-3 bg-gradient-success">
              <?php include('settings/navbar.php') ?>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <strong><p>Resources</p></strong>
                <form method='POST'>
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th class="w-50">Name </th>
                        <th>Default cost per hour</th>
                      </tr>
                    </thead>
                    <tbody>
                          <tr>
                            <td> John </td>
                            <td>20000</td>
                          </tr>
                          <tr>
                            <td> IT Dept </td>
                            <td>100000</td>
                          </tr>
                          <tr id="add_unit_of_measure" hidden>
                            <td> <input type="text" name="input_of_measure" class="form-control" placeholder="resource name" required/> </td>
                              <td><input type="number" name="input_of_measure" class="form-control" placeholder="amount per hour" required/> </td>
                          </tr>
                      </tbody>
                    </table>
                  <a href="#" onclick="myFunction()"> + add new resource</a>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer">
    <?php
    include('includes/hide_and_show.js');
    include('includes/scripts.php');
    include('includes/footer.php');

  }?>

</div>
