<?php
header("Content-type: text/html; charset=utf-8");
include("conn.php");
echo "Connected";
session_start(); // Starting Session
		$order = $_POST["ordernumber"];

		if ($_POST["ordernumber"]!="")
		{	
		$query2="SELECT OrderMaster.Status, UserMaster.UserName, UserMaster.Email, UserMaster.Phone, UserMaster.Address, UserMaster.Type, UserMaster.Verified, OrderMaster.ODate
		FROM  `OrderMaster` 
		INNER JOIN UserMaster ON OrderMaster.OUserId = UserMaster.UserId
		WHERE OrderMaster.ONo = '$order'";
		$ses_sql=mysql_query($query2);
		$row = mysql_fetch_assoc($ses_sql);
		//echo'<pre>';print_r($row);

		$date =$row['ODate'];
		$name =$row['UserName'];
		$email =$row['Email'];
		$phone =$row['Phone'];
		$address =$row['Address'];
		$type =$row['Type'];
		$verify =$row['Verified'];
		$ordetStatus2=$row['Status'];
		if ($verify=="0"){
			$verify_status ='No';
		}else{
			$verify_status ='Yes';
		}
	
		$output .= '<div id="Customer-detail"><h2>Order Details</h2><p>User :'.$name.'</p></p>Email :'.$email.'</p></p>Phone  :'.$phone.'</p></p>Address  :'.$address.'</p></p>Order Status  :'.$ordetStatus2.'</p></p> Varified:'.$verify_status.'</div>';
		
		$query = mysql_query("SELECT Name,CartHistory.Quantity as Quantity,CartHistory.TotalPrice as TotalPrice FROM `OrderMaster` inner join CartHistory on OrderMaster.Ono = CartHistory.Ono
		inner join vegetablemaster on CartHistory.ProductId=vegetablemaster.ProductID
		where OrderMaster.Ono='$order'");

		$output .='<div class="order-section">';
		if (mysql_num_rows($query)>0)
		{
		// Fetch one and one row
		$output .="<ul><li><h2>Order Details</h2></li>";
		$output .="<li><span class=\"heading\">Product</span><span class=\"heading\">Quantity</span><span class=\"heading\">Price</span></li>";
		while ($row=mysql_fetch_assoc($query))
		{
		$output .="<li><span class=\"vals\">".$row["Name"]."</span>";
		$output .="<span class=\"vals\">".$row["Quantity"]."</span>";
		$output .="<span class=\"vals\">".$row["TotalPrice"]."</span></li>";
		}

		// Free result set
		//mysql_free_result($result);
		}
		else
		{
		$output .="<li>No records Available</li>";	
		}
		$output .="</ul></div>"	;
		}
		echo $output;
		mysql_close($con);

?>
