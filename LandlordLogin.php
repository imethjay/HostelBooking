<?php
ob_start();
session_start();

require_once("connect.php");

if($_SERVER["REQUEST_METHOD"]=="POST"){
    $conn = OpenCon();

    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);

    $sql = "SELECT * FROM landlord WHERE email=? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss",$email,$password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1){
        session_start(); 

    $row = $result->fetch_assoc();
    $_SESSION['landlord'] = [
      'id' => $row['lid'],
      'name' => $row['lname'],  
    ];
        header("Location: LandlordDashboard.php");
        exit();
    } else {
        echo "Login failed. Please check your credentials.";
    }

    $stmt->close();
    CloseCon($conn);
}
ob_end_clean();

function sanitizeInput($data){
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style10.css">
    <title>Landlord Login</title>
</head>

<body>
    <div class="container">
        <h1>Landlord Login</h1>
        <form action="LandlordLogin.php" method="POST">
            <div class="inputs">
                <input class="email" type="text" placeholder="Email" name="email" id="email">
                <input class="ppassword" type="password" placeholder="Password" name="password" id="password">
            </div>
            <div class="login-button">
                <button type="submit">Login Now</button>
            </div>
        </form>
        <div class="member-signup">
            <p>Not a member? <a href="LandlordSignup.php">Signup</a></p>
        </div>
    </div>
</body>
</html>
