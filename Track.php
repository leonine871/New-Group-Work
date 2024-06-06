<?php
// Database connection parameters
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "drone_delivery";

// Create a new database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get tracking ID from POST request
$tracking_id = $_POST['tracking_id'] ?? '';
$status = '';

// If a tracking ID is provided, search for the status in the database
if ($tracking_id) {
    $sql = "SELECT status FROM deliveries WHERE tracking_id = '$tracking_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $status = $row['status'];
    } else {
        $status = "Tracking ID not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Delivery</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <h1>Track Your Delivery</h1>
        <nav>
            <ul>
                <li><a href="home.php">Home</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="services.php">Services</a></li>
                <li><a href="track.php">Track</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <section>
            <h2>Enter Your Tracking ID</h2>
            <!-- Form for user to enter tracking ID -->
            <form method="POST" action="track.php">
                <input type="text" name="tracking_id" placeholder="Tracking ID">
                <button type="submit">Track</button>
            </form>
            <!-- Display the status of the delivery -->
            <p>Status: <?php echo htmlspecialchars($status); ?></p>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 Smart Drone Delivery System</p>
    </footer>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
