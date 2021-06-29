<?php
session_start();
require_once('../includes/config.php');
if (empty($_SESSION['user_id'])){
  header('Location: ../index.php');
}
// start of user registration code
if(isset($_POST['update_user'])){

}
// --- end of user registration code ---

include('includes/header.php');
include('includes/navbar.php');
include('includes/topbar.php');
?>
<style type="text/css">
.btn-save{
  margin-left: 5%;
}

</style>

<div class="container-fluid">

  <div class="card-body">
      <div>
        <input type="text" value="" class="form-select" readonly>
      </div>
      <div>
        <select>
          <option value=""></option>
        </select>
      </div>
    </div>
  </div>

  <?php
  include('includes/scripts.php');
  include('includes/footer.php');
  ?>
  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>
