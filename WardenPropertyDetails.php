<?php
session_start();
if (isset($_SESSION['warden'])) {
    $wardname = $_SESSION['warden']['wardname'];
    $wardid = $_SESSION['warden']['wardid'];
} else {
    header('Location: wardenlogin.php');
    exit;
}

// Include the database connection file
require_once 'connect.php';

// Retrieve the propid from the query parameter
$propid = isset($_GET['propid']) ? $_GET['propid'] : null;

// Connect to the database
$conn = OpenCon();

// Fetch warden details
$sql = "SELECT * FROM warden WHERE wardid = '$wardid'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $wardenemail = $row["wardemail"];
}

// Fetch property details from the properties table
$sql = "SELECT * FROM properties WHERE propid = '$propid'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pname = $row["pname"];
    $paddress = $row["paddress"];
    $pmaplink = $row["pmaplink"];
    $pmobile = $row["pmobile"];
    $pdescription = $row["pdescription"];
    $pprice = $row["pprice"];
    $lid = $row["lid"];
}

// Fetch facilities for the property from the facilities table
$sql = "SELECT facname FROM facilities WHERE propid = '$propid'";
$facilities = $conn->query($sql);

// Fetch images for the property from the images table
$sql = "SELECT imgfilename, imgfiledata FROM images WHERE propid = '$propid'";
$images = $conn->query($sql);

// Close the database connection
CloseCon($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style22.css">
    <title>Hostel</title>
</head>
<body>
    <div class="container">
        <div class="all-data">
            <div class="heading">
                <div class="hostel-name">
                    <h2><?php echo $pname; ?></h2>
                    <p><?php echo $paddress; ?></p>
                    <p><?php echo $pmobile; ?></p>
                </div>
                <div class="btn">
                    <a href="WardenApproval.php?propid=<?php echo $propid; ?>"><button class="req">Accept / Reject</button></a>
                </div>
            </div>

          

            <div class="image-slider">
                <main>
                    <div class="slider">
                        <?php while ($image = $images->fetch_assoc()) { ?>
                            <img src="data:image/jpeg;base64,<?php echo base64_encode($image['imgfiledata']); ?>" alt="" class="slide">
                        <?php } ?>
                    </div>
                </main>
                <div class="slide-nav">
                    <button onclick="goPrev()">
                        <img src="Imgs/left.png" alt="" height="25px" width="25px">
                    </button>
                    <button onclick="goNext()">
                        <img src="Imgs/right.png" alt="" height="25px" width="25px">
                    </button>
                </div>
                <script src="JS/slider.js"></script>
            </div>

            <div class="about">
                <h4>About <?php echo $pname; ?></h4>
                <p><?php echo $pdescription; ?></p>
            </div>
            <div class="prices">
                <h4>Rental Prices</h4>
                <ul class="r-prices">
                    <p class="p-price">Rs. <?php echo $pprice; ?>/= Per Month</p>
                </ul>
            </div>
            <div class="facilities">
                <h4>Facilites</h4>
                <div class="fac-details">
                    <ul>
                    <?php while ($facility = $facilities->fetch_assoc()) { ?>
                        <li><div class="item"><p><?php echo $facility['facname']; ?></p></div></li>
                    <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script src="JS/image.js"></script>
</body>
</html>