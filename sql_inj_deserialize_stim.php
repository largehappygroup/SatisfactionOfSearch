<?php
// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit();
}

// Check if there is a current database connection
if (!isset($conn) || !$conn) {
    // If there is no current connection, establish a new one
    $conn = connectToDatabase();
}

// Retrieve data from database
$username = $_SESSION['username'];
$query = "SELECT data FROM users WHERE username = '$username'";
$result = $conn->query($query);

// Check if the query was successful
if (!$result) {
    die('Error executing query: ' . $conn->error);
}

// Get the data from the result
$row = $result->fetch_assoc();
$data = $row['data'];

// Unserialize the data
$data = unserialize($data);

// Display the data
echo 'Email: ' . htmlspecialchars($data['email']) . '<br>';
echo 'Phone: ' . htmlspecialchars($data['phone']);
?>
