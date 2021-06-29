<?php
session_start();
include('../includes/config.php');

if (empty($_SESSION['user_id'])){
  header('Location: ../index.php');
}

// start of delete unit of measure code
if(isset($_GET['del_op'])){
  $del_op = intval($_GET['del_op']);

  $sql ="DELETE FROM `tbl_operations` WHERE id=:del_op";
  $query = $dbconn->prepare($sql);
  $query->bindParam(':del_op', $del_op, PDO::PARAM_STR);
  $query->execute();
  $count =$query->rowCount();
  if($count > 0){
    echo ('<script>alert("operation deleted successfully")</script>');
    echo ('<script>window.location.href = "operations.php";</script>');
  }
  else {
    echo ('<script>alert("Somethin went wrong.")</script>');
    echo ('<script>window.location.href = "categories.php";</script>');
  }
}

//start of user registration code
if(isset($_POST['save_info'])){
  $op_desc = $_POST['op_desc'];
  $t_taken = $_POST['t_taken'];
  $op_time_unit = $_POST['op_time_unit'];

  $sql ="INSERT INTO `tbl_operations`(operation_description, time_taken, operation_time_unit) VALUES(:op_desc, :t_taken, :op_time_unit)";
  $query = $dbconn->prepare($sql);
  $query->bindParam(':op_desc', $op_desc, PDO::PARAM_STR);
  $query->bindParam(':t_taken', $t_taken, PDO::PARAM_STR);
  $query->bindParam(':op_time_unit', $op_time_unit, PDO::PARAM_STR);
  $query->execute();
  $lastInsertId = $dbconn->lastInsertId();
  if($lastInsertId){
    echo ('<script>alert("an operation has been added successfully.")</script>');
    echo ('<script>window.location.href = "operations.php";</script>');
  }
  else {
    echo ('<script>alert("Somethin went wrong.")</script>');
    echo ('<script>window.location.href = "operations.php";</script>');
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
                <strong><p>Operations</p></strong>
                <form method='POST'>
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                      <?php
                      $sql = "SELECT * FROM tbl_operations";
                      $query = $dbconn->prepare($sql);
                      $query->execute();
                      $rows = $query->fetchAll(PDO::FETCH_OBJ);
                      $count = $query->rowCount($rows);
                      if($count > 0){
                        foreach ($rows as $row) {
                          ?>
                          <tr>
                            <td class="w-75"> <?php echo($row->operation_description);?> </td>
                            <td>  <a onclick="return confirm('delete operation?');" href="operations.php?del_op=<?php echo($row->id);?>"> <i class="fas fa-trash-alt"></i></a></td>
                          </tr>
                            <?php } } ?>
                          <tr id="add_unit_of_measure" hidden>
                            <td class="w-75"> <input type="text" name="op_desc" class="form-control" placeholder="enter new operation" required/>
                            <input type="text" name="t_taken" class="form-control" placeholder="enter time taken" required/>
                            <br>
                            <select class="form-group form-select" name="op_time_unit">
                              <option value="">select time descriptor</option>
                            <?php
                            $sql = "SELECT * FROM tbl_time_descriptors";
                            $query = $dbconn->prepare($sql);
                            $query->execute();
                            $rows = $query->fetchAll(PDO::FETCH_OBJ);
                            $count = $query->rowCount($rows);
                            if($count > 0){
                              foreach ($rows as $row) {
                                ?>
                                  <option value="<?php echo($row->id);?>"><?php echo($row->time_descriptor);?></option>
                                <?php
                              }
                            }?>
                          </select>
                         </td>
                                <td><input type="submit" name="save_info" class="btn btn-success"/></td>
                          </tr>
                      </tbody>
                    </table>
                  <a href="#" onclick="myFunction()"> + add a new operation</a>
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
