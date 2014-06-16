<?php
session_start();
include('../connect.php');
$v_invoice = $_POST['invoice'];
$v_product = $_POST['product'];
$v_quant = $_POST['qty']; //c
$v_productid = $_POST['pt'];
$v_discount = $_POST['discount'];
$v_tax = $_POST['salestax'];
$v_subtotal = $_POST['totalsub'];

$result = $db->prepare("SELECT * FROM products WHERE product_code= :userid");
$result->bindParam(':userid', $v_product);
$result->execute();
for($i=0; $row = $result->fetch(); $i++){
$v_price=$row['price'];
$name=$row['product_name'];
}

//edit qty
$sql = "UPDATE products 
        SET qty=qty-?
		WHERE product_code=?";
$q = $db->prepare($sql);
$q->execute(array($v_quant,$v_product));
$v_subamount=(($v_price-$v_discount)*$v_quant);
$v_subtotal=($v_subamount*$v_quant)-$v_tax;
// query
$sql = "INSERT INTO sales_order (invoice,product,qty,amount,name,price,discount,salestax,totalmount) VALUES (:a,:b,:c,:d,:e,:f,:g,:h,:i,:j)";
$q = $db->prepare($sql);
$q->execute(array(':a'=>$v_invoice,':b'=>$v_product,':c'=>$v_quant,':d'=>$v_subtotal,':e'=>$name,':f'=>$v_price,':g'=>$v_discount, ':h'=>$v_discount, ':i'=>$v_tax, ':j'=>$v_subtotal));
header("location: sales.php?id=$v_productid&invoice=$v_invoice");
?>