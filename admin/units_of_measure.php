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
                            <td class="w-75"> kg </td>
                            <td>  <a href="#"> <i class="fas fa-trash-alt"></i></a></td>
                          </tr>
                          <tr id="add_unit_of_measure" hidden>
                            <td class="w-75"> <input type="text" name="input_of_measure" class="form-control" placeholder="enter input i.e kg,cm,ft" required/> </td>
                              <td><a href="#"><i class="fas fa-save"></i></a></td>
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
