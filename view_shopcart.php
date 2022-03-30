
<?php
session_start();
?>
<html>
<head>
	<meta charset="utf-8">
	<title>Shop cart</title>
</head>
<h1>View your shop cart here.</h1>
<body>
	<table border="1">
		<tr>
			<th>Product Name</th>
			<th>Product Brand</th>
			<th>Product Price</th>
			<th>Product Description</th>
			<th>Product Color</th>
			<th>Counts</th>
			<th>Delete from Cart</th>
		</tr>
		<?php
		$totalPrice = 0;
		$totalItem = 0;
		$p_info = 0;
		if(isset($_SESSION['shop-cart'])){
			foreach ($_SESSION['shop-cart'] as $item){
				$p_id = $item[0];
				$p_name = $item[1];
				$goods_num = $item[2];

				$p_info = $p_info.$p_id.",".$goods_num."/";
				
				$servername = "localhost";
				$username = "root";
				$password = "";
				$dbname = "hw";

				$conn = mysqli_connect($servername, $username, $password, $dbname);

				if (mysqli_connect_errno()){
					echo "Failed to connect to MySQL: " . mysqli_connect_error();
				}

				$sql = "SELECT * FROM product_info WHERE p_id =".$p_id.";";
				$result=mysqli_query($conn,$sql);//result is a PHP array

				$num_rows=mysqli_num_rows($result);
				//echo $num_rows;

				mysqli_close($conn);


				while ($row = mysqli_fetch_assoc($result)){
					$p_brand=$row["p_brand"];
					$p_type=$row["p_type"];
					$p_price=$row["p_price"];
					//$p_inventory=$row["p_inventory"];
					$p_descr=$row["p_descr"];
					$p_color=$row["p_color"];


					echo "<tr>";
					echo "<td>".$p_name."</td>";
					echo "<td>".$p_brand."</td>";
					echo "<td>".$p_price."HKD</td>";
					echo "<td>".$p_descr."</td>";
					echo "<td>".$p_color."</td>";
					echo "<td>".$goods_num."</td>";
			?>

					<td><a href='delCart.php?goods_id=<?php echo $p_id; ?>'>Delete</a></td>
			<?php
					echo "</tr>";
					$singlePrice = $p_price * $goods_num;
					$totalPrice = $totalPrice + $singlePrice;
					$totalItem = $totalItem + $goods_num;
					setcookie("total_item",$totalItem);
					setcookie("phones_price",$totalPrice);
				}
			}
			//echo $p_info;
			setcookie('p_info',$p_info);
		?>
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td><a href='clearCart.php?goods_id=<?php echo $p_id; ?>'>Clear cart</a></td>
			<td>
				<?php
				echo "".$totalItem."   Items. ";
				echo "Totol prize: ".$totalPrice." HKD";
				?>
			</td>
		</tr>
	</table>
	<br>
	<a href='shipment.php'>Shipment</a>
	<br>
	<?php
}else{
	echo "The shop cart is empty!";
	?>
	<br><br>
	<a href='showPhones.php'>Back to add goods</a>
	<?php
}
?>


</body>
</html>
