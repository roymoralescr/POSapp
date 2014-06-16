<?php
   $db = new mysqli('localhost', 'root' ,'', 'sales');
	if(!$db) {
	
		echo 'Could not connect to the database.';
	} else {
	
		if(isset($_POST['queryString'])) {
			$queryString = $db->real_escape_string($_POST['queryString']);
			
			if(strlen($queryString) >0) {				
				$query = $db->query("SELECT *  FROM products WHERE product_name LIKE '%$queryString%' LIMIT 1000");
				if($query) {
				echo '<ul>';
					while ($result = $query ->fetch_object()) {
	         			echo '<li onClick="fill(\''.addslashes($result->product_id).'\');">'.'COD: '.$result->product_id.' - <br>'.$result->product_name.' - Prec : '.$result->price.'</li>';         			
	         		}
				echo '</ul>';
					
				} else {
					echo 'OOPS we had a problem :(';
				}
			} else {
				// do nothing
			}
		} else {
			echo 'There should be no direct access to this script!';
		}
	}
?>