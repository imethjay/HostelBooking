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
        <h1>Pending Properties</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Property Name</th>
                    <th scope="col">Landlord First Name</th>
                    <th scope="col">Property Address</th>
                    <th scope="col">Property Mobile</th>
                    <th scope="col">Property Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Include the connect.php file
                include 'connect.php';

                // Open the database connection
                $conn = OpenCon();

                // Execute the SQL query to fetch pending property data
                $sql = "SELECT p.pname AS 'Property Name', l.fname AS 'Landlord First Name', p.paddress AS 'Property Address', p.pmobile AS 'Property Mobile', p.pprice AS 'Property Price'
                        FROM properties p
                        INNER JOIN landlord l ON p.lid = l.lid
                        LEFT JOIN propertyapproval pa ON p.propid = pa.propid
                        WHERE pa.propaid IS NULL";

                $result = $conn->query($sql);

                // Loop through the result set and populate the table rows
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['Property Name'] . "</td>";
                        echo "<td>" . $row['Landlord First Name'] . "</td>";
                        echo "<td>" . $row['Property Address'] . "</td>";
                        echo "<td>" . $row['Property Mobile'] . "</td>";
                        echo "<td>" . $row['Property Price'] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No pending properties found.</td></tr>";
                }

                // Close the database connection
                CloseCon($conn);
                ?>
            </tbody>
        </table>

        <a href="wardenDashboard.php" target="_self">
            <div class="back-dash">
                <img src="Imgs/exit.png"><p>Back to the Dashboard</p>
            </div>
        </a>
    </div>
</body>
</html>