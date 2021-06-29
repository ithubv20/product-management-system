<?php
session_start();
include('../includes/config.php');

if (empty($_SESSION['user_id'])){
  header('Location: ../index.php');
}

// start of delete unit of measure code
if(isset($_GET['del_tax'])){
  $del_tax = intval($_GET['del_tax']);

  $sql ="DELETE FROM `tbl_tax_rates` WHERE id=:del_tax";
  $query = $dbconn->prepare($sql);
  $query->bindParam(':del_tax', $del_tax, PDO::PARAM_STR);
  $query->execute();
  $count =$query->rowCount();
  if($count > 0){
    echo ('<script>alert("tax deleted successfully")</script>');
    echo ('<script>window.location.href = "tax_rates.php";</script>');
  }
  else {
    echo ('<script>alert("Somethin went wrong.")</script>');
    echo ('<script>window.location.href = "categories.php";</script>');
  }
}

if(isset($_POST['save_info'])){
  $new_tax_name = $_POST['new_tax_name'];
  $new_tax_desc = $_POST['new_tax_desc'];

  $sql ="INSERT INTO `tbl_tax_rates`(tax_rate, tax_description) VALUES(:new_tax_name, :new_tax_desc)";
  $query = $dbconn->prepare($sql);
  $query->bindParam(':new_tax_name', $new_tax_name, PDO::PARAM_STR);
  $query->bindParam(':new_tax_desc', $new_tax_desc, PDO::PARAM_STR);
  $query->execute();
  $lastInsertId = $dbconn->lastInsertId();
  if($lastInsertId){
    echo ('<script>alert("a new tax has been added successfully.")</script>');
    echo ('<script>window.location.href = "tax_rates.php";</script>');
  }
  else {
    echo ('<script>alert("Somethin went wrong.")</script>');
    echo ('<script>window.location.href = "tax_rates.php";</script>');
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
                <strong><p>Tax Rates</p></strong>
                <form method='POST'>
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                      <tr>
                        <th>Rate % </th>
                        <th>Tax Name </th>
                        <th>Action </th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      $sql = "SELECT * FROM tbl_tax_rates";
                      $query = $dbconn->prepare($sql);
                      $query->execute();
                      $rows = $query->fetchAll(PDO::FETCH_OBJ);
                      $count = $query->rowCount($rows);
                      if($count > 0){
                        foreach ($rows as $row) {
                          ?>
                          <tr>
                            <td> <?php echo($row->tax_rate);?> </td>
                            <td><?php echo($row->tax_description);?></td>
                            <td>  <a onclick="return confirm('delete tax?');" href="tax_rates.php?del_tax=<?php echo($row->id);?>"> <i class="fas fa-trash-alt"></i></a></td>
                          </tr>
                            <?php } } ?>
                          <tr id="add_unit_of_measure" hidden>
                            <td class="w-75"> <input type="number" name="new_tax_name" class="form-control" placeholder="enter tax amount" required/>
                            <input type="text" name="new_tax_desc" class="form-control" placeholder="enter tax description" required/> </td>
                              <td><input type="submit" name="save_info" class="btn btn-success"/></td>
                          </tr>
                      </tbody>
                    </table>
                  <a href="#" onclick="myFunction()"> + add another tax</a>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="footer">
    <script>
    function myFunction() {
    var add_measure = document.getElementById("add_unit_of_measure");
    if (add_measure.hidden === false) {
      add_measure.hidden = true
    } else {
      add_measure.hidden = false
    }
    }
    </script>
    <?php
    include('includes/scripts.php');
    include('includes/footer.php');

  }?>

</div>
