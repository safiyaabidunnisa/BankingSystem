<?php
include("../php/db_connect.php");
include("../php/homepage.php");


$query="select * from transactions";
$result=mysqli_query($con,$query);

echo "<div class='custTable'>
	<table class='table'><caption>Transaction History</caption>
		<tr>
			<th>Transaction ID</th>
			<th>Sender</th>
			<th>Receiver</th>
			<th>Amount</th>
			<th>Timestamp</th>
			<th>Status</th>
		</tr>";

while($row=mysqli_fetch_assoc($result))
{
	echo "<tr>
			<td>".$row["ID"]."</td>
			<td>".$row["Sender"]."</td>
			<td>".$row["Receiver"]."</td>
			<td>".$row["Amount"]."</td>
			<td>".$row["dateTime"]."</td>
			<td>".$row["Status"]."</td>
			</tr>";
}

echo "</table></div>";
?>