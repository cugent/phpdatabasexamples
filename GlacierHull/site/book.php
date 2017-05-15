<?php include '../includes/header.php'; ?>
<?php include '../includes/db_connect.php'; ?>

<div class="container bodyContainer img-rounded">
<?php
    $listingNum = $_GET[listingNum];

    // first name
    // middle name
    // last name
    // phone num
    // passport
    // email
    // credit card num
    // disability
    $sql="SELECT priceFirstTwoPassengers, priceExtraPassengers FROM Listing WHERE listingNum=$listingNum";
    $result = mysql_query($sql);
    $row=mysql_fetch_array($result);

	echo"<div class='row'>";
		echo "<div class='col-md-10 col-md-offset-1 img-rounded' id='bookForm'>";
			echo "<legend>Pricing Information</legend>";
			echo "<p><font size=3>Price For First Two Customers: $row[priceFirstTwoPassengers]</font></p>";
			echo "<p><font size=3>Price Per Extra Customer: $row[priceExtraPassengers]</font></p>";
		echo "</div>";
	echo "</div>";

?>


	<div class="row">
		<div class="col-md-10 col-md-offset-1 img-rounded" id="bookForm">
		  <!--<p>-->
		    <form action="confirm.php" method="POST" class="form-horizontal">

<legend>Customer Information</legend>
			<div class="form-group">
		        <label for="firstName" class="control-label col-xs-2">First Name</label>
        	<div class="col-xs-10">
            	<input type="text" class="form-control" id="firstName" name ="firstName" placeholder="First Name">
        	</div>
    		</div>


			<div class="form-group">
		        <label for="middleName" class="control-label col-xs-2">Middle Name</label>
        	<div class="col-xs-10">
            	<input type="text" class="form-control" id="middleName" name ="middleName" placeholder="Middle Name">
        	</div>
    		</div>

			<div class="form-group">
		        <label for="lastName" class="control-label col-xs-2">Last Name</label>
        	<div class="col-xs-10">
            	<input type="text" class="form-control" id="lastName" name ="lastName" placeholder="Last Name">
        	</div>
    		</div>

			<div class="form-group">
		        <label for="phoneNum" class="control-label col-xs-2">Phone #</label>
        	<div class="col-xs-10">
            	<input type="tel" class="form-control" id="phoneNum" name ="phoneNum" placeholder="Phone Number">
        	</div>
    		</div>

			<div class="form-group">
		        <label for="passportNum" class="control-label col-xs-2">Passport #</label>
        	<div class="col-xs-10">
            	<input type="text" class="form-control" id="passportNum" name ="passportNum" placeholder="Passport Number">
        	</div>
    		</div>
    		
			<div class="form-group">
		        <label for="emailAddress" class="control-label col-xs-2">Email</label>
        	<div class="col-xs-10">
            	<input type="email" class="form-control" id="emailAddress" name ="emailAddress" placeholder="Email Address">
        	</div>
    		</div>    		

			<div class="form-group">
		        <label for="creditCardNum" class="control-label col-xs-2">CC #</label>
        	<div class="col-xs-10">
            	<input type="text" class="form-control" id="creditCardNum" name = "creditCardNum" placeholder="Credit Card Number">
        	</div>
    		</div>

		            <input type="hidden" name="listingNum" value="<?php echo$_GET[listingNum]; ?>">
		        <div class="form-group">
		        	<label for="discountCode" class="control-label col-xs-2">Discount Code</label>
		        <div class="col-xs-10">	
		        	<input type="text" class="form-control" id="discountCode" name="discountCode" placeholder="Enter Discount Code Here">
		        </div>
		        </div>


			<div class="form-group">
				<div class="col-xs-offset-2 col-xs-10">
					<div class="checkbox">
						<label><input type ="checkbox" class="form-contol" id="disabilityAssistance" name="disabilityAssistance" value="1">Disability Assistance Required?</label>
					</div>
				</div>
			</div>



    <legend>Emergency Contact Information</legend>


<div class="form-group">
	<label for="eFirstName" class="control-label col-xs-2">First Name</label>
	<div class="col-xs-10">
		<input type="text" class="form-control" id="eFirstName" name ="eFirstName" placeholder="Contact First Name">
	</div>
</div>

<div class="form-group">
	<label for="eMiddleName" class="control-label col-xs-2">Middle Name</label>
	<div class="col-xs-10">
		<input type="text" class="form-control" id="eMiddleName" name ="eMiddleName" placeholder="Contact Middle Name">
	</div>
</div>

<div class="form-group">
	<label for="eLastName" class="control-label col-xs-2">Last Name</label>
	<div class="col-xs-10">
		<input type="text" class="form-control" id="eLastName" name ="eLastName" placeholder="Contact Last Name">
	</div>
</div>

			<div class="form-group">
		        <label for="ePhoneNum" class="control-label col-xs-2">Phone #</label>
        	<div class="col-xs-10">
            	<input type="tel" class="form-control" id="ePhoneNum" name ="ePhoneNum" placeholder="Contact Phone Number">
        	</div>
    		</div>
    		
			<div class="form-group">
		        <label for="eEmailAddress" class="control-label col-xs-2">Email</label>
        	<div class="col-xs-10">
            	<input type="email" class="form-control" id="eEmailAddress" name ="eEmailAddress" placeholder="Contact Email Address">
        	</div>
    		</div> 		            
	<div class="form-group">
		<label for="eRelation" class="control-label col-xs-2">Relation</label>	
		<div class="col-xs-10">
			<select class="form-control" name="eRelation" id="eRelation">
			  <option value=0>-Please Select Relationship-</option>
			  <option value="Relative">Relative</option>
			  <option value="Pet">Pet</option>
			  <option value="Spouse">Spouse</option>
			  <option value="Friend">Friend</option>
			  <option value="Stranger">Stranger</option>
			</select>		  
		</div>
		            
</div>
		   <div class="col-xs-offest-10 col-xs-2 pull-right" id="submitButton">
		        <button type="submit" class="btn btn-primary">Submit</button>
		        </div>
		    <!--</p>-->
		    </form>
		</div>
	</div>
</div>


<?php include '../includes/footer.php'; ?>