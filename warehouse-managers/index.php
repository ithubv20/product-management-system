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

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
      <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
      class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
    </div>

    <!-- Content Row -->
    <div class="row">

              <!-- stock section -->
              <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div
                  class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-bell fa-fw"></i>Stock Alerts</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <ul>
                    <?php
                    $sql = "SELECT tbl_stock_material.*, tbl_materials.material_name FROM tbl_stock_material INNER JOIN tbl_materials on tbl_stock_material.material_name = tbl_materials.id where in_stock < 5";
                    $query = $dbconn -> prepare($sql);
                    $query->execute();
                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                    if($results){
                      foreach ($results as $result) {
                        if($result->in_stock < 3){?>
                          <li><a href="stockmaterials.php"><?php echo htmlentities($result->material_name); ?></a> <span class="badge badge-pill badge-danger float-right"><?php echo ("needs a quick purchase");?></span></li>
                          <?php }
                          else{ ?>
                            <li><a href="stockmaterials.php"><?php echo htmlentities($result->material_name); ?></a> <span style="color: #000" class="badge b badge-pill badge-warning float-right"><?php echo ("consider material purchase");?></span></li>
                        <?php  }  }
                      }?>
                    </ul>
                  </div>
                </div>
              </div>

              <!-- buy material section -->
              <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div
                  class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-bell fa-fw"></i>Buy Material Alerts</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <ul>
                    <?php
                    $sql = "SELECT tbl_buy_materials.*, tbl_materials.material_name, tbl_materials.default_supplier FROM tbl_buy_materials INNER JOIN tbl_materials on tbl_buy_materials.material_id = tbl_materials.id where status = 0";
                    $query = $dbconn -> prepare($sql);
                    $query->execute();
                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                    if($results){
                      foreach ($results as $result) {?>
                        <?php
                        $datetime1 = strtotime($result->arrival_date);
                        $datetime2 = strtotime(date("Y-m-d"));

                        $secs = $datetime1 - $datetime2;// == <seconds between the two times>
                        $days = $secs / 86400;
                        if($days == 0){ ?>
                          <li><a href="buymaterials.php"><?php echo htmlentities($result->material_name); ?></a> purchase <div class="float-right"><span class="badge badge-pill badge-danger"><?php echo ("arrival date is today!");?> </span> contact supplier at
                            <?php
                            $supplier = $result->default_supplier;
                            $sql = "SELECT supplier_email FROM tbl_suppliers WHERE id = :supplier";
                            $query = $dbconn -> prepare($sql);
                            $query->bindParam(':supplier',$supplier, PDO::PARAM_INT);
                            $query->execute();
                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                            if($results){
                              foreach ($results as $result) {?>
                                <a href="mailto:<?php echo$result->supplier_email; ?>"> <?php echo ($result->supplier_email); ?></a>
                            <?php  }
                            }?>
                          </div></li>
                        <?php }
                        else if($days > 0 AND $days <= 2){?>
                          <li><a href="buymaterials.php"><?php echo htmlentities($result->material_name); ?></a> purchase <span class="badge badge-pill badge-warning float-right"><?php echo ($days."  day(s) to arrival date");?></span></li>
                        <?php }
                        else if($days > 2){?>
                          <li> <a href="buymaterials.php"><?php echo htmlentities($result->material_name); ?></a> purchase <span class="badge badge-pill badge-success float-right"><?php echo ($days."  day(s) to arrival date");?></span></li>
                        <?php }
                        else { ?>
                          <li><a href="buymaterials.php"><?php echo htmlentities($result->material_name); ?></a> purchase<span class="badge badge-pill badge-danger float-right"><?php echo ("purchase is beyond arrival date");?></span></li>
                        <?php    }
                      }} ?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>


          </div>
          <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->




        <?php
        include('includes/scripts.php');
        include('includes/footer.php');

      }?>
