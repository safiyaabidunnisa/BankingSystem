<?php
include("../php/db_connect.php");
include("../php/homepage.php");


$query="select * from customer";
$result=mysqli_query($con,$query);


//----------------------------------------------
echo "<form method='post'>
						<table cellspacing=1px style='border:none;'>
							<caption>Get Details</caption>
							<tr>
								<td style='border:none;'><span>From:</span></td>
								<td style='border:none;'><select name='sender' id='sender'>";

$query2="select Name from customer";
$result2=mysqli_query($con,$query);

if(isset($_REQUEST["getDet"]))
	echo "<option value=".$_POST["sender"].">".$_POST["sender"]."</option>";

while($row2=mysqli_fetch_assoc($result2))
{
	echo "<option value=".$row2["Name"].">".$row2["Name"]."</option>";
}
					
echo "</select></td>";

echo "<td style='border:none;'><button name='getDet'>Get Details</button></td></tr></table>";

$senderUser="";

if(isset($_REQUEST["getDet"]))
{
	echo "<table><tr>
		<th>ID</th>
		<th>Name</th>
		<th>Email</th>
		<th>Current Balance</th>
	</tr>";
	$senderUser=$_POST["sender"];
	$balQuery="select * from customer where Name='".$senderUser."'";
	$balResult=mysqli_query($con,$balQuery);

	if(mysqli_num_rows($balResult) == 1)
	{
		
		$balRow = mysqli_fetch_assoc($balResult);
		echo "<tr><td style='border:none;'><span>".$balRow["ID"]."</span></td>
				<td style='border:none;'><span>".$balRow["Name"]."</span></td>
				<td style='border:none;'><span>".$balRow["Email"]."</span></td>
				<td style='border:none;'><span>".$balRow["Balance"]."</span></td>
		</tr>";	
	}
}
echo "</table></form>";
//----------------------------------------------
echo "
		<div class='custTable'>
			<table class='table'><caption>Customer Details</caption>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Email</th>
					<th>Current Balance</th>
				</tr>";

while($row=mysqli_fetch_assoc($result))
{
	echo "<tr>
			<td>".$row["ID"]."</td>
			<td>".$row["Name"]."</td>
			<td>".$row["Email"]."</td>
			<td>".$row["Balance"]."</td>
			</tr>";
}

echo "</table></div>";
?>