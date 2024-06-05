<?php
include '../connect.php';

// Open the database connection
$conn = OpenCon();

// Check if the form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the form data
    $articleName = $_POST["articlename"];
    $articleContent = $_POST["content"];

    // Prepare and execute the SQL statement
    $sql = "INSERT INTO articles (articlename, articlecontent) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $articleName, $articleContent);

    if ($stmt->execute()) {
        header("Location: webadmin.php");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

// Close the database connection
CloseCon($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://kit.fontawesome.com/64a0021d5a.js" crossorigin="anonymous"></script>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <link rel="stylesheet" href="postarticles.css">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
</head>
<body> 
    <div class="container" style="    display: flex; justify-content: center; align-items: center; margin-top: 5%;">
        <div class="rtr-page">
            <h2 class="rtr-title">Post Articles</h2>
<form action="postarticles.php" method="post">
            <div class="rtr-textboxes">
                <div class="rtr-tbox">
                    <label class="t-name">Article Name</label>
                    <input type="text" id="articlename" name="articlename" class="hostel-n">
                </div>
                <div class="rtr-tbox">
                    <label class="t-name">Content</label>
                    <textarea id="content" name="content" rows="4" cols="50" class="hostel-r"></textarea>
                </div>
                <div class="btn">
                    <button type="submit" class="btn btn-dark">Publish</button>
                </div>
            </div>
            </form>
        </div>
    </div>

    <a href="webadmin.php" target="parent" style="text-decoration: none; color: black; font-weight: 600;">
            <div class="back-dash">
                <img src="../Imgs/exit.png"><p>Back to the Dashboard</p>
            </div>
        </a>
</body>
<script src="main.js"></script>
</html>