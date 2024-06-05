<?php
include 'connect.php';
// Start the session
session_start();

// Open the database connection
$conn = OpenCon();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/ManageProperty.css">
    <title>Manage Property</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<div class="container">
    <div class="title">
        <p>Manage Property</p>
    </div>
    <?php
    // Check if the landlord ID is set in the session
    if (isset($_SESSION['landlord']['id']) && !empty($_SESSION['landlord']['id'])) {
        $user_id = $_SESSION['landlord']['id'];

        // Prepare the SQL query
        $sql = "SELECT pname, propid FROM properties WHERE lid = ?";
        $stmt = $conn->prepare($sql);

        // Bind the landlord ID parameter
        $stmt->bind_param("i", $user_id);

        // Execute the query
        $stmt->execute();

        // Get the result
        $result = $stmt->get_result();

        // Loop through the results and generate the HTML code
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $pname = $row["pname"];
                $propid = $row["propid"];
                echo '<a href="updateproperty.php?property_id=' . $propid . '" target="parent">
                        <div class="box2">
                            <div class="rental-class">
                                <p class="rental">' . $pname . '</p>
                            </div>
                            <div class="rental-image"><img src="Imgs/arrow.png"></div>
                        </div>
                      </a>';
            }
        } else {
            echo "No properties found for the given landlord ID.";
        }

        // Close the statement
        $stmt->close();
    } else {
        // Handle the case when the landlord ID is not set
        echo "Landlord ID not found in the session.";
    }
    ?>
    <a href="LandlordDashboard.php" target="parent">
        <div class="back-dash">
            <img src="Imgs/exit.png"><p>Back to the Dashboard</p>
        </div>
    </a>
</div>
</body>
</html>
<?php
// Close the database connection
CloseCon($conn);
?>