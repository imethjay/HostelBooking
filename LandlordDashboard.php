
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/style15.css">
    <title>Landlord Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

    <div class="container">

        <div class="title">
        <?php
              session_start();
              if (isset($_SESSION['landlord'])) {
                $lname = $_SESSION['landlord']['name']; 
              } else {
                header('Location: LandlordLogin.php');
                exit;
              }
            ?>
        <p>Landlord Dashboard</p>
        </div>

    <a href="registernewproperty.php" target="parent">
        <div class="box2">
            <div class="rental-class">  
            <p class="rental">Register a new Property </p></div> 
            <div class="rental-image"><img src="Imgs/arrow.png"> </div> 
        </div>
    </a> 

    <a href="ManageProperty.php" target="parent">
        <div class="box2">
            <div class="rental-class">  
            <p class="rental">Manage Properties </p></div> 
            <div class="rental-image"><img src="Imgs/arrow.png"> </div> 
        </div>
    </a>

    <a href="DeleteProperties.php" target="parent">
        <div class="box2">
            <div class="rental-class">  
            <p class="rental">Delete Properties </p></div> 
            <div class="rental-image"><img src="Imgs/arrow.png"> </div> 
        </div>
    </a>

    <a href="PropertyStatus.php" target="parent">
        <div class="box2">
            <div class="rental-class">  
            <p class="rental">Property Status</p></div> 
            <div class="rental-image"><img src="Imgs/arrow.png"> </div> 
        </div>
    </a>

    <a href="RentalRequests.php" target="parent">
        <div class="box2">
            <div class="rental-class">  
            <p class="rental">Rental Requests </p></div> 
            <div class="rental-image"><img src="Imgs/arrow.png"> </div> 
        </div>
    </a>

    <a href="LandlordLogout.php" target="parent">
        <div class="box2">
            <div class="rental-class">  
            <p class="rental">Logout </p></div> 
            <div class="rental-image"><img src="Imgs/exit.png"> </div> 
        </div>
    </a>
    
    </div>
    
</body>
</html>
