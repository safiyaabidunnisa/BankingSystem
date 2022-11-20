<?php
include("../php/db_connect.php");
include("../php/homepage.php");

echo "<html>
		<body style='padding-left:10px'><br>
			<div class='transferForm1'>
				<div class='transferForm'>
					<form method='post'>
						<table cellspacing=1px style='border:none;'>
							<caption>Transfer</caption>
							<tr>
								<td style='border:none;'><span>From:</span></td>
								<td style='border:none;'><select name='sender' id='sender'>";

$query="select Name from customer";
$result=mysqli_query($con,$query);

if(isset($_REQUEST["checkBal"]) || isset($_REQUEST["transfer"]))
	echo "<option value=".$_POST["sender"].">".$_POST["sender"]."</option>";

while($row=mysqli_fetch_assoc($result))
{
	echo "<option value=".$row["Name"].">".$row["Name"]."</option>";
}
					
echo "</select></td>";

echo "<td style='border:none;'><button name='checkBal'>Check Balance</button></td>";

$senderUser="";
if(isset($_REQUEST["checkBal"]))
{
	$senderUser=$_POST["sender"];
	$balQuery="select Balance from customer where Name='".$senderUser."'";
	$balResult=mysqli_query($con,$balQuery);

	if(mysqli_num_rows($balResult) == 1)
	{
		
		$balRow = mysqli_fetch_assoc($balResult);
		echo "<td style='border:none;'><span>".$balRow["Balance"]."</span></td></tr>";	
	}
}

echo "<br><br>
		<tr>
			<td style='border:none;'><span>To: </span></td>
			<td style='border:none;'><select name='receiver' id='receiver'>";

$receiverQuery="select Name from customer";
$receiverResult=mysqli_query($con,$receiverQuery);

if(isset($_REQUEST["transfer"]) || isset($_REQUEST["checkBal"]))
	echo "<option value=".$_POST["receiver"].">".$_POST["receiver"]."</option>";

while($receiverRow=mysqli_fetch_assoc($receiverResult))
{
	echo "<option value=".$receiverRow["Name"].">".$receiverRow["Name"]."</option>";
}
					
echo "</select></td></tr>";

echo "<tr>
		<td style='border:none;'><label for='amount'><span>Amount:</span></label></td>
		<td style='border:none;'><input type='number' name='amount' placeholder='Amount to transfer'></td></tr>";

echo "<tr><td colspan='2' style='border:none;'><button id='transfer' name='transfer'><font color='#f9936f'> Transfer</font></button></td></tr>";


if(isset($_REQUEST["transfer"]))
{
	$sufficientBalance=0;
	$amountEmp=0;
	$receiverUser=$_POST["receiver"];
	$toSend=$_POST["amount"];
	$senderUser=$_POST["sender"];

	$senderExecute=false;
	$receiverExecute=false;

	$balQuery="select Balance from customer where Name='".$senderUser."'";
	$balResult=mysqli_query($con,$balQuery);

	if(mysqli_num_rows($balResult) == 1)
	{
		$balRow = mysqli_fetch_assoc($balResult);
		if($toSend>$balRow["Balance"])
		{
			$sufficientBalance=1;
			echo "<script>
					alert('Insufficient Balance.');</script>";
		}

	}

	if($sufficientBalance==0)
	{
		if($toSend=="")
		{
			$amountEmp=1;
			echo "<script>alert('Enter amount to send');</script>";
		}
		
		else
		{

			$transferQuerySender="update customer set Balance=Balance-".$toSend." where Name='".$senderUser."'";
			$senderExecute=mysqli_query($con,$transferQuerySender);

			$transferQueryReceiver="update customer set Balance=Balance+".$toSend." where Name='".$receiverUser."'";
			$receiverExecute=mysqli_query($con,$transferQueryReceiver);
		}
	}
			
	if($amountEmp==0)
	{
			if($senderExecute && $receiverExecute && $sufficientBalance==0)
			{
			
				echo "<script>alert('Transaction Success.....')</script>";
				$insQuery="insert into transactions(Sender,Receiver,Amount,Status) values('".$senderUser."','".$receiverUser."',".$toSend.",'Success')";
				$insExecute=mysqli_query($con,$insQuery);
				echo "<script>function clear()
							{
								document.getElementById('sender').value='';
								document.getElementById('receiver').value='';
							}
					</script>";
				echo "<script>clear();</script>";
			}
			else
			{
				echo "<script>alert('Transaction Failed!')</script>";
				$insQuery="insert into transactions(Sender,Receiver,Amount,Status) values('".$senderUser."','".$receiverUser."',".$toSend.",'Failed')";
				$insExecute=mysqli_query($con,$insQuery);
				echo "<script>function clear()
							{
								document.getElementById('sender').value='';
								document.getElementById('receiver').value='';
							}
					</script>";
				echo "<script>clear();</script>";
			}
		}
	}

echo "</table></form></div></div></body></html>"

?>