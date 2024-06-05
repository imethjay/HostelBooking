<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/landrentalreq.css">
    <title>Delete properties</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    
    <div class="container">
        <h1>Delete properties</h1>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Property Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">Contact No</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Include the connect.php file
                require_once 'connect.php';
                session_start();
                if (isset($_SESSION['landlord'])) {
                  $lname = $_SESSION['landlord']['name']; 
                  $user_id = $_SESSION['landlord']['id'];
                } else {
                  header('Location: LandlordLogin.php');
                  exit;
                }
                // Open the database connection
                $conn = OpenCon();

                // Retrieve data from the properties table
                $sql = "SELECT pname, paddress, pmobile, propid FROM properties WHERE lid='$user_id'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>" . $row["pname"] . "</td>
                                <td>" . $row["paddress"] . "</td>
                                <td>" . $row["pmobile"] . "</td>
                                <td>
                                    <form method='post' action=''>
                                        <input type='hidden' name='propid' value='" . $row["propid"] . "'>
                                        <button class='confirm' type='submit' name='delete'>Delete</button>
                                    </form>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No properties found</td></tr>";
                }

                // Check if the delete button is clicked
                if (isset($_POST['delete'])) {
                    $propid = $_POST['propid'];

                    // Delete the property record from the properties table
                    $sql = "DELETE FROM properties WHERE propid = $propid";

                    if ($conn->query($sql) === TRUE) {
                        echo "<script>alert('Property record deleted successfully');</script>";
                        echo "<meta http-equiv='refresh' content='0'>"; // Refresh the page
                    } else {
                        echo "Error deleting property record: " . $conn->error;
                    }
                }

                // Close the database connection
                CloseCon($conn);
                ?>
            </tbody>
        </table>

        <a href="LandlordDashboard.php" target="parent">
            <div class="back-dash">
                <img src="Imgs/exit.png"><p>Back to the Dashboard</p>
            </div>
        </a>
    </div>
</body>
</html>