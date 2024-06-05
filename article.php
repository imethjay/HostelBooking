<?php
include 'connect.php';

// Open the database connection
$conn = OpenCon();

// Check if the article ID is provided in the query parameter
if (isset($_GET['id'])) {
    $articleId = $_GET['id'];

    // Fetch the article data from the database based on the article ID
    $sql = "SELECT articlename, articlecontent FROM articles WHERE articleid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $articleId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $articleName = $row["articlename"];
        $articleContent = $row["articlecontent"];
    } else {
        echo "Article not found.";
        exit;
    }

    $stmt->close();
} else {
    echo "Invalid request.";
    exit;
}

// Close the database connection
CloseCon($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Admin/articles.css">
    <script src="https://kit.fontawesome.com/7222d48e3a.js" crossorigin="anonymous"></script>
    <title>Article</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container" style="height: 100vh; flex-direction: column; display: flex; justify-content: center;">
        <div class="a-namepage">
            <div class="title">
                <h2 class="a-title"><?php echo $articleName; ?></h2>
            </div>
            <div class="a-pharagraph">
                <p class="p-text"><?php echo $articleContent; ?></p>
            </div>
        </div>
        <a style="text-decoration: none;" href="index.php" target="parent">
            <div class="back-dash">
                <i class="fa-solid fa-arrow-left"></i><p>Back to the Home</p>
            </div>
        </a>
    </div>
</body>
</html>