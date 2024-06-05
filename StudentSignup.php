<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="CSS/style13.css">
    

    <title>Student Signup</title>
</head>

<body>

    <div class="container">
    
    <h1>Student Signup</h1>
    <form action="StudentSignup.php" method="post">
    <div class="inputs">
        <input class="sfname" type="text" placeholder="First Name" name="sfname" id="sfname"> 
        <input class="slname" type="text" placeholder="Last Name" name="slname" id="slname">
        <input class="semail" type="text" placeholder="Email" name="semail" id="semail">
        <input class="studid" type="text" placeholder="Student ID" name="studid" id="studid">
        <select class="gender" name="gender" id="gender">
            <option value="" disabled selected>Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
        </select>
        <input class="smobile" type="text" placeholder="Mobile Number" name="smobile" id="smobile">
        <input class="saddress" type="text" placeholder="Address" name="saddress" id="saddress">
        <input class="spassword" type="password" placeholder="Password" name="spassword" id="spassword">
        <input class="confirmpw" type="password" placeholder="Confirm Password" name="cpword">
    </div>
 





    <div class="login-button">
        <button type="submit">Create Account</button>
    </div>


    <div class="member-signup">
        <p>Already a member? <a href="StudentLogin.php">Login</a></p>   
        
    </div>



</form>   
</div>

<?php

require_once("connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = OpenCon();

    $sfname = sanitizeInput($_POST['sfname']);
    $slname = sanitizeInput($_POST['slname']);
    $semail = sanitizeInput($_POST['semail']);
    $studid = sanitizeInput($_POST['studid']);
    $sgender = sanitizeInput($_POST['gender']);
    $smobile = sanitizeInput($_POST['smobile']);
    $saddress = sanitizeInput($_POST['saddress']);
    $spassword = sanitizeInput($_POST['spassword']);

    $sql = "INSERT INTO student (sfname, slname, semail,studid, sgender, smobile, saddress, spassword)
            VALUES (?,?,?,?,?,?,?,?)";

    $stmt=$conn->prepare($sql);
    $stmt->bind_param("ssssssss",$sfname,$slname,$semail,$studid,$sgender,$smobile,$saddress,$spassword);
    try{
        if($stmt->execute()){
            echo"<script>alert('student added succesfully');</script>";
            header('Location: StudentLogin.php');
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