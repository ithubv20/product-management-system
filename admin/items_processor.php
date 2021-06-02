<?php
include('../includes/config.php');
// start of material creation code
if(isset($_POST['create_item'])){
  $material_name = $_POST['material_name'];
  $material_code = $_POST['material_code'];
  $material_category = $_POST['material_category'];
  $material_supplier = $_POST['material_supplier'];
  $material_price = $_POST['material_price'];

  $sql = "INSERT INTO `tbl_materials`(material_name, material_code, category, default_supplier, purchase_price) VALUES(:material_name, :material_code, :material_category, :material_supplier, :material_price)";
  $query = $dbconn->prepare($sql);
  $query->bindParam(':material_name', $material_name, PDO::PARAM_STR);
  $query->bindParam(':material_code', $material_code, PDO::PARAM_STR);
  $query->bindParam(':material_category', $material_category, PDO::PARAM_STR);
  $query->bindParam(':material_supplier', $material_supplier, PDO::PARAM_STR);
  $query->bindParam(':material_price', $material_price, PDO::PARAM_STR);
  $query->execute();
  $lastInsertId = $dbconn->lastInsertId();
  if($lastInsertId){
    echo ('<script>alert("A new material has been added successfully.")</script>');
    echo ('<script>window.location.href = "materials.php";</script>');
  }
  else {
    echo ('<script>alert("Sorry, there was an error in adding a new material.")</script>');
  }
}
