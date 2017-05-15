<?php include '../includes/header.php'; ?>
<?php include '../includes/db_connect.php'; ?>
<?php include '../includes/utility.php'; ?>




<div class="container bodyContainer">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">

<?php
    echo "<style>
            table 
            {
            border: 1px solid black;
            background-color: transparent;
            border-spacing: 0;
            border-collapse: collapse;
            box-sizing: border-box;
            width: 100%;
            max-width: 100%;
            margin-bottom: 20px;
            

            }</style>"; 
    $discountValue;
   //Creating a new customer
    $sql = "INSERT INTO Customer (customerID, firstName, middleName, lastName, phoneNum, passportNum, emailAddress, creditCardNum, disabilityAssistance)
            VALUES(NULL,'$_POST[firstName]','$_POST[middleName]','$_POST[lastName]','$_POST[phoneNum]','$_POST[passportNum]','$_POST[emailAddress]','$_POST[creditCardNum]','$_POST[disabilityAssistance]');";
    $result=mysql_query($sql);
   
    if(!$result)
    {
        die('Could not process your information: ' . mysql_error());
    
    }
    $customerID=mysql_insert_id();
    
        //Inserting into Emergency Contact info
    $sql =  "INSERT INTO EmergencyContact (customerID, firstName, middleName, lastName,relationship,phoneNum,emailAddress)
            VALUES('$customerID','$_POST[eFirstName]','$_POST[eMiddleName]','$_POST[eLastName]','$_POST[eRelation]','$_POST[ePhoneNum]','$_POST[eEmailAddress]');";
    $result=mysql_query($sql);
    
    if(!$result)
    {
        die('Error creating Reservation: ' . mysql_error());
    }
  
    //Preparing date and $amountPaid and discountCode
    date_default_timezone_set('USA/Chicago');
    $date = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $date)));
    $sql = "SELECT priceFirstTwoPassengers FROM Listing WHERE listingNum='$_POST[listingNum]' LIMIT 1;";
    $result=mysql_query($sql);
    if(!$result)
    {
        die('Error getting price of booking: '.mysql_error());
    }
    $row=mysql_fetch_array($result);
    $amountPaid=$row[priceFirstTwoPassengers];
 
    $sql =  "INSERT INTO Transaction (customerID, itemID, transactTime, amountPaid, discountCode)
            VALUES ('$customerID','2','$date','$amountPaid'";
    
    if($_POST[discountCode] == "") // Check if discountCode was submitted
    {
        $sql .= ", NULL);";
    } else
    {
        $discountCode = strtoupper($_POST[discountCode]);
        $result = mysql_query("SELECT * FROM Discount WHERE discountCode='$discountCode' LIMIT 1");
        $row = mysql_fetch_array($result);
        if($row == 0) // check if discountCode is found in DB - 
        { 
            $sql .= ", NULL);";
            $discountValue = 0;
        } else { // Successfully found discountCode
            
            if($row[flatReduction] == 0){
                // transactionPrice * $row[percentageReduction
            $discountValue = $amountPaid * ($row[percentageReduction] /100);
            } elseif ($row[percentageReduction] == 0){
                // transactionPrice - flatReduction
                $discountValue = $row[flatReduction];
        }
            $sql .= ", '$discountCode');";
        }
    };
    
    if ($_POST[disabilityAssistance] == 1)
    {
        $disabilityRequired = "True";
    }
    else 
    {
        $disabilityRequired = "False";    
    }

    //
    $result=mysql_query($sql);
    
    if(!$result)
    {
        die('Error creating Transaction: ' . mysql_error());
    }
    
    
    
    //Acquiring new TransactionID
    $transactionID= mysql_insert_id();
    
    
    //Check transaction
    if(!$transactionID)
    {
        die('Error getting transactionID: '.mysql_error());
    }
    
    //Inserting values into Reservation table
    $sql =  "INSERT INTO Reservation (customerID, itemID, transactionID, listingNum)
            VALUES('$customerID','2','$transactionID','$_POST[listingNum]');";
    $result=mysql_query($sql);
    
    if(!$result)
    {
        die('Error creating Reservation: ' . mysql_error());
    }
    $priceAfterReduction = $amountPaid - $discountValue;
    
    //Make listing unavailable
    $sql = "UPDATE Listing set AVAILABLE = 0 WHERE listingNum='$_POST[listingNum]'";
    $result=mysql_query($sql);
    if(!$result)
    {
        die('Error making listing unavailable: ' . mysql_error());
    }
    
    //Print out the confirmation information to let them know it was succesfully added to the database
    echo "<p> <strong> Congratulations you booked a cruise. Your Transaction ID is:  $transactionID. <br>";
    echo               "Your customerID is: $customerID. </strong></p>";
    
    echo "<table>"; 
    echo  "<col width=700>";
    echo "<th> Type";
    echo "</th>";
    echo "<th> Information";
    echo "</th>";
    
    echo "<tr>";
   
   
    echo "<td>First Name";
    echo "</td>";
    
    echo "<td> $_POST[firstName]";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td>Middle Name";
    echo "</td>";
    
    echo "<td> $_POST[middleName]";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td>Last Name";
    echo "</td>";
    
    echo "<td> $_POST[lastName]";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td>Phone Number";
    echo "</td>";
    
    echo "<td> $_POST[phoneNum]";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td>Passport Number";
    echo "</td>";
    
    echo "<td> $_POST[passportNum]";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td>Email";
    echo "</td>";
    
    echo "<td> $_POST[emailAddress]";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td> Credit Card Number";
    echo "</td>";
    
    echo "<td> $_POST[creditCardNum]";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td> Discount Code";
    echo "</td>";
    
    echo "<td> $_POST[discountCode]";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td> Discount Value";
    echo "</td>";
    
    echo "<td> $discountValue";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td> Disability Assistance Required";
    echo "</td>";
    
    echo "<td>  $disabilityRequired";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td> Emergency Contact First Name";
    echo "</td>";
    
    echo "<td> $_POST[eFirstName]";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td> Emergency Contact Middle Name";
    echo "</td>";
    
    echo "<td> $_POST[eMiddleName]";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td> Emergency Contact Last Name";
    echo "</td>";
    
    echo "<td> $_POST[eLastName]";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td> Emergency Contact Relationship Type    ";
    echo "</td>";
    
    echo "<td> $_POST[eRelation]";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td> Emergency Contact Phone Number";
    echo "</td>";
    
    echo "<td> $_POST[ePhoneNum]";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td> Emergency Contact Email Address";
    echo "</td>";
    
    echo "<td> $_POST[eEmailAddress]";
    echo "</td>";
    echo "</tr>";
    
    echo "<tr>";
    echo "<td> Total Paid";
    echo "</td>";
    
    echo "<td>  $priceAfterReduction";
    echo "</td>";
    echo "</tr>";
    
    echo "</table>";
    echo "<h1> Enjoy Your Stay!</h1>";
    echo "<h2>If you require Customer Support, we have suspended this service to save you money!</h2>";
    
    
 
    
    
    mysql_close($conn);
?>   



</div>
</div>
</div>

<?php include '../includes/footer.php'; ?>
