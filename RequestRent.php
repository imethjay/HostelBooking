<?php
session_start();
if (isset($_SESSION['student'])) {
    $slname = $_SESSION['student']['name']; 
    $studid = $_SESSION['student']['id']; 
} else {
    header('Location: StudentLogin.php');
    exit;
}

// Include the database connection file
require_once 'connect.php';

// Retrieve the propid from the query parameter
$propid = isset($_GET['propid']) ? $_GET['propid'] : null;

// Connect to the database
$conn = OpenCon();

// Fetch property details from the properties table
$sql = "SELECT pname FROM properties WHERE propid = '$propid'";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $pname = $row["pname"];
}

// Close the database connection
CloseCon($conn);

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rentid = null; 
    $propid = $_POST["propid"];
    $studid = $_POST["studid"];
    $reason = $_POST["reason"];

    // Connect to the database
    $conn = OpenCon();

    // Prepare and execute the SQL statement to insert data into the table
    $sql = "INSERT INTO rentalrequest (rentid, studid, propid, reason) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiis", $rentid, $studid, $propid, $reason);
    $stmt->execute();

    // Close the database connection
    $stmt->close();
    CloseCon($conn);

    // Redirect to a success page or display a success message
    header("Location: studentDashboard.php");
    exit;
}



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
    <link rel="stylesheet" href="CSS/RequestRent.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
</head>
<body> 
    <div class="container" style="    display: flex; justify-content: center; align-items: center; height: 100vh;">
        <div class="rtr-page">
            <h2 class="rtr-title">Request to Rent</h2>

        <form action="RequestRent.php" method="post">

        <input type="hidden" id="studid" name="studid" class="hostel-n" value="<?php echo $studid; ?>">
        <input type="hidden" id="propid" name="propid" class="hostel-n" value="<?php echo $propid; ?>">
            <div class="rtr-textboxes">
                <div class="rtr-tbox">
                    <label class="t-name">Hostel</label>
                    <input type="text" id="hostel" class="hostel-n" value="<?php echo $pname; ?>" readonly>
                </div>
                <div class="rtr-tbox">
                    <label class="t-name">Reason</label>
                    <input type="text" id="reason" name="reason" class="hostel-r">
                </div>
                <div class="btn">
                    <button type="submit" class="btn btn-dark">Request to Rent</button>
                </div>
            </div>
        </form>    

        </div>
    </div>
</body>
<script src="main.js"></script>
</html>