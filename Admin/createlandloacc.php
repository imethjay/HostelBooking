<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/style12.css">
    

    <title>Landlord account create</title>
</head>

<body>

    <div class="container">
    
    <h1>Create Landlord Profile</h1>
    <form action="createlandloacc.php" method="post">

    <div class="inputs">
        <input class="fname" type="text" placeholder="First Name" name="fname" id="fname"> 
        <input class="lname" type="text" placeholder="Last Name" name="lname" id="lname">
        <input class="email" type="text" placeholder="Email" name="email" id="email"> 
        <input class="mobile" type="text" placeholder="Mobile Number" name="mobile" id="mobile">
        <input class="address" type="text" placeholder="Address" name="address" id="address">
        <input class="password" type="password" placeholder="Password" name="password" id="password">
        <input class="confirmpw" type="password" placeholder="Confirm Password" name="landcpword">
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

    $fname = sanitizeInput($_POST['fname']);
    $lname = sanitizeInput($_POST['lname']);
    $email = sanitizeInput($_POST['email']);
    $mobile = sanitizeInput($_POST['mobile']);
    $address = sanitizeInput($_POST['address']);
    $password = sanitizeInput($_POST['password']);

    $sql = "INSERT INTO landlord (fname, lname, email, mobile, address, password)
            VALUES (?,?,?,?,?,?)";

    $stmt=$conn->prepare($sql);
    $stmt->bind_param("ssssss",$fname,$lname,$email,$mobile,$address,$password);
    try{
        if($stmt->execute()){
            echo"<script>alert('landlord added succesfully');</script>";
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
</html>