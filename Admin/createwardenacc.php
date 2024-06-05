<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/style13.css">
    

    <title>Warden account create</title>
</head>

<body>

    <div class="container">
    
    <h1>Create Warden Profile</h1>
    <form action="createwardenacc.php" method="post">
    <div class="inputs">
        <input class="wardname" type="text" placeholder="First Name" name="wardname" id="wardname"> 
        <input class="wardemail" type="text" placeholder="Email" name="wardemail" id="wardemail">
        <input class="wardpassword" type="password" placeholder="Password" name="wardpassword" id="wardpassword">
        <input class="confirmpw" type="password" placeholder="Confirm Password" name="cpword">
    </div>
 
    <div class="login-button">
        <button type="submit">Create Account</button>
    </div>
</form>   
</div>

<?php

require_once("../connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = OpenCon();
    $wardid = null;
    $wardname = sanitizeInput($_POST['wardname']);
    $wardemail = sanitizeInput($_POST['wardemail']);
    $wardpassword = sanitizeInput($_POST['wardpassword']);

    $sql = "INSERT INTO warden (wardid, wardname, wardemail, wardpassword)
            VALUES (?,?,?,?)";

    $stmt=$conn->prepare($sql);
    $stmt->bind_param("isss",$wardname,$wardemail,$wardpassword);
    try{
        if($stmt->execute()){
            echo"<script>alert('warden added succesfully');</script>";
            header("Location: webadmin.php");
        }
    }catch(mysqli_sql_exception $e){
        echo "Error: " . $e->getMessage() . "\n";
        echo "Stack Trace: \n" . $e->getTraceAsString();
    }finally{
        $stmt->close();
        CloseCon($conn);
    }
}

function sanitizeInput($data){
    $data= trim($data);
    $data= stripslashes($data);
    $data= htmlspecialchars($data);
    return $data;
}
?>
</body>