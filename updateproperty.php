<?php
session_start();
$user_id = $_SESSION['landlord']['id'];
require_once 'connect.php';

// Get the property ID from the query parameter
$property_id = $_GET['property_id'];

// Open the database connection
$conn = OpenCon();

// Fetch the existing property details
$sql = "SELECT pname, paddress, pmaplink, pmobile, pdescription, pprice FROM properties WHERE propid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $property_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pname = $row["pname"];
    $paddress = $row["paddress"];
    $pmaplink = $row["pmaplink"];
    $pmobile = $row["pmobile"];
    $pdescription = $row["pdescription"];
    $pprice = $row["pprice"];
} else {
    echo "No property found with the given ID.";
}

$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pname = $_POST['pname'];
    $paddress = $_POST['paddress'];
    $pmaplink = $_POST['googlemaplink'];
    $pmobile = $_POST['pmobile'];
    $pdescription = $_POST['about'];
    $pprice = $_POST['pprice'];
    $facilities = isset($_POST['facilities']) ? $_POST['facilities'] : array();

    // Update property details
    $stmt = $conn->prepare("UPDATE properties SET pname = ?, paddress = ?, pmaplink = ?, pmobile = ?, pdescription = ?, pprice = ? WHERE propid = ?");
    $stmt->bind_param("ssssssi", $pname, $paddress, $pmaplink, $pmobile, $pdescription, $pprice, $property_id);
    $stmt->execute();
    $stmt->close();

    // Update facilities
    $stmt = $conn->prepare("DELETE FROM facilities WHERE propid = ?");
    $stmt->bind_param("i", $property_id);
    $stmt->execute();
    $stmt->close();

    foreach ($facilities as $facility) {
        $stmt = $conn->prepare("INSERT INTO facilities (propid, facname) VALUES (?, ?)");
        $stmt->bind_param("is", $property_id, $facility);
        $stmt->execute();
        $stmt->close();
    }

    // Update images
    $fileNames = array();
    foreach ($_FILES['fileImg']['tmp_name'] as $key => $tmp_name) {
        $fileName = basename($_FILES['fileImg']['name'][$key]);
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowedTypes = array('jpg', 'jpeg', 'png');
        if (in_array($fileType, $allowedTypes)) {
            $fileData = file_get_contents($_FILES['fileImg']['tmp_name'][$key]);

            $stmt = $conn->prepare("INSERT INTO images (propid, imgfilename, imgfiledata) VALUES (?, ?, ?)");
            $null = NULL;
            $stmt->bind_param("isb", $property_id, $fileName, $null);
            $stmt->send_long_data(2, $fileData);
            $stmt->execute();
            $stmt->close();

            $fileNames[] = $fileName;
        } else {
            echo "Invalid file type for file: " . $fileName . "<br>";
        }
    }

    header("Location: ManageProperty.php");
}

CloseCon($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/registernewproperty.css">
    
    <title>Update Property</title>
</head>
<body>
    <div class="container">
        <h2>Update Property</h2>
        <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . '?property_id=' . $property_id; ?>" method="post">
            <div class="inputs">
                <input type="text" name="user_id" value="<?php echo $user_id; ?>">

                <p>Name of Your Business</p>
                <input class="pname" type="text" placeholder=" Business Name" name="pname" value="<?php echo $pname; ?>" required>
                <p>Address (As in Google Map)</p>
                <input class="paddress" type="text" placeholder=" Address" name="paddress" value="<?php echo $paddress; ?>" required>
                <p>Google Map Link</p>
                <input class="googlemaplink" type="text" placeholder=" Map Link" name="googlemaplink" value="<?php echo $pmaplink; ?>" required>
                <p>Mobile Number</p>
                <input class="pmobile" type="text" placeholder=" Number" name="pmobile" value="<?php echo $pmobile; ?>" required>
                <p>About</p>
                <textarea class="about" placeholder=" Enter Details" name="about" required><?php echo $pdescription; ?></textarea>
                <p>Price</p>
                <input class="pprice" type="text" placeholder=" Price" name="pprice" value="<?php echo $pprice; ?>" required>
            </div>

            <div class="facility">
                <p>Facilities</p>
                <div class="sub">
                </div>
            </div>
            <div class="grid" style="display: flex; gap: 20px;">
                <div class="col">
                    <div class="container2">
                        <div class="fitness">
                            <p>Free WIFI</p>
                        </div>
                        <div class="check">
                            <input class="checkbox2" type="checkbox" name="facilities[]" value="Free WIFI">
                        </div>
                    </div>
                    <div class="container2">
                        <div class="fitness">
                            <p>Fitness Center</p>
                        </div>
                        <div class="check">
                            <input class="checkbox2" type="checkbox" name="facilities[]" value="Fitness Center">
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="container2">
                        <div class="fitness">
                            <p>Laundry Service</p>
                        </div>
                        <div class="check">
                            <input class="checkbox2" type="checkbox" name="facilities[]" value="Laundry Service">
                        </div>
                    </div>
                    <div class="container2">
                        <div class="fitness">
                            <p>Free Parking</p>
                        </div>
                        <div class="check">
                            <input class="checkbox2" type="checkbox" name="facilities[]" value="Free Parking">
                        </div>
                    </div>
                </div>
            </div>

            <p>Images</p>
            <div class="container4">
                <input type="file" id="file-input" name="fileImg[]" accept=".jpg, .jpeg, .png" multiple />
                <label for="file-input" class="label2">
                    <i class="fa-solid fa-cloud-arrow-up"></i>
                    &nbsp; Choose Files To Upload
                </label>
                <div id="num-of-files">No Files Chosen</div>
                <ul id="files-list"></ul>
            </div>

            <script src="JS/registernewproperty.js"></script>
            <div class="end-btn">
                <button type="submit" class="btn3">Update Property</button>
                <br>
                <button type="button" class="btn4">Cancel</button>
            </div>
        </form>
    </div>
</body>
</html>