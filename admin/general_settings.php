<?php
session_start();
include('../../includes/config.php');

if (empty($_SESSION['user_id'])){
  header('Location: ../../index.php');
}
else{
  include('../includes/header.php');
  include('../includes/navbar.php');
  include('../includes/topbar.php');
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
              <?php include('navbar.php') ?>
            </div>
            <div class="col-md-8">
              <div class="card-body">
                <strong><p>General</p></strong>
                <form method='POST'>
                  <p class="tiny-font">The base currency used for all operations</p>
                  <select class="form-group form-select" name="r_currency">
                    <option value="1">MK</option>
                    <option value="2">USD</option>
                  </select>
                  <div class="form-group">
                    <label class="tiny-font"> Default delivery time for sales orders</label>
                    <input type="number" name="oder_days" class="form-control" placeholder="days" required>
                  </div>
                  <div class="form-group">
                    <label class="tiny-font"> Default lead time for purchase orders</label>
                    <input type="number" name="lead_time" class="form-control" placeholder="days" required>
                  </div>
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
    include('../includes/scripts.php');
    include('../includes/footer.php');

  }?>

</div>
