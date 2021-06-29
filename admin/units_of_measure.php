<?php
session_start();
include('../includes/config.php');

if (empty($_SESSION['user_id'])){
  header('Location: ../index.php');
}
// start of delete unit of measure code
if(isset($_GET['del_unit'])){
  $del_unit = intval($_GET['del_unit']);

  $sql ="DELETE FROM `tbl_unit_of_measure` WHERE id=:del_unit";
  $query = $dbconn->prepare($sql);
  $query->bindParam(':del_unit', $del_unit, PDO::PARAM_STR);
  $query->execute();
  $count =$query->rowCount();
  if($count > 0){
    echo ('<script>alert("deleted successfully.")</script>');
    echo ('<script>window.location.href = "units_of_measure.php";</script>');
  }
  else {
    echo ('<script>alert("Somethin went wrong.")</script>');
  }
}
// start of user registration code
if(isset($_POST['save_info'])){
  $unit_of_measure = $_POST['unit_of_measure'];
  $unit_description = $_POST['unit_description'];

  $sql ="INSERT INTO `tbl_unit_of_measure`(unit, unit_description) VALUES(:unit_of_measure, :unit_description)";
  $query = $dbconn->prepare($sql);
  $query->bindParam(':unit_of_measure', $unit_of_measure, PDO::PARAM_STR);
  $query->bindParam(':unit_description', $unit_description, PDO::PARAM_STR);
  $query->execute();
  $lastInsertId = $dbconn->lastInsertId();
  if($lastInsertId){
    echo ('<script>alert("new unit added successfully.")</script>');
    echo ('<script>window.location.href = "units_of_measure.php";</script>');
  }
  else {
    echo ('<script>alert("Somethin went wrong.")</script>');
    echo ('<script>window.location.href = "units_of_measure.php";</script>');
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
                <strong><p>Units of Measure</p></strong>
                <form method='POST'>
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                      <?php
                      $sql = "SELECT * FROM tbl_unit_of_measure";
                      $query = $dbconn->prepare($sql);
                      $query->execute();
                      $rows = $query->fetchAll(PDO::FETCH_OBJ);
                      $count = $query->rowCount($rows);
                      if($count > 0){
                        foreach ($rows as $row) {
                          ?>
                          <tr>
                            <td class="w-75"> <?php echo ($row->unit); ?></td>
                            <td>  <a onclick="return confirm('delete unit?'); " href="units_of_measure.php?del_unit=<?php echo($row->id);?>"> <i class="fas fa-trash-alt"></i></a></td>
                          </tr>
                        <?php } } ?>
                          <tr id="add_unit_of_measure" hidden>
                            <td class="w-75"> <input type="text" name="unit_of_measure" class="form-control" placeholder="enter unit i.e kg,cm,ft" required/> <br> <input type="text" name="unit_description" class="form-control" placeholder="write full description i.e kilogram" required/> </td>
                              <td><input type="submit" name="save_info" class="btn btn-success"/></td>
                          </tr>
                      </tbody>
                    </table>
                  <a href="#" onclick="myFunction()"> + add unit of measure</a>
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
