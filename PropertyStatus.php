<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/landrentalreq.css">
    <title>Property Details by Landlord</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Property Status</h1>

        <?php
        // Include the connect.php file
        include 'connect.php';

        // Open the database connection
        $conn = OpenCon();

        // Check if the landlord ID is available in the session
        if (isset($_SESSION['landlord']['id'])) {
            $landlordId = $_SESSION['landlord']['id'];

            // Execute the SQL query to fetch property data by landlord ID
            $sql = "SELECT p.pname AS 'Property Name', p.paddress AS 'Property Address', p.pmobile AS 'Property Mobile', pa.status AS 'Status', pa.reason AS 'Reason'
                    FROM properties p
                    LEFT JOIN propertyapproval pa ON p.propid = pa.propid
                    WHERE p.lid = $landlordId";

            $result = $conn->query($sql);

            // Check if any properties are found
            if ($result->num_rows > 0) {
                echo '<table class="table">';
                echo '<thead><tr><th>Property Name</th><th>Property Address</th><th>Property Mobile</th><th>Status</th><th>Reason</th></tr></thead>';
                echo '<tbody>';

                // Loop through the result set and populate the table rows
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['Property Name'] . "</td>";
                    echo "<td>" . $row['Property Address'] . "</td>";
                    echo "<td>" . $row['Property Mobile'] . "</td>";
                    echo "<td>" . $row['Status'] . "</td>";
                    echo "<td>" . $row['Reason'] . "</td>";
                    echo "</tr>";
                }

                echo '</tbody>';
                echo '</table>';
            } else {
                echo '<p>No properties found for your landlord account.</p>';
            }
        } else {
            echo '<p>Landlord ID not found in the session.</p>';
        }

        // Close the database connection
        CloseCon($conn);
        ?>
    </div>

    <a href="LandlordDashboard.php" target="_self">
            <div class="back-dash">
                <img src="Imgs/exit.png"><p>Back to the Dashboard</p>
            </div>
        </a>
</body>
</html>