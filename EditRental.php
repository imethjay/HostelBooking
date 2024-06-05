<?php
session_start();

if (isset($_SESSION['landlord'])) {
    $lname = $_SESSION['landlord']['name'];
    $lid = $_SESSION['landlord']['id'];
} else {
    header('Location: LandlordLogin.php');
    exit;
}

include 'connect.php';

// Open the database connection
$conn = OpenCon();

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rentid = $_POST["rentid"];
    $status = $_POST["status"];

    // Update the status in the database
    $sql = "UPDATE rentalrequest SET Status = '$status' WHERE rentid = '$rentid'";
    if ($conn->query($sql) === TRUE) {
        // Status updated successfully
    } else {
        echo "Error updating status: " . $conn->error;
    }
}

// SQL query
$sql = "SELECT
            s.sfname AS 'Student Name',
            s.smobile AS 'Student Contact No',
            s.sgender AS 'Student Gender',
            rr.reason AS 'Reason',
            p.pname AS 'Property Name',
            p.pprice AS 'Property Price',
            rr.Status AS 'Status',
            rr.rentid
        FROM
            rentalrequest rr
            JOIN student s ON rr.studid = s.studid
            JOIN properties p ON rr.propid = p.propid
        WHERE
            p.lid = $lid";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/landrentalreq.css">
    <title>Rental Requests</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="title-bar">
            <h1 style="font-size: 36px; font-weight: bold;">Rental Requests</h1>
        </div>

        <?php
        if ($result->num_rows > 0) {
            echo "<table class='table'>";
            echo "<thead><tr><th scope='col'>Student Name</th><th scope='col'>Student Contact No</th><th scope='col'>Student Gender</th><th scope='col'>Reason</th><th scope='col'>Property Name</th><th scope='col'>Property Price</th><th scope='col'>Status</th><th scope='col'>Action</th></tr></thead>";
            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["Student Name"] . "</td>";
                echo "<td>" . $row["Student Contact No"] . "</td>";
                echo "<td>" . $row["Student Gender"] . "</td>";
                echo "<td>" . $row["Reason"] . "</td>";
                echo "<td>" . $row["Property Name"] . "</td>";
                echo "<td>" . $row["Property Price"] . "</td>";
                echo "<td>";
                if ($row["Status"] == "") {
                    echo "Pending";
                } else {
                    echo $row["Status"];
                }
                echo "</td>";
                echo "<td>";
                echo "<form method='post' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' style='gap: 10px; display: flex; justify-content:center; margin:0;'>";
                echo "<input type='hidden' name='rentid' value='" . $row["rentid"] . "'>";
                echo "<button class='btn btn-dark' type='submit' name='status' value='Accepted'>Accept</button>";
                echo "<button class='btn btn-dark' type='submit' name='status' value='Rejected'>Reject</button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</tbody>";
            echo "</table>";
        } else {
            echo "No rental requests found.";
        }

        // Close the database connection
        CloseCon($conn);
        ?>

        <a href="LandlordDashboard.php" target="parent">
            <div class="back-dash">
                <img src="Imgs/exit.png"><p>Back to the Dashboard</p>
            </div>
        </a>
    </div>
</body>
</html>