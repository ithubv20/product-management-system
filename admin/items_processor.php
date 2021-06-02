<?php
include('../includes/config.php');
// start of material creation code
if(isset($_POST['create_item'])){
  $item_name = $_POST['item_name'];
  $item_code = $_POST['item_code'];
  $item_default_selling_price = $_POST['item_default_selling_price'];
  $production_period = $_POST['production_period'];
  $total_item_production_cost = $_POST['total_item_production_cost'];
  $item_category = $_POST['item_category'];

  $sql = "INSERT INTO `tbl_items`(item_name, variant_code, default_sales_price, cost, prod_time, category) VALUES(:item_name, :item_code, :item_default_selling_price, :total_item_production_cost, :production_period, :item_category)";
  $query = $dbconn->prepare($sql);
  $query->bindParam(':item_name', $item_name, PDO::PARAM_STR);
  $query->bindParam(':item_code', $item_code, PDO::PARAM_STR);
  $query->bindParam(':item_default_selling_price', $item_default_selling_price, PDO::PARAM_STR);
  $query->bindParam(':production_period', $production_period, PDO::PARAM_STR);
  $query->bindParam(':total_item_production_cost', $total_item_production_cost, PDO::PARAM_STR);
  $query->bindParam(':item_category', $item_category, PDO::PARAM_STR);
  $query->execute();
  $lastInsertId = $dbconn->lastInsertId();
  if($lastInsertId){
    echo ('<script>alert("A new item has been added successfully.")</script>');
    echo ('<script>window.location.href = "items.php";</script>');
  }
  else {
    echo ('<script>alert("Sorry, there was an error in adding a new item.")</script>');
  }
}
