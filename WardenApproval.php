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
    $propaid = null;
    $propid = $_POST["propid"];
    $wardid = $_POST["wardid"];
    $status = $_POST["status"];
    $reason = $_POST["reason"];

    // Connect to the database
    $conn = OpenCon();

    // Check if the entry already exists
    $checkSql = "SELECT * FROM propertyapproval WHERE propid = '$propid'";
    $checkResult = $conn->query($checkSql);

    if ($checkResult->num_rows > 0) {
        // Entry already exists, display an alert
        echo '<script>
                if (confirm("Already Approved/Rejected it. Do you want to go back to the dashboard?")) {
                    window.location.href = "wardenDashboard.php";
                }else{
                    window.location.href = "wardenDashboard.php";
                }
            </script>';
        
    } else {
        // Entry does not exist, proceed with the insert
        $sql = "INSERT INTO propertyapproval (propaid, propid, wardid, status, reason) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiiss", $propaid, $propid, $wardid, $status, $reason);
        $stmt->execute();

        // Close the prepared statement
        $stmt->close();

        // Redirect to a success page or display a success message
        header("Location: wardenDashboard.php");
        exit;
    }

    // Close the database connection
    CloseCon($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/acceptreject.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Hostel | Accept or Reject</title>
</head>
<body>
    <div class="container">
        <div class="form">
            <div class="heading">
                <h1>Approve or Reject Property</h1>
            </div>
            <div class="hostel-info">
                <h4>Hostel</h4>
                <input type="text" value="<?php echo $pname; ?>" readonly>
            </div>
            <form action="WardenApproval.php" method="POST">
            <input type="hidden" value="<?php echo $propid; ?>" readonly name="propid" id="propid">
            <input type="hidden" value="<?php echo $wardid; ?>" readonly name="wardid" id="wardid">
            <div class="status">
                <h4>Status</h4>
                <select name="status" id="status">
                    <option value="Approved">Approved</option>
                    <option value="Rejected">Rejected</option>
                </select>
            </div>
            <div class="reason">
                <h4>Reason</h4>
                <textarea name="reason" id="reason" cols="40" rows="10"></textarea>
            </div>
            <div class="btn-area">
                <button class="submit">Submit</button>
                <button class="cancel">Cancel</button>
            </div>
            </form>
        </div>

    </div>
</body>
</html>