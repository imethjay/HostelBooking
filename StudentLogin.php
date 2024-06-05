<?php
session_start();
require_once("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = OpenCon();
    $semail = sanitizeInput($_POST['semail']);
    $spassword = sanitizeInput($_POST['spassword']);
    $sql = "SELECT * FROM student WHERE semail=? AND spassword=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $semail, $spassword);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['student'] = [
            'id' => $row['studid'],
            'name' => $row['slname'],
        ];
        header("Location: studentDashboard.php");
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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style11.css">
    <title>Student Login</title>
</head>
<body>
    <div class="container">
        <h1>Student Login</h1>
        <form action="StudentLogin.php" method="POST">
            <div class="inputs">
                <input class="email" type="text" placeholder="Email" name="semail" id="semail">
                <input class="pw" type="password" placeholder="Password" name="spassword" id="spassword">
            </div>
            <div class="login-button">
                <button type="submit">Login Now</button>
            </div>
        </form>
        <div class="member-signup">
            <p>Not a member? <a href="StudentLogin.php">Signup</a></p>
        </div>
    </div>
</body>
</html>