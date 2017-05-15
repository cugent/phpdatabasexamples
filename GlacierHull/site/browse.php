
<?php include '../includes/header.php'; ?>
<?php include '../includes/db_connect.php'; ?>
<?php include '../includes/utility.php'; ?>
<div class="container bodyContainer img-rounded">
    
    
    	<div class="row">
    		<?php $_SERVER['REQUEST_URI']; ?>
		<form action="output.php" method="GET">
			<div class="row">
			    <div class="col-sm-10 col-sm-offset-1">
				<div class="col-sm-offset-2 col-sm-5 form-inline" id="datepicker_search">
					<div class="form-inline">
						<input type="date" class="form-control" name="searchDateStart">
						<span class="glyphicon glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
						<input type="date" class="form-control" name="searchDateEnd">
					</div>
				</div>
				<div class="col-sm-3 pull-right" id="search_location">
					<div class="input-group ">
						<span class="input-group-btn">
							<button class="btn btn-default" type="submit">
								<span class="glyphicon glyphicon-search" aria-hidden="true" aria-label="Search"></span>
							</button>
						</span>
						<input type="text" class="form-control" name="locationSearch" placeholder="Search Location...">
					</div>
				</div>
				</div>
			</div>
		</form>
	</div>

	<div class="col-md-10 col-md-offset-1">
<?php 

if ($_GET)

//Sort the table 
?>
			
			<table class="table table-hover" id="browseTable">
				
				<?php 
					if ($_GET['sort'] == 'shipName'){
				?>		
					<th><a href="browse.php?sort=reverseShipName">Ship Name</a></th>
				<?php
					} else { ?>
						<th><a href="browse.php?sort=shipName">Ship Name</a></th>
				<?php	}
				?>
				
				<th>Cabin Type</th>
				
				<?php 
					if ($_GET['sort'] == 'startLocation'){
				?>		
					<th><a href="browse.php?sort=reverseStartLocation">Start Location</a></th>
				<?php
					} else { ?>
						<th><a href="browse.php?sort=startLocation">Start Location</a></th>
				<?php	}
				?>
				<?php 
					if ($_GET['sort'] == 'endLocation'){
				?>		
					<th><a href="browse.php?sort=reverseEndLocation">End Location</a></th>
				<?php
					} else { ?>
						<th><a href="browse.php?sort=endLocation">End Location</a></th>
				<?php	}
				?>
				
				<?php 
					if ($_GET['sort'] == 'price'){
				?>		
					<th><a href="browse.php?sort=reversePrice">Price</a></th>
				<?php
					} else { ?>
					<th><a href="browse.php?sort=price">Price</a></th>
				<?php	}
				?>
				<th>Extra Person</th>
				<?php 
					if ($_GET['sort'] == 'date'){
				?>		
					<th><a href="browse.php?sort=reverseDate">Date</a></th>
				<?php
					} else { ?>
						<th><a href="browse.php?sort=date">Date</a></th>
				<?php	}
				?>

				
		<?php

//Select Statement
		$sql = "SELECT DISTINCT c.shipName,ca.type,st.location AS startLocation,
					end.location AS endLocation,c.startDateTime,c.endDateTime,
					l.priceFirstTwoPassengers,l.priceExtraPassengers,l.listingNum
					FROM Cruise c, Listing l, Cabin ca, Port st, Port end
					WHERE l.cruiseID=c.cruiseID AND l.cabinNum=ca.cabinNum
					AND c.startPortID=st.portID AND c.endPortID=end.portID 
					AND l.available = '1'";
			
			// if ($_GET['sort'] == 'shipName'){
			// 	$sql .=  " ORDER BY c.shipName;";
			// } elseif []
			
			//Sort
			switch ($_GET['sort']) {
				case 'shipName':
					$sql .=  " ORDER BY c.shipName;";
					break;
				case 'reverseShipName':
					$sql .=  " ORDER BY c.shipName DESC;";
					break;
				case 'startLocation':
					$sql .= " ORDER BY startLocation;";
					break;
				case 'reverseStartLocation':
					$sql .= " ORDER BY startLocation DESC;";
					break;
				case 'endLocation':
					$sql .= " ORDER BY endLocation;";
					break;
				case 'reverseEndLocation':
					$sql .= " ORDER BY endLocation DESC;";	
					break;
				case 'price':
					$sql .= " ORDER BY priceFirstTwoPassengers;";
					break;
				case 'reversePrice':
					$sql .= " ORDER BY priceFirstTwoPassengers DESC;";
					break;
				case 'date':
					$sql .= " ORDER BY c.startDateTime;";
					break;
				case 'reverseDate':
					$sql .= " ORDER BY c.startDateTime DESC;";
					break;
				default:
					// code...
					break;
			}
			
			// if ($_GET['sort'] == 'shipName'){
			// 		$sql .=  " ORDER BY c.shipName;";
			// 		$sql .=  " ORDER BY c.shipName DESC;";
			// 	}
			// // }elseif ($_GET['sort'] == 'cabinType'){
			// // 	$sql .= " ORDER BY ca.Type;"; 
			// }elseif ($_GET['sort'] == 'price'){
			// 	if ($priceSort == 0)
			// 	{
			// 		$sql .=  " ORDER BY l.priceFirstTwoPassengers;";
			// 		$priceSort == 1;
			// 	}
			// 	else 
			// 	{
			// 		$sql .=  " ORDER BY l.priceFirstTwoPassengers DESC;";
			// 		$priceSort == 0;
			// 	}
			// }elseif ($_GET['sort'] == 'startDate'){
			// 	if($startDateSort == 0)
			// 	{
			// 		$sql .= " ORDER BY c.startDateTime;";
			// 		$startDateSort == 1;
			// 	}
			// 	else 
			// 	{
			// 		$sql .= " ORDER BY c.startDateTime DESC;";
			// 		$startDateSort == 0;
			// 	}
			// }elseif ($_GET['sort'] =='startLocation'){
				
			// if ($startLocationSort == 0)
			// 	{
			// 	$sql .= " ORDER BY startLocation;";
			// 	$startLocationSort == 1;
					
			// 	}
			// 	else 
			// 	{
			// 		$sql .= " ORDER BY startLocation DESC;";
			// 		$startLocationSort == 0;
			// 	}
			// }elseif ($_GET['sort'] =='endLocation'){
			// 	if($endLocationSort == 0)
			// 	{
			// 		$sql .= " ORDER BY endLocation;";
			// 		$endLocationSort == 1;
			// 	}
			// 	else 
			// 	{
			// 		$sql .= " ORDER BY endLocation DESC;";
			// 		$endLocationSort == 0;
					
			// 	}
			// }
			
						
			$result = mysql_query($sql);
			
			$numrows = mysql_num_rows($result);
			
			for($i=0;$i<$numrows;$i++){
				$row=mysql_fetch_array($result);
				echo '<tr>';
				echo '<td>',($row[shipName]),'</td>';
				echo '<td>',($row[type]),'</td>';
				echo '<td>',($row[startLocation]),'</td>';
				echo '<td>',($row[endLocation]),'</td>';
				echo '<td class="price">',($row[priceFirstTwoPassengers]),'</td>';
				echo '<td class="price">',($row[priceExtraPassengers]),'</td>';
				$phpdate = strtotime( $row[startDateTime] );
				echo '<td>',(date( 'M d, Y', $phpdate )),'</td>';
				echo '<td>';
				echo '<a href="book.php?listingNum=', ($row[listingNum]), '">Book Now</a>';
				echo '</td>';
				echo '</tr>';
			}
			
			mysql_close($conn);
	?>
		
		</table>
	</div>
</div>
<?php include '../includes/footer.php'; ?>