<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reviews_db";

// Connect to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$success = false; // Track submission success

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES);
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES);
    $review = htmlspecialchars($_POST['review'], ENT_QUOTES);
    $rating = (int)$_POST['rating'];

    // Validate rating
    if ($rating < 1 || $rating > 5) {
        echo "<script>alert('Rating must be between 1 and 5.');</script>";
    } else {
        // Prepare SQL statement
        if ($stmt = $conn->prepare("INSERT INTO reviews (name, email, review, rating) VALUES (?, ?, ?, ?)")) {
            $stmt->bind_param("sssi", $name, $email, $review, $rating);
            if ($stmt->execute()) {
                $success = true;
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Your Review</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
        <?php if ($success): ?>
            <div class="success-message" id="successMessage">Review submitted successfully.</div>
        <?php endif; ?>
        <h2>Submit Your Review</h2>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="review">Review:</label>
        <textarea id="review" name="review" rows="5" required></textarea>

        <label for="rating">Rating (1-5):</label>
        <input type="number" id="rating" name="rating" min="1" max="5" required>

        <button type="submit">Submit</button>
    </form>

    <script>
        // JavaScript to handle success message visibility
        document.addEventListener("DOMContentLoaded", function () {
            const successMessage = document.getElementById('successMessage');
            if (successMessage) {
                // Show success message and hide after 3 seconds
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 3000);
            }
        });
    </script>
</body>
</html>
