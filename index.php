<?php
// Include the database connection file
require_once 'connect.php';

// Open the database connection
$conn = OpenCon();

// Check if the search query is provided
$searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';

// Prepare the SQL query based on the search query
$sql = "SELECT p.propid, p.lid, p.pname, p.paddress, p.pmaplink, p.pmobile, p.pdescription, p.pprice
        FROM properties p
        JOIN propertyapproval pa ON p.propid = pa.propid
        WHERE pa.status = 'Approved' AND (p.pname LIKE '%$searchQuery%' OR p.paddress LIKE '%$searchQuery%')
        ORDER BY p.propid DESC";

$result = $conn->query($sql);

// Close the database connection
CloseCon($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://kit.fontawesome.com/64a0021d5a.js" crossorigin="anonymous"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <link rel="stylesheet" href="CSS/index.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAtF7uzmN1c5f5nMA2UIUceJ57cq1tnSGs&callback=initMap" async defer></script>
</head>
<body> 
    <section>
            
            <div id="wrapper">
            <!-- Sidebar -->
                <div id="sidebar-wrapper">
                    <ul class="sidebar-nav" style="margin-left:0;">
                        <li class="sidebar-brand">
                        <a href="#menu-toggle"  id="menu-toggle" style="margin-top:20px;float:revert;" > <i class="fa fa-bars " style="font-size:20px !Important;" aria-hidden="true" aria-hidden="true"></i> 
                        </li>
                        <div class="sidebar-i">
                            <p class="side-bar-titles">Students</p>
                            <li><a href="StudentSignup.php"><i class="fa-solid fa-right-to-bracket" aria-hidden="true"> </i> <span style="margin-left:10px;">Register as a Student</span>  </a></li>
                            <li><a href="StudentLogin.php"> <i class="fa-solid fa-user" aria-hidden="true"> </i> <span style="margin-left:10px;"> Login as a Student</span> </a></li>

                            <p class="side-bar-titles">Landlords</p>
                            <li><a href="LandlordSignup.php"> <i class="fa-solid fa-right-to-bracket" aria-hidden="true"> </i> <span style="margin-left:10px;"> Register as a Landlord</span> </a> </li>
                            <li><a href="LandlordLogin.php"> <i class="fa-solid fa-user" aria-hidden="true"> </i> <span style="margin-left:10px;"> Login as a Landlord</span> </a></li>

                            <p class="side-bar-titles">Warden</p>
                            <li><a href="wardenlogin.php"><i class="fa-solid fa-user" aria-hidden="true"> </i> <span style="margin-left:10px;">Login as Warden</span> </a></li>
                        

                            <p class="side-bar-titles">Articles</p>
                            <li><a href="articlelist.php"><i class="fa-solid fa-newspaper" aria-hidden="true"> </i> <span style="margin-left:10px;">View Articles </span> </a></li>
                        </div>
                        
                    </ul>
                </div>
                <!-- /#sidebar-wrapper -->


                <div class="p-content">
                <div class="row">
                    <div class="col-md-4">
                        <div class="serch-bar" style="padding-bottom: 25px;">
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
                                <div class="InputContainer">
                                    <input type="text" name="search" class="input" id="input" placeholder="Search" value="<?php echo $searchQuery; ?>">
                                    <label for="input" class="labelforsearch">
                                        <svg viewBox="0 0 512 512" class="searchIcon"><path d="M416 208c0 45.9-14.9 88.3-40 122.7L502.6 457.4c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L330.7 376c-34.4 25.2-76.8 40-122.7 40C93.1 416 0 322.9 0 208S93.1 0 208 0S416 93.1 416 208zM208 352a144 144 0 1 0 0-288 144 144 0 1 0 0 288z"></path></svg>
                                        <button type="submit" class="search-button"></button>
                                    </label>
                                    <div class="border"></div>
                                </div>
                            </form>
                        </div>

                        <div class="bording-place" style="padding-left: 20px;">
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $propid = $row["propid"];
                                    $pname = $row["pname"];
                                    $paddress = $row["paddress"];
                                    $pmaplink = $row["pmaplink"];
                                    $pmobile = $row["pmobile"];
                                    $pprice = $row["pprice"];
                                    $pdescription = $row["pdescription"];
                            ?>
                                    <div class="b-place">
                                        <div class="l-address-req">
                                            <div class="l-details">
                                                <h2 class="l-name" data-maplink="<?php echo $pmaplink; ?>" data-description="<?php echo $pdescription; ?>"><?php echo $pname; ?></h2>
                                                <p class="l-price">Rs.<?php echo $pprice; ?> Per Month</p>
                                                <div class="l-address">
                                                    <p><?php echo $paddress; ?></p>
                                                    <p><?php echo $pmobile; ?></p>
                                                </div>
                                            </div>
                                            <div class="req-btn">
                                                <a href="PropertyDetails.php?propid=<?php echo $propid; ?>"><button type="button" class="rent-req-btn">Request to Rent</button></a>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                            <?php
                                }
                            } else {
                                echo "No properties found.";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div id="map" style="height:100%; width: 100%;"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>
<script src="JS/map.js"></script>
<script src="JS/main.js"></script>
</html>