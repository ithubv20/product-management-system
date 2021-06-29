<?php
session_start();
include('../includes/config.php');

if (empty($_SESSION['user_id'])){
  header('Location: ../index.php');
}
// start of delete unit of measure code
if(isset($_GET['del_category'])){
  $del_category = intval($_GET['del_category']);

  $sql ="DELETE FROM `tbl_categories` WHERE id=:del_category";
  $query = $dbconn->prepare($sql);
  $query->bindParam(':del_category', $del_category, PDO::PARAM_STR);
  $query->execute();
  $count =$query->rowCount();
  if($count > 0){
    echo ('<script>alert("category deleted successfully")</script>');
    echo ('<script>window.location.href = "categories.php";</script>');
  }
  else {
    echo ('<script>alert("Somethin went wrong.")</script>');
    // echo ('<script>window.location.href = "categories.php";</script>');
  }
}

// start of user registration code
if(isset($_POST['save_info'])){
  $new_category = $_POST['new_category'];

  $sql ="INSERT INTO `tbl_categories`(category_description) VALUES(:new_category)";
  $query = $dbconn->prepare($sql);
  $query->bindParam(':new_category', $new_category, PDO::PARAM_STR);
  $query->execute();
  $lastInsertId = $dbconn->lastInsertId();
  if($lastInsertId){
    echo ('<script>alert("a new category has been added successfully.")</script>');
    echo ('<script>window.location.href = "categories.php";</script>');
  }
  else {
    echo ('<script>alert("Somethin went wrong.")</script>');
    echo ('<script>window.location.href = "categories.php";</script>');
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
                <strong><p>Categories</p></strong>
                <form method='POST'>
                  <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <tbody>
                      <?php
                      $sql = "SELECT * FROM tbl_categories";
                      $query = $dbconn->prepare($sql);
                      $query->execute();
                      $rows = $query->fetchAll(PDO::FETCH_OBJ);
                      $count = $query->rowCount($rows);
                      if($count > 0){
                        foreach ($rows as $row) {
                          ?>
                          <tr>
                            <td class="w-75"> <?php echo($row->category_description);?> </td>
                            <td>  <a onclick="return confirm('delete category?');" href="categories.php?del_category=<?php echo($row->id);?>"> <i class="fas fa-trash-alt"></i></a></td>
                          </tr>
                            <?php } } ?>
                          <tr id="add_unit_of_measure" hidden>
                            <td class="w-75"> <input type="text" name="new_category" class="form-control" placeholder="enter new category" required/> </td>
                              <td><input type="submit" name="save_info" class="btn btn-success"/></td>
                          </tr>
                      </tbody>
                    </table>
                  <a href="#" onclick="myFunction()"> + add a new category</a>
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
