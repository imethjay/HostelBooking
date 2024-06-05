<?php
ob_start();
session_start();
require_once("../connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = OpenCon();
    $webemail = sanitizeInput($_POST['webemail']);
    $webpass = sanitizeInput($_POST['webpass']);
    $sql = "SELECT * FROM webadmin WHERE webemail=? AND webpass=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $webemail, $webpass);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $_SESSION['webadmin'] = [
            'webid' => $row['webid'],
            'webname' => $row['webname'],
        ];
        header("Location:webadmin.php");
        exit();
    } else {
        echo "Login failed. Please check your credentials.";
    }

    $stmt->close();
    CloseCon($conn);
}

function sanitizeInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

ob_end_clean();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="homelogin.css">
    <title>Web Admin Login</title>
</head>
<body>
    <div class="container">
        <div class="loginform">
            <h1>Web Admin Login</h1>
            <form action="index.php" method="POST">
                <div class="inputs">
                    <input class="webemail" type="text" placeholder="Email" name="webemail" id="webemail">
                    <input class="webpass" type="password" placeholder="Password" name="webpass" id="webpass">
                </div>
                <div class="login-button">
                    <button type="submit">Login Now</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>