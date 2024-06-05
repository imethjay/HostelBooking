<?php
include 'connect.php';

// Open the database connection
$conn = OpenCon();

// Fetch article names and IDs from the database
$sql = "SELECT articleid, articlename FROM articles";
$result = $conn->query($sql);

// Close the database connection
CloseCon($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Admin/articlesweb.css">
    <title>Articles</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="title">
            <p>Articles</p>
        </div>

        <?php
        // Generate HTML for article names with article IDs
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $articleId = $row["articleid"];
                $articleName = $row["articlename"];
                echo '<a href="article.php?id=' . $articleId . '" target="parent">';
                echo '<div class="box2">';
                echo '<div class="rental-class"><p class="rental">' . $articleName . '</p></div>';
                echo '<div class="rental-image"><img src="Imgs/arrow.png"></div>';
                echo '</div>';
                echo '</a>';
            }
        } else {
            echo "No articles found.";
        }
        ?>

    </div>
</body>
</html>