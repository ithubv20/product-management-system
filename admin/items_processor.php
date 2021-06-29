<?php
include('../includes/config.php');
// start of material creation code
if(isset($_POST['create_item'])){
  $item_name = $_POST['item_name'];
  $item_code = $_POST['item_code'];
  $item_category = $_POST['item_category'];
  $req_materials = $_POST['required_materials'];
  $required_operations = $_POST['required_operations'];
  $human_resource = $_POST['human_resource'];
  $item_default_selling_price = $_POST['item_default_selling_price'];


  $required_materials = serialize($req_materials);
  $req_operations = serialize($required_operations);
  $hum_resource = serialize($human_resource);

  $sql = "INSERT INTO `tbl_items`(item_name, variant_code, item_materials, item_operations, item_resources, default_sales_price, category) VALUES(:item_name, :item_code, :required_materials, :req_operations, :hum_resource, :item_default_selling_price, :item_category)";
  $query = $dbconn->prepare($sql);
  $query->bindParam(':item_name', $item_name, PDO::PARAM_STR);
  $query->bindParam(':item_code', $item_code, PDO::PARAM_STR);
  $query->bindParam(':required_materials', $required_materials, PDO::PARAM_STR);
  $query->bindParam(':req_operations', $req_operations, PDO::PARAM_STR);
  $query->bindParam(':hum_resource', $hum_resource, PDO::PARAM_STR);
  $query->bindParam(':item_default_selling_price', $item_default_selling_price, PDO::PARAM_STR);
  $query->bindParam(':item_category', $item_category, PDO::PARAM_STR);
  $query->execute();
  $lastInsertId = $dbconn->lastInsertId();
  if($lastInsertId){
    $in_stock = 1;
    $sql = "INSERT INTO `tbl_stock`(item_name, item_category, in_stock) VALUES(:lastInsertId, :item_category, :in_stock)";
    $query = $dbconn->prepare($sql);
    $query->bindParam(':lastInsertId', $lastInsertId, PDO::PARAM_STR);
    $query->bindParam(':item_category', $item_category, PDO::PARAM_STR);
    $query->bindParam(':in_stock', $in_stock, PDO::PARAM_STR);
    $query->execute();
    
    echo ('<script>alert("A new item has been added successfully.")</script>');
    echo ('<script>window.location.href = "items.php";</script>');
  }
  else {
    echo ('<script>alert("Sorry, there was an error in adding a new item.")</script>');
  }


}
