<?php
// Start session to validate user
session_start();

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header('Location: login.php');
    exit();
}

// Check if form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Serialize data
    $data = serialize(array(
        'email' => $email,
        'phone' => $phone
    ));
	
	// Check if there is a current database connection
	if (!isset($conn) || !$conn) {
		// If there is no current connection, establish a new one
		$conn = connectToDatabase();
	}

    // Send data to database
    $username = $_SESSION['username'];
    $query = "UPDATE users SET data = '$data' WHERE username = '$username'";
    

	// Execute the query
	$result = $conn->query($sql);

	// Check if the query was successful
	if (!$result) {
		die('Error executing query: ' . $conn->error);
	}
	
	$conn->close();
}

// Display form
?>
<form method="post">
    <label for="email">Email:</label>
    <input type="email" name="email" value="<?php echo $email; ?>">
    <br>
    <label for="phone">Phone:</label>
    <input type="text" name="phone" value="<?php echo $phone; ?>">
    <br>
    <input type="submit" value="Update">
</form>
