<?php
ob_start();
session_start();
require_once("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = OpenCon();
    $wardemail = sanitizeInput($_POST['wardemail']);
    $wardpassword = sanitizeInput($_POST['wardpassword']);
    $sql = "SELECT * FROM warden WHERE wardemail=? AND wardpassword=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $wardemail, $wardpassword);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['warden'] = [
            'wardid' => $row['wardid'],
            'wardname' => $row['wardname'],
        ];
        header("Location: wardenDashboard.php");
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
    <link rel="stylesheet" href="CSS/wardenlogin.css">
    <title>Warden Login</title>
</head>
<body>
    <div class="container">
        <h1>Warden Login</h1>
        <form action="wardenlogin.php" method="POST">
            <div class="inputs">
                <input class="wardemail" type="text" placeholder="Email" name="wardemail" id="wardemail">
                <input class="wardpassword" type="password" placeholder="Password" name="wardpassword" id="wardpassword">
            </div>
            <div class="login-button">
                <button type="submit">Login Now</button>
            </div>
        </form>
    </div>
</body>
</html>