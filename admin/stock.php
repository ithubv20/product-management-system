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

    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.rawgit.com/twbs/bootstrap/v4-dev/dist/css/bootstrap.css">

      <style type="text/css">

.nav1
    {
        font-size:20px;
        text-decoration:none;
        text-align:center;
        border-bottom: 6px solid  #1cc88a;
    }

.nav1 ul li
    {
        padding:10px;
        display:inline;
    }

.nav1 ul li a
    {
        text-decoration:none;
        color:#444;
    }

.nav1 ul li a:hover
    {
        color:#111;

    }

.active1
    {
        color:#000;
        border-bottom:5px solid green;
        padding:10px;
    }
  .prod{
    text-decoration-line: underline;

  }
  .table-responsive{
    margin-left: 2%;
    table-layout: auto;

  }


      </style>

    <div class="nav1">
            <ul>
                <li><a href="stock.php" class="active1" style="color:#FFFFFF;  background: #1cc88a;" >All</a></li>
                <li>|</li>
                <li><a href="stockProducts.php">Products</a></li>
                <li>|</li>
                <li><a href="stockMaterials.php">Materials</a></li>
            </ul>

        </div>


          <!-- DataTales Example -->
             <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-success">All</h6>
                        </div>
                         <div class="table-responsive">

     <table class="table table-bordered" id="dataTable" width="120%" cellspacing="0">

     <thead>
    <tr>
            <th>Name</th>
            <th>Variant Code</th>
             <th>Category</th>
            <th>Supplier</th>
            <th>Average cost</th>
             <th>Value in Stock</th>
             <th>In Stock</th>
             <th>Expected</th>
            <th>Committed</th>
            <th>Missing</th>
             <th></th>

          </tr>
        </thead>
        <tbody>

            <tr>
             <td><a href="stockProducts.php" class="prod" style="color: #1cc88a;">Coffe Table</a></td>
             <td>CT-CO</td>
             <td>Tables</td>
             <td>weavers</td>
             <td>2250000 MWK</td>
             <td>8000000 MWK</td>
              <td>3 Pcs</td>
             <td>0 Pcs</td>
              <td>3 Pcs</td>
             <td>0 Pcs</td>
             <td> <form action="" method="post">
                    <input type="hidden" name="edit_id" value="">
                    <button  type="submit" name="edit_btn" class="btn btn-success"><i class="fa fa-plus-square" aria-hidden="true"></i> </button>
                </form></td>
             </tr>


        </tbody>
      </table>

    </div>
</div>
                <!-- /.container-fluid -->

<?php
 include('includes/scripts.php');
 include('includes/footer.php');

}?>
  <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>