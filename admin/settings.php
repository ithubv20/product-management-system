<?php
session_start();
include('../includes/config.php');

if (empty($_SESSION['user_id'])){
  header('Location: ../index.php');
}

// start of user registration code
if(isset($_POST['save_settings'])){
  $r_currency = $_POST['r_currency'];
  $oder_days = $_POST['oder_days'];

  $sql ="UPDATE `tbl_general_settings` SET preferred_currency = :r_currency, delivery_time = :oder_days WHERE id=1";
  $query = $dbconn->prepare($sql);
  $query->bindParam(':r_currency', $r_currency, PDO::PARAM_STR);
  $query->bindParam(':oder_days', $oder_days, PDO::PARAM_STR);
  $query->execute();
  $count =$query->rowCount();
  if($count > 0){
    echo ('<script>alert("Setting updated successfully.")</script>');
    echo ('<script>window.location.href = "settings.php";</script>');
  }
  else {
    echo ('<script>alert("Somethin went wrong.")</script>');
  }
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
                <strong><p>General</p></strong>
                <form method='POST'>
                  <p class="tiny-font">The base currency used for all operations</p>
                  <select class="form-group form-select" name="r_currency">
                  <?php
                  $sql = "SELECT * FROM tbl_currency";
                  $query = $dbconn->prepare($sql);
                  $query->execute();
                  $rows = $query->fetchAll(PDO::FETCH_OBJ);
                  $count = $query->rowCount($rows);
                  if($count > 0){
                    foreach ($rows as $row) {
                      ?>
                        <option value="<?php echo($row->id);?>"><?php echo($row->cur_abbreviation);?></option>
                      <?php
                    }
                  }?>
                </select>
                  <div class="form-group">
                    <label class="tiny-font"> Default delivery time for sales orders</label>
                    <?php
                    $sql = "SELECT delivery_time FROM tbl_general_settings";
                    $query = $dbconn->prepare($sql);
                    $query->execute();
                    $rows = $query->fetchAll(PDO::FETCH_OBJ);
                    $count = $query->rowCount($rows);
                    if($count > 0){
                      foreach ($rows as $row) {
                        ?>
                    <input type="number" name="oder_days" class="form-control" value="<?php echo($row->delivery_time); ?>" required>
                  <?php } }?>
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
    include('includes/scripts.php');
    include('includes/footer.php');

  }?>

</div>
