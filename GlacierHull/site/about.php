<?php include '../includes/header.php'; ?>
<?php include '../includes/db_connect.php'; ?>

<?php 

// function get_ports_from_

//  Select Port.location
//      FROM Port, Route, Cruise, Listing
//     WHERE Listing.listingNum = 1 AND
//      Listing.cruiseID = Cruise.cruiseID AND
//      Cruise.routeID = Route.routeID AND
//      Route.portID = Port.portID;

?>


<div class="container bodyContainer img-rounded">
<div class="row">
    <div class="col-sm-offset-2 col-sm-8" style="background-color:white;">
        
       <center><h1>We are the cheapest cruise line on the market!</h1>
       <h3>How do we do it you might ask? </h3> </center>
       <p>
       <ul>
         <li>We offer a large variety of time-share promotions on each of our ships, available after a brief 15 minute presentation, with an opportunity for a 
         <small>small</small> discount.</li>
         <li> Each room comes stocked with promotional items which are designed to fit your every capitalistic need.</li> 
         <li> Each Amenity and Excursion on the ship is sponsored by a different family-friendly corporation! </li>
         <li> We pass all these corporate savings on to you!</li>
       </ul>
        </p>
        
        <h1> About Us</h1>
        <p>
            Glacier Hull Cruises, NLC was founded in 2000 by four young men looking to make cruises affordable for everyone. <br>
            We are based out of Dekalb IL, and have 15 part-time employees working for the company. <br>
            We are a NLC company, which means we take <small><small><small> no liability for any damages done to you, your property, or your person,</small></small></small> but we guarantee that your safety
            is our number one priority! <br>
            Our cruises are safe and secure, with no fatal accidents in the past 30 days. Additionally, we boast that a whopping 75% of our cruises make it to their destinations!<br>
        </p>
        
        <h1>Reviews</h1>
        <p><em> "I didn't die, so it was great!"</em> 4 Stars, <br>
           <b>Cruise Reviewer Enterprises</b>
            <br> <br>
            
            <em>"I really liked all the branding on everything in my room, reall made the S.S Amazon feel like I was shopping on Amazon"</em> 4 Stars, <br>
            <b>Cruise Weekly</b>
            
              <br> <br>
            <em>"I think the coast guard made a promotional deal to save me money, we needed coast guard assistance 4 times on our cruise"</em>, 5 Stars, <br>
            <b>Cruiseline Nightly</b>
            <br> <br>
            
            <em>"The cafeteria had really good soylent!"</em>, 3.5 Stars, <br>
            <b>GMO Bros.</b>
            </p>
            <br />
            <br />
            <small><small><small>All reviews have gone through a rigorous screening process to ensure their accuracy.</small></small></small>
            <br />
            <small><p>All reviews sponsored in part by Glacier Hull Cruises, NLC</p></small>
    </div>
</div>
</div>


<?php include '../includes/footer.php'; ?>