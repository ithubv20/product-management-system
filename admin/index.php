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

      <!-- Earnings (Monthly) Card Example -->
      <div class="col-xl-3 col-md-6 mb-4">
        <a href="allorders.php">
          <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                  <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                    All Orders</div>
                    <?php
                    $sql ="SELECT id FROM tbl_sales_orders";
                    $query = $dbconn -> prepare($sql);
                    $query->execute();
                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                    $all_orders=$query->rowCount();
                    ?>
                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo($all_orders); ?></div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-list fa-2x text-gray-300"></i>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
          <a href="ordersinprogress.php">
            <div class="card border-left-warning shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                      Orders Inprogress </div>
                      <?php
                      $sql ="SELECT id FROM tbl_sales_orders WHERE order_status < 2 AND make_status = 2";
                      $query = $dbconn -> prepare($sql);
                      $query->execute();
                      $results=$query->fetchAll(PDO::FETCH_OBJ);
                      $orders_in_progress=$query->rowCount();
                      ?>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo($orders_in_progress);?></div>
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-spinner fa-2x text-gray-300"></i>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          </div>

          <!-- Earnings (Monthly) Card Example -->
          <div class="col-xl-3 col-md-6 mb-4">
            <a href="orderscompleted.php">
              <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                        Orders Completed </div>
                        <?php
                        $sql ="SELECT id FROM tbl_sales_orders WHERE order_status = 2";
                        $query = $dbconn -> prepare($sql);
                        $query->execute();
                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                        $orders_completed=$query->rowCount();
                        ?>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo($orders_completed);?></div>
                      </div>
                      <div class="col-auto">
                        <i class="fas fa-check fa-2x text-gray-300"></i>
                      </div>
                    </div>
                  </div>
                </div>
              </a>
            </div>

            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <a href="ordersdelayed.php">
                <div class="card border-left-danger shadow h-100 py-2">
                  <div class="card-body">
                    <div class="row no-gutters align-items-center">
                      <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                          Orders Delayed</div>
                          <?php
                          $sql ="SELECT * FROM tbl_sales_orders WHERE delivery_deadline < now()";
                          $query = $dbconn -> prepare($sql);
                          $query->execute();
                          $results=$query->fetchAll(PDO::FETCH_OBJ);
                          $orders_delayed=$query->rowCount();
                          ?>
                          <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo($orders_delayed);?></div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-bug fa-2x text-gray-300"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </a>
              </div>

              <!-- Area Chart -->
              <div class="col-xl-6 col-lg-6">
                <div class="card shadow mb-4">
                  <!-- Card Header - Dropdown -->
                  <div
                  class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <h6 class="m-0 font-weight-bold text-success"> <i class="fas fa-bell fa-fw"></i>Sales order Alerts!</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                  <ul>
                    <?php
                    $sql = "SELECT * FROM `tbl_sales_orders` where order_status < 2";
                    $query = $dbconn -> prepare($sql);
                    $query->execute();
                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                    if($results){
                      foreach ($results as $result) {?>
                        <?php
                        $datetime1 = strtotime($result->delivery_deadline);
                        $datetime2 = strtotime(date("Y-m-d"));

                        $secs = $datetime1 - $datetime2;// == <seconds between the two times>
                        $days = $secs / 86400;
                        if($days == 0){ ?>
                          <li>Order <a href="sellsorders.php"><?php echo htmlentities($result->order_number); ?></a><span class="badge badge-pill badge-danger float-right"><?php echo ("delivery date is today!");?></span></li>
                        <?php }
                        else if($days > 0 AND $days <= 2){?>
                          <li>Order <a href="sellsorders.php"><?php echo htmlentities($result->order_number); ?></a><span class="badge badge-pill badge-warning float-right"><?php echo ($days."  day(s) to delivery date");?></span></li>
                        <?php }
                        else if($days > 2){?>
                          <li> Order <a href="sellsorders.php"><?php echo htmlentities($result->order_number); ?></a><span class="badge badge-pill badge-success float-right"><?php echo ($days."  day(s) to delivery date");?></span></li>
                        <?php }
                        else { ?>
                          <li>Order <a href="sellsorders.php"><?php echo htmlentities($result->order_number); ?></a><span class="badge badge-pill badge-danger float-right"><?php echo ("late delivery");?></span></li>
                        <?php    }
                      }} ?>
                    </ul>
                  </div>
                </div>
              </div>
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
              <div class="col-xl-12 col-lg-12">
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
