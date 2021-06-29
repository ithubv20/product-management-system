<?php
session_start();
include('../includes/config.php');

if (empty($_SESSION['user_id'])){
  header('Location: ../index.php');
}

//start of user registration code
if(isset($_POST['save_info'])){
  $resource_name = $_POST['resource_name'];
  $amount_per_hour = $_POST['amount_per_hour'];

  $sql ="INSERT INTO `tbl_resources`(resource_description, resource_amount_per_hour) VALUES(:resource_name, :amount_per_hour)";
  $query = $dbconn->prepare($sql);
  $query->bindParam(':resource_name', $resource_name, PDO::PARAM_STR);
  $query->bindParam(':amount_per_hour', $amount_per_hour, PDO::PARAM_STR);
  $query->execute();
  $lastInsertId = $dbconn->lastInsertId();
  if($lastInsertId){
    echo ('<script>alert("ane resource has been added successfully.")</script>');
    echo ('<script>window.location.href = "resources.php";</script>');
  }
  else {
    echo ('<script>alert("Somethin went wrong.")</script>');
    echo ('<script>window.location.href = "resources.php";</script>');
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
                      <?php
                      $sql = "SELECT * FROM tbl_resources";
                      $query = $dbconn->prepare($sql);
                      $query->execute();
                      $rows = $query->fetchAll(PDO::FETCH_OBJ);
                      $count = $query->rowCount($rows);
                      if($count > 0){
                        foreach ($rows as $row) {
                          ?>
                      <tr>
                        <th ><?php echo($row->resource_description);?> </th>
                        <th ><?php echo($row->resource_amount_per_hour);?></th>
                      </tr>
                        <?php } } ?>
                          <tr id="add_unit_of_measure" hidden>
                            <td> <input type="text" name="resource_name" class="form-control" placeholder="resource name" required/>
                              <input type="number" name="amount_per_hour" class="form-control" placeholder="amount per hour" required/> </td>
                                <td><input type="submit" name="save_info" class="btn btn-success"/></td>
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
