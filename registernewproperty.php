<?php
session_start();
$user_id = $_SESSION['landlord']['id'];
require_once 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = OpenCon();

    $pname = $_POST['pname'];
    $paddress = $_POST['paddress'];
    $googlemaplink = $_POST['googlemaplink'];
    $pmobile = $_POST['pmobile'];
    $about = $_POST['about'];
    $pprice = $_POST['pprice'];
    $facilities = isset($_POST['facilities']) ? $_POST['facilities'] : array();

    $stmt = $conn->prepare("INSERT INTO properties (lid, pname, paddress, pmaplink, pmobile, pdescription, pprice) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssss", $user_id, $pname, $paddress, $googlemaplink, $pmobile, $about, $pprice);
    $stmt->execute();
    $property_id = $stmt->insert_id;
    $stmt->close();

    $fileNames = array();
    foreach ($_FILES['fileImg']['tmp_name'] as $key => $tmp_name) {
      $fileName = basename($_FILES['fileImg']['name'][$key]);
      $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
  
      $allowedTypes = array('jpg', 'jpeg', 'png');
      if (in_array($fileType, $allowedTypes)) {
          $fileData = file_get_contents($_FILES['fileImg']['tmp_name'][$key]);
  
          $stmt = $conn->prepare("INSERT INTO images (propid, imgfilename, imgfiledata) VALUES (?, ?, ?)");
          $null = NULL;
          $stmt->bind_param("isb", $property_id, $fileName, $null);
          $stmt->send_long_data(2, $fileData);
          $stmt->execute();
          $stmt->close();
  
          $fileNames[] = $fileName;
      } else {
          echo "Invalid file type for file: " . $fileName . "<br>";
      }
  }

    foreach ($facilities as $facility) {
        $stmt = $conn->prepare("INSERT INTO facilities (propid, facname) VALUES (?, ?)");
        $stmt->bind_param("is", $property_id, $facility);
        $stmt->execute();
        $stmt->close();
    }

    echo "Property registered successfully!";
    CloseCon($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/registernewproperty.css">
    
    <title>Register a new property</title>
</head>
<body>
    <div class="container">
        <h2>Register a new Property</h2>
        <form enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post">
        <div class="inputs">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

            <p>Name of Your Business</p>
            <input class="pname" type="text" placeholder=" Business Name" name="pname" required>
            <p>Address (As in Google Map)</p>
            <input class="paddress" type="text" placeholder=" Address" name="paddress" required>
            <p>Longitude and Latitude</p>
            <input class="googlemaplink" type="text" placeholder="6.831742775830261, 80.03097422818067" name="googlemaplink" required>
            <p>Mobile Number</p>
            <input class="pmobile" type="text" placeholder=" Number" name="pmobile" required>
            <p>About</p>
            <textarea class="about"  placeholder=" Enter Details" name="about" required></textarea>
            <p>Price</p>
            <input class="pprice" type="text" placeholder=" Price" name="pprice" required>
        </div>

        <div class="facility">
        <p>Facilities</p>
        <div class="sub">
        </div>
        </div>
        <div class="grid" style="display: flex; gap: 20px;">
        
      
        <div class="col">
            <div class="container2">
                <div class="fitness">
                    <p>Free WIFI</p>
                    </div> 
                    <div class="check">
                    <input class="checkbox2" type="checkbox" name="facilities[]" value="Free WIFI"> 
                    </div>          
            </div>
            <div class="container2">
                <div class="fitness">
                    <p>Fitness Center</p>
                    </div> 
                    <div class="check">
                    <input class="checkbox2" type="checkbox" name="facilities[]" value="Fitness Center"> 
                    </div> 
            </div>
            

            
        </div>
        
        <div class="col">    
            
            <div class="container2">
                <div class="fitness">
                    <p>Laundry Service</p>
                    </div> 
                    <div class="check">
                    <input class="checkbox2" type="checkbox" name="facilities[]" value="Laundry Service"> 
                    </div> 
            </div>
            <div class="container2">
              <div class="fitness">
                  <p>Free Parking</p>
                  </div> 
                  <div class="check">
                  <input class="checkbox2" type="checkbox" name="facilities[]" value="Free Parking"> 
                  </div> 
          </div>

        </div>
      </div>
    
        <p>Images</p>
        <div class="container4">
        <input type="file" id="file-input" name="fileImg[]" accept=".jpg, .jpeg, .png" required multiple />

        <label for="file-input" class="label2">
            <i class="fa-solid fa-cloud-arrow-up"></i>
            &nbsp; Choose Files To Upload
        </label>

        <div id="num-of-files">No Files Chosen</div>
        <ul id="files-list"></ul>
        </div>

        <script src="JS/registernewproperty.js"></script>
        <div class="end-btn">
        <button type="submit" class="btn3">Register Now</button> <br>
        <button type="reset" class="btn4">Cancel</button>
        </div>       
    </div>
    </form> 
    
</body>
</html>
