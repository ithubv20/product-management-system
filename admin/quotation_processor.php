<?php
include('../includes/config.php');
// start of material creation code
if(isset($_POST['submit_order'])){
  $order_number = $_POST['order_number'];
  $get_item_id = $_POST['item_id'];
  $item_quantity = $_POST['item_quantity'];
  $customer_name = $_POST['customer_name'];
  $total_price = $_POST['total_price'];
  $end_date = $_POST['end_date'];

  // extracting item id from $ited_id array
  $get_id = explode(",", $get_item_id);
  $item_id = $get_id[0];

  $sql = "INSERT INTO `tbl_sales_orders`(order_number, item, order_quantity, customer_name, total_amount, delivery_deadline) VALUES(:order_number, :item_id, :item_quantity, :customer_name, :total_price, :end_date)";
  $query = $dbconn->prepare($sql);
  $query->bindParam(':order_number', $order_number, PDO::PARAM_STR);
  $query->bindParam(':item_id', $item_id, PDO::PARAM_STR);
  $query->bindParam(':item_quantity', $item_quantity, PDO::PARAM_STR);
  $query->bindParam(':customer_name', $customer_name, PDO::PARAM_STR);
  $query->bindParam(':total_price', $total_price, PDO::PARAM_STR);
  $query->bindParam(':end_date', $end_date, PDO::PARAM_STR);
  $query->execute();
  $lastInsertId = $dbconn->lastInsertId();
  if($lastInsertId){
      echo ('<script>alert("Quotation successfully created.")</script>');
    echo ('<script>window.location.href = "sellsquote.php";</script>');
  }
  else {
    echo ('<script>alert("Sorry, there was an error in adding a new material.")</script>');
    // echo ('<script>window.location.href = "sellsquote.php";</script>');
  }
}
