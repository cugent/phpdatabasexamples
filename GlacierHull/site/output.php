<?php 
include '../includes/utility.php';
include '../includes/db_connect.php';
include '../includes/header.php';
?>




<div class="container bodyContainer img-rounded">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            

<table class="table table-hover" id="browseTable" style="margin-top:20px">
<?php


                echo '<th><a href="http://glacierhull.xyz/output.php?searchDateStart='.$_GET[searchDateStart].'&searchDateEnd='.$_GET[searchDateEnd].'&locationSearch='.$_GET[locationSearch].'&sort=shipName">Ship Name</a></th>';
				echo '<th>Cabin Type</th>';
				echo '<th>Capacity</th>';
				echo '<th><a href="http://glacierhull.xyz/output.php?searchDateStart='.$_GET[searchDateStart].'&searchDateEnd='.$_GET[searchDateEnd].'&locationSearch='.$_GET[locationSearch].'&sort=startLocation">Start Location</a></th>';
				echo '<th><a href="http://glacierhull.xyz/output.php?searchDateStart='.$_GET[searchDateStart].'&searchDateEnd='.$_GET[searchDateEnd].'&locationSearch='.$_GET[locationSearch].'&sort=endLocation">End Location</a></th>';
				echo '<th><a href="http://glacierhull.xyz/output.php?searchDateStart='.$_GET[searchDateStart].'&searchDateEnd='.$_GET[searchDateEnd].'&locationSearch='.$_GET[locationSearch].'&sort=price">Price</a></th>';
				echo "<th>Price per Addt'l guest</th>";
				echo '<th><a href="http://glacierhull.xyz/output.php?searchDateStart='.$_GET[searchDateStart].'&searchDateEnd='.$_GET[searchDateEnd].'&locationSearch='.$_GET[locationSearch].'&sort=startDate">Start Date</a></th>';
				echo '<th><a href="http://glacierhull.xyz/output.php?searchDateStart='.$_GET[searchDateStart].'&searchDateEnd='.$_GET[searchDateEnd].'&locationSearch='.$_GET[locationSearch].'&sort=endDate">End Date</a></th>';
				echo '<th><a href="http://glacierhull.xyz/output.php?searchDateStart='.$_GET[searchDateStart].'&searchDateEnd='.$_GET[searchDateEnd].'&locationSearch='.$_GET[locationSearch].'&sort="></a></th>';
?>
<?php
/*$sql="SELECT DISTINCT ci.startDateTime,ci.shipName,ca.type,ca.capacity,ci.location,ci.cruiseID,l.priceFirstTwoPassengers,l.priceExtraPassengers,l.available 
    FROM CruiseRouteInfo ci, Listing l, Cabin ca 
    WHERE startDateTime BETWEEN '".$_GET[searchDateStart]." 00:00:00' AND '".$_GET[searchDateEnd]." 00:00:00' AND location='".$_GET[locationSearch]."' AND l.cruiseID=ci.cruiseID AND l.cabinNum=ca.cabinNum AND l.available='1'";
*/
/*$sql="SELECT DISTINCT c.shipName,ca.type,st.location AS startLocation,end.location AS endLocation,c.startDateTime,c.endDateTime,l.priceFirstTwoPassengers,l.priceExtraPassengers,l.listingNum
    FROM Cruise c, Listing l, Cabin ca, Port st, Port end
    WHERE l.cruiseID=c.cruiseID AND l.cabinNum=ca.cabinNum AND c.startPortID=st.portID AND c.endPortID=end.portID";
*/
if(empty($_GET[searchDateStart]) && empty($_GET[searchDateEnd]))
{
    $sql="SELECT * FROM Browse WHERE (startLocation='".$_GET[locationSearch]."' OR endLocation='".$_GET[locationSearch]."') AND available='1'";
}
elseif(empty($_GET[locationSearch]))
{
    $sql="SELECT * FROM Browse WHERE startDateTime BETWEEN '".$_GET[searchDateStart]." 00:00:00' AND '".$_GET[searchDateEnd]." 00:00:00' AND available='1'";
}
elseif(!empty($_GET[searchDateStart]) && !empty($_GET[searchDateEnd]) && !empty($_GET[locationSearch]))
{
    $sql="SELECT * FROM Browse WHERE startDateTime BETWEEN '".$_GET[searchDateStart]." 00:00:00' AND '".$_GET[searchDateEnd]." 00:00:00' AND (startLocation='".$_GET[locationSearch]."' OR endLocation='".$_GET[locationSearch]."') AND available='1'";
}
else 
{
   output_to_console('Errored hard.');
   // redirect('www.glacierhull.xyz/browse.php'); 
}
$result = mysql_query($sql);
$numrows = mysql_num_rows($result);

if ($_GET['sort'] == 'shipName'){
				$sql .= " ORDER BY c.shipName;";
			// }elseif ($_GET['sort'] == 'cabinType'){
			// 	$sql .= " ORDER BY ca.Type;"; 
			}elseif ($_GET['sort'] == 'price'){
				$sql .=  " ORDER BY l.priceFirstTwoPassengers;";
			}elseif ($_GET['sort'] == 'startDate'){
				$sql .= " ORDER BY c.startDateTime;";
			}elseif ($_GET['sort'] =='startLocation'){
				$sql .= " ORDER BY startLocation;";
			}elseif ($_GET['sort'] =='endLocation'){
				$sql .= " ORDER BY endLocation;";
			}

for($i=0;$i<$numrows;$i++){ 
	$row=mysql_fetch_array($result);
    echo "<tr><td>".$row[shipName]."</td><td>".$row[type]."</td>";
        if($row[type]=="Suite")
        {
            $capacity=8;
        }
        else {
            $capacity=4;
        }
    echo "<td>$capacity</td><td>".$row[startLocation]."</td><td>".$row[endLocation]."</td><td>".$row[priceFirstTwoPassengers]."</td><td>".$row[priceExtraPassengers]."</td><td>".$row[startDateTime]."</td><td>".$row[endDateTime];
    $sql2="select DISTINCT listingNum FROM Listing WHERE cruiseID=".$row[cruiseID].";";
    $result2=mysql_query($sql2);
    $row2=mysql_fetch_array($result2);
    echo '<td>';
	echo '<a href="book.php?listingNum=', ($row2[listingNum]), '">Book Now</a>';
    echo '</td></tr>';

}
mysql_close($conn);
?>
</table>
        </div>
    </div>
</div>
<?php

include '../includes/footer.php';
?>

