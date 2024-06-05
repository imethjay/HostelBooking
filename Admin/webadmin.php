
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Hostel | Admin Dashboard</title>
</head>
<body>
   
    <div class="container">
            <?php
        session_start();
        if (isset($_SESSION['webadmin'])) {
            $webname = $_SESSION['webadmin']['webname'];
            $webid = $_SESSION['webadmin']['webid'];
        } else {
            header('Location: index.php');
            exit;
        }
        ?>
        <h1 class="heading">Web Admin Dashboard</h1>
       
        <div class="dashboard">
            <div class="buttons">
            
            <div class="btn-1">
                <h6><a href="webadmincreateacc.php">Create Accounts</a></h6> 
                <i class="fa-solid fa-circle-right"></i>
            
            </div> 
            
            <div class="btn-1">
                <h6><a href="postarticles.php">Post Articles</a> </h6> 
                <i class="fa-solid fa-circle-right"></i>
            </div> 
            
            
            
            <div class="btn-1">
                <h6><a href="articlesweb.php">Article List</a></h6> 
                <i class="fa-solid fa-circle-right"></i>
            </div> 
            
            
            <div class="btn-1">
                <h6><a href="index.php">Logout</a></h6> 
                <i class="fa-solid fa-right-from-bracket"></i>
            </div> 
            
            </div>
            
        </div>
    </div>
</body>
</html>