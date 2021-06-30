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
  <style type="text/css">

  /*content css*/

  .form-group{
    border: 0px;
    border-bottom: 10px;
    margin-left: 10px;

  }
  #calc{
    border: none;
    border-bottom: solid;
    border-bottom-width: thin;
    margin-left: 50%;
  }
  #label{
    border: none;
    border-bottom: solid;
    border-bottom-width: thin;

  }

  #put{
    border: none;
    margin-left: 65%;
    text-align: center;
  }

  #qoute{
    box-sizing: 50px;

    size: 75px;


  }

  #data{
    border: none;
    border-bottom: #0000 inset solid;
    border-bottom-width: thin;
    box-sizing: 50%

  }


  #dataTable{

    padding: 10px;
    text-align: center;
    table-layout: auto;
    border-radius: 10px;
  }
  /*nav  css*/

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

  <style type="text/css">



  </style>

  <div class="nav1">
  </div>

  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <div class="row mb-12">
        <div class="col mb-7 font-weight-bold text-success"
        <h6 class="m-0">Create Quotation</h6>
      </div>

    </div>
    </div>

    <div class="card-body">
      <div class="container-fluid">

        <form name="print-form" action="quotation_processor.php" method="POST">
          <div class="row">
            <div class="form-group">
              <label for="customer"> Customer</label>
              <input type="text" class="form-control" size="50" name="customer_name" id="customer" required>
            </div>

            <div class="form-group">
              <label for="start_date"> Start Date </label>
              <input type="Date" class="form-control" name="start_date" id="start_date" required>
            </div>

            <div class="form-group">
              <label > End Date </label>
              <input type="Date" class="form-control" name="end_date" id="end_date" required>
            </div>
            <div>
               <input type="submit" style="margin-left:70%"class="btn btn-success" name="submit_order" value="save"/>
            </div>
            <div class="form-group">
              <label id="demo" for="sales_order"> Sales Order # </label>
              <input type="text" size="50" class="form-select" name="order_number" id="sales_order" value="<?php echo('PMS-'.rand())?>" readonly>
            </div>
          </div>
          <div class="table-responsive">

            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">

              <thead>
                <tr>
                  <th></th>
                  <th>Item </th>
                  <th>Quantity </th>
                  <th>Price per Unit</th>
                  <th>Total Cost </th>
                </tr>
              </thead>
              <tbody>

                <tr>
                  <td>1</td>

                  <td><select name="item_id" class="form-control" id="mySelect" onchange="myFunction()">
                    <option value="0">select an item</option>
                    <?php
                    $sql ="SELECT * FROM tbl_items";
                    $query= $dbconn -> prepare($sql);
                    $query-> execute();
                    $results = $query -> fetchAll(PDO::FETCH_OBJ);
                    $cnt=1;
                    if($query -> rowCount() > 0)
                    {
                      foreach ($results as $result) {
                        // below code fetches data in the user_roles tables
                        // ?>  <option value="<?php echo htmlentities($result->id);?>,<?php echo htmlentities($result->default_sales_price);?>"> <?php echo htmlentities($result->item_name);?> </option>
                      <?php }}?>
                    </select></td>
                    <td><input type="number" size="20" class="form-control" id="sells_quantity" name="item_quantity" value="1" onblur="myFunction()"></td>
                    <td><input type="number" id="sells_price" size="20" class="form-control" name="default_sells_price" value="0.00" readonly></td>
                    <td><input type="number" id="total_price" size="20" class="form-control" name="total_price"  value="0.00" readonly></td>
                  </tr>
                </tbody>
              </table>

            </div>
            <div class="calculations" id="calc">
              Total Units:  <span id="tot_num" class="mr-2 d-none d-lg-inline text-gray-600 small quote_spacing">0</span> </div>
              <div class="calculations" id="calc">
                SubTotal:<span class="mr-2 d-none d-lg-inline text-gray-600 small quote_spacing"  id="sub_total">MK 0</span>
              </div>
              <div class="calculations" id="calc">
                <label for="sells">Tax(20%):</label><span class="mr-2 d-none d-lg-inline text-gray-600 small quote_spacing"  id="total_vat" >MWK 0</span>
              </div>

              <div class="calculations" id="calc">
                Total Cost:<span class="mr-2 d-none d-lg-inline text-gray-600 small quote_spacing"  id="total_sells">MWK 0</span>
              </div>
            </form>

          </div>
        </div>
      </div>
      <!-- <script>
      function totalIt() {
      var sells_amount = document.getElementsById("sells_amount").value;
      var total = 0;
      var sells_quantity = +document.getElementById("sells_quantity").value;
      alert(sells_quantity);
      total = sells_quantity * sells_amount;
      document.getElementById("sells_price").value = document.getElementsById("sells_amount").value;
      document.getElementById("total_price").value = total.toFixed(2);
    }
  </script> -->
  <script>
  function myFunction() {
    var item_price = document.getElementById("mySelect").value;
    var item_price_to_array = JSON.parse("[" + item_price + "]");
    var item_quantity = document.getElementById("sells_quantity").value;
    document.getElementById("sells_price").value = item_price_to_array[1];
    document.getElementById("total_price").value = item_quantity * item_price_to_array[1];
    document.getElementById("tot_num").innerHTML= item_quantity;
    document.getElementById("sub_total").innerHTML=   document.getElementById("total_price").value;
    document.getElementById("total_vat").innerHTML= (20 * document.getElementById("total_price").value)/100;
    document.getElementById("total_sells").innerHTML=   "MK" + (+document.getElementById("sub_total").innerHTML +   +document.getElementById("total_vat").innerHTML);
  }
  function print_window(){
    print("");
  }
</script>

<?php
include('includes/scripts.php');
include('includes/footer.php');

}?>
