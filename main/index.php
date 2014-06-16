<!DOCTYPE html>
<html>
<head>
	<link href="../style.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="http://fonts.googleapis.com/css?family=Open+Sans:400,700,600" rel="stylesheet" type="text/css">
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="css/app.css" rel="stylesheet" type="text/css">
</head>
<body>
	<?php
		require_once('auth.php');
		if(isset($_SESSION['transactionid']))
	  	unset($_SESSION['transactionid']);

	  	if(isset($_SESSION['invoicetype']))
	  	unset($_SESSION['invoicetype']);
	?>

	<?php
		function createRandomPassword() {
			$chars = "003232303232023232023456789";
			srand((double)microtime()*1000000);
			$i = 0;
			$pass = '' ;
			while ($i <= 7) {
				$num = rand() % 33;
				$tmp = substr($chars, $num, 1);
				$pass = $pass . $tmp;
				$i++;
			}
			return $pass;
		}
		$_SESSION['transactionid']='RS-'.createRandomPassword();
	?>

	<div id="contentWrapper">
	    <div id="contentLeft">
	        <ul id="leftNavigation">
	            <li class="active">
	                <a href="#"><i class="fa fa-coffee leftNavIcon"></i> About us</a>
	                <ul>
	                    <li>
	                        <a href="#"><i class="fa fa-angle-right leftNavIcon"></i> Our History</a>
	                    </li>
	                    <li>
	                        <a href="#"><i class="fa fa-angle-right leftNavIcon"></i> Our Team</a>
	                    </li>
	                </ul>
	            </li>
	            <li>
	                <a href="#"><i class="fa fa-flask leftNavIcon"></i> Products</a>
	                <ul>
	                    <li>
	                        <a href="#"><i class="fa fa-angle-right leftNavIcon"></i> Garden</a>
	                    </li>
	                    <li>
	                        <a href="#"><i class="fa fa-angle-right leftNavIcon"></i> Office</a>
	                    </li>
	                    <li>
	                        <a href="#"><i class="fa fa-angle-right leftNavIcon"></i> Home</a>
	                    </li>
	                </ul>
	            </li>
	            <li>
	                <a href="#"><i class="fa fa-truck leftNavIcon"></i> Services</a>
	                <ul>
	                    <li>
	                        <a href="#"><i class="fa fa-angle-right leftNavIcon"></i> Garden</a>
	                    </li>
	                    <li>
	                        <a href="#"><i class="fa fa-angle-right leftNavIcon"></i> Office</a>
	                    </li>
	                    <li>
	                        <a href="#"><i class="fa fa-angle-right leftNavIcon"></i> Home</a>
	                    </li>
	                </ul>
	            </li>
	            <li>
	                <a href="#"><i class="fa fa-envelope-o leftNavIcon"></i> Contact us</a>
	                <ul>
	                    <li>
	                        <a href="#"><i class="fa fa-angle-right leftNavIcon"></i> Find Us</a>
	                    </li>
	                    <li>
	                        <a href="#"><i class="fa fa-angle-right leftNavIcon"></i> Contact Details</a>
	                    </li>
	                </ul>
	            </li>
	        </ul>
	    </div>
	    <div id="contentRight">
	        <h1 id="heading">Vertical navigation : jQuery Plugin</h1>
	        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Alias consequatur delectus eius laborum reprehenderit. A amet dignissimos explicabo maiores nisi nulla placeat quae reiciendis repudiandae tempora tempore, vero? Ea, optio?</p>
	    </div>
	</div>

	<div id="mainmain">
	<?php
		$position=$_SESSION['SESS_LAST_NAME'];

		if($position=='cashier') {
		?>
			<a href="sales.php?cash=true&invoice=<?php echo $finalcode ?>">Cash</a>
			<a href="sales.php?id=credit&invoice=<?php echo $finalcode ?>">Credit</a>
			<a href="../index.php">Logout</a>
		<?php
		}
		if($position=='admin') {
		?>
			<!--<a href="sales.php?id=cash&productname=&invoice=<?php echo $finalcode ?>">Cash</a>-->
			<a href="sales.php?cash=1&productid=">Cash</a>
			<a href="sales.php?cash=2">Credit</a>
			<a href="salesreport.php?d1=0&d2=0">Sales Report</a>
			<a href="collection.php?d1=0&d2=0">Collection Report</a>
			<a href="accountreceivables.php?d1=0&d2=0">Accounts Receivable Report</a>
			<a rel="facebox" href="select_customer.php">Customer Ledger</a>
			<a href="products.php">Products</a>
			<a href="customer.php">Customers</a>
			<a href="supplier.php">Suppliers</a>
			<a href="purchaseslist.php">Purchases</a>
			<a href="../index.php">Logout</a>
		<?php
		}
	?>
	<div class="clearfix"></div>
	</div>

</body>
</html>


<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="js/jquery.ssd-vertical-navigation.min.js"></script>
<script src="js/app.js"></script>
<script type="text/javascript">
$(function() {
 
    var verticalNavigation = new SSDSystem.VerticalNavigation();
    verticalNavigation.init();
 
});
</script>

<script src="lib/jquery.js" type="text/javascript"></script>
<script src="src/facebox.js" type="text/javascript"></script>
<script type="text/javascript">
  jQuery(document).ready(function($) {
    $('a[rel*=facebox]').facebox({
      loadingImage : 'src/loading.gif',
      closeImage   : 'src/closelabel.png'
    })
  })
</script>
