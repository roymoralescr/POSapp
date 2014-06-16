<!--
*********************************************************************************
*  PHP CODE  																    *
********************************************************************************* 
-->
<?php
	require_once('auth.php');
	$invoiceid = $_SESSION['transactionid'];
	
?>

<?php
 echo 'Registrado como: '.$_SESSION['SESS_LAST_NAME'];
 
  if (isset($_GET['cash']) == '1') {
    $_SESSION['invoicetype'] = 'cash';    
  }else 
  	{
  		if (isset($_GET['cash']) == '1') {
    		$_SESSION['invoicetype'] = 'credit';}
	}
?>

<?php
function formatMoney($number, $fractional=false) {
					if ($fractional) {
						$number = sprintf('%.2f', $number);
					}
					while (true) {
						$replaced = preg_replace('/(-?\d+)(\d\d\d)/', '$1,$2', $number);
						if ($replaced != $number) {
							$number = $replaced;
						} else {
							break;
						}
					}
					return $number;
				}
?>

<?php
function price($productid){
		include('../connect.php');		
		$pricecalc = $db->prepare("SELECT * FROM products where product_id =:");
			$result->bindParam(':pid', $productid);
			$result->execute();
		
		echo $pricecalc;
		
		}
		?>

<?php  
if (isset($_GET['sugprodid'])){
	$sugprodid =$_GET['sugprodid'];
	}else {
		$sugprodid = "";
	}
?>

<?php 
		function xx(){
		include('../connect.php');		
		$getfields = $db->prepare("SELECT * FROM products where product_id :sugid");
			$getfields->bindParam(':sugid', $sugprodid);
			$getfields->execute();	
			for($i=0; $row = $getfields->fetch(); $i++){			
				$v_searchprice = $row['price'];		
		}
		return '1';
	}
	?>

<!--
*********************************************************************************
* END PHP CODE  																*
********************************************************************************* 
-->
<!-- Form validation code will come here. -->
<script type="text/javascript">
function validate()
{
 
   if( document.addprodinvoice.qty.value == "" )
   {
     alert( "Cantidad de productos debe ser mayor a 0" );
     document.addprodinvoice.qty.focus() ;
     return false;
   }
/*
   if( document.myForm.EMail.value == "" )
   {
     alert( "Please provide your Email!" );
     document.myForm.EMail.focus() ;
     return false;
   }
   if( document.myForm.Zip.value == "" ||
           isNaN( document.myForm.Zip.value ) ||
           document.myForm.Zip.value.length != 5 )
   {
     alert( "Please provide a zip in the format #####." );
     document.myForm.Zip.focus() ;
     return false;
   }
   if( document.myForm.Country.value == "-1" )
   {
     alert( "Please provide your country!" );
     return false;
   }
   */
   return( true );
}
</script>
<html>
<head>
<title>POS</title>
<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
<link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />

</head>

<body>
<div id="maintable">
	<div style="margin-top: -19px; margin-bottom: 21px;">
		<a id="addd" href="index.php" style="float: none;">Back</a>
	</div>
	
<a type="button" rel="facebox" id="cccc" href="select_product.php"> buscar producto </a><input id="sugprod" type="visible" name="invoice" value="<?php echo $sugprodid ?>" /> <br><br>

<!-- Add items to grid-->
<form name="addprodinvoice" action="incoming.php" method="post" onsubmit="return(validate());" >
	<span>Venta </span><input type="text" name="pt" value="<?php echo $_SESSION['invoicetype']; ?>" />
	<span>FACT #: </span> <input type="visible" name="invoice" value="<?php echo $invoiceid ?>" /> <br><br>
	<span>Producto: </span>
	<select name="product" style="width: 520px;">
		<?php
		include('../connect.php');		
		$result = $db->prepare("SELECT * FROM products");
			$result->bindParam(':userid', $res);
			$result->execute();
			for($i=0; $row = $result->fetch(); $i++){
		?>
			 <option value="<?php echo $row['product_code']; ?>"><?php echo $row['product_name']; ?> - <?php echo $row['product_code']; ?></option> 
		<?php
		}
		?>
	</select>
	<span><br>Cantidad: </span><input type="text" name="qty" value="" placeholder="Cant." autocomplete="off"/>
	<span>Descuento: </span><input type="text" name="discount" value="" autocomplete="off" placeholder="%" />
	<span>Precio: </span><input type="text" name="unitprice" value="" autocomplete="off" /><br>
	<span>Impuesto: </span><input type="text" name="salestax" value="0" autocomplete="off" /><br>
	<input type="submit" value="Agregar" style="width: 123px;" />
</form>

<table id="resultTable" data-responsive="table">
	<thead>
		<tr>
			<th> Codigo </th>
			<th> Articulo </th>
			<th> Cant </th>
			<th> Precio </th>
			<th> % Desc </th>			
			<th> Imp Vta </th>
			<th> Prec unit </th>
			<th> Eliminar </th>
		</tr>
	</thead>
	<tbody>
		
			<?php
				$id= $invoiceid;			
				include('../connect.php');
				$result = $db->prepare("SELECT * FROM sales_order WHERE invoice= :userid");
				$result->bindParam(':userid', $id);
				$result->execute();
				for($i=0; $row = $result->fetch(); $i++){
			?>
			<tr class="record">
				<td><?php echo $row['product']; ?></td>
				<td><?php echo $row['name']; ?></td>
				<td><?php echo $row['qty']; ?></td>
				<td>
				<?php
					$pprice=$row['price'];
					echo formatMoney($pprice, true);
				?>
				</td>
				<td>
				<?php
					$ttax=$row['salestax'];
					echo formatMoney($ttax, true);
				?>
				</td>
				<td><?php $row['discount'];	?></td>

				<td>
				<!--subtotal  (price * qty)- disc - tax  -->
				<?php
					$ssubtot=$row['amount'];
					echo formatMoney($ssubtot, true);
				?>
				</td>				
				
				<td><a href="delete.php?id=<?php echo $row['transaction_id']; ?>&invoice= <?php echo $invoiceid; ?>; ?>&dle=<?php echo $_GET['id']; ?>&qty=<?php echo $row['qty'];?>&code=<?php echo $row['product'];?>&code=<?php echo $row['salestax'];?>&code=<?php echo $row['discount'];?>"> Delete </a></td>
			</tr>
			<?php
				}
			?>		
	</tbody>
	<tfoot>		
		<tr>
			<!-- subtotal-->
				<td colspan="8"><strong >Monto Facturado:</strong></td>
				<td colspan="2"><strong >
				<?php				
				$invid= $invoiceid; 			
					$resultas = $db->prepare("SELECT sum(amount) FROM sales_order WHERE invoice= :a");
					$resultas->bindParam(':a', $invid);
					$resultas->execute();
					for($i=0; $rowas = $resultas->fetch(); $i++){
					$totalunitcol=$rowas['sum(amount)'] ;
					echo formatMoney($totalunitcol, true);
				}
				?>
				</strong></td>				
		</tr>
		<tr>
			<!-- Discount-->
				<td colspan="8"><strong>Descuento:</strong></td>
				<td colspan="2"><strong>					
				<?php			
					$resdisc = $db->prepare("SELECT sum(discount) FROM sales_order WHERE invoice= :a");
					$resdisc->bindParam(':a', $invid);
					$resdisc->execute();
					for($i=0; $rowas = $resdisc->fetch(); $i++){
					$totalcoldisc=$rowas['sum(discount)'];
					echo formatMoney($totalcoldisc, true);
				}
				?>
				</strong></td>
		</tr> 		
		<tr>
			<!-- taxes-->
				<td colspan="8"><strong>IV:</strong></td>
				<td colspan="2"><strong>					
				<?php			
					$restax = $db->prepare("SELECT sum(salestax) FROM sales_order WHERE invoice= :a");
					$restax->bindParam(':a', $invid);
					$restax->execute();
					for($i=0; $rowas = $restax->fetch(); $i++){
					$totalcoltax=$rowas['sum(salestax)'];
					echo formatMoney($totalcoltax, true);
				}
				?>
				</strong></td>
		</tr>     		
	</tfoot>

</table><br>
<a rel="facebox" id="cccc" href="checkout.php?prodid=<?php echo $_GET['id']?>&invoice=<?php echo $invoiceid; ?>&totaldisc=<?php echo $totalcoldisc; ?>&cashier=<?php echo $_SESSION['SESS_FIRST_NAME']?>&salestax=<?php echo $totalcoltax; ?>&totalsub=<?php echo $totalcolsub; ?>">Facturar</a>
<div class="clearfix"></div>
</div>
</body>
</html>

<!-- 
*********************************************************************************
*  Scritps  																    *
********************************************************************************* 
-->
<script type="text/javascript">
      /* $(document).ready(function()  {        
       $("#username_input").blur(function()  {
        cc=$("#username_input").val();
        cc*=$("#cant").val();
        $("#username_input2").val(cc);
        });
      $("#sugprod").blur(function(){
      	prodd=$("#sugprod").val();
	   }) 
});*/
     
</script>

<script src="lib/jquery.js" type="text/javascript"></script>
<script src="src/facebox.js" type="text/javascript"></script>
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('a[rel*=facebox]').facebox({
      loadingImage : 'src/loading.gif',
      closeImage   : 'src/closelabel.png'
    });

	$("#sugprod").blur(function(){
      	prodd=$("#sugprod").val();
      	alert(prodd);
	   })

  })
</script>