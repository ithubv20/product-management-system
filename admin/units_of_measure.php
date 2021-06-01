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
                <strong><p>Units of Measure</p></strong>
                <form method='POST'>
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                          <tr>
                            <td class="w-75"> name </td>
                            <td> average</td>
                      </tbody>
                    </table>
                  <div class="form-group">
                    <button type="submit" id="save_settings" name="save_settings" class="btn btn-success form-control">Save Settings</button>
                  </div>
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
    include('includes/scripts.php');
    include('includes/footer.php');

  }?>

</div>
