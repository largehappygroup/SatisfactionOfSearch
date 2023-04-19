<?php
session_start();

// Check if the user is already logged in
if (isset($_SESSION['username'])) {
  header("Location: home.php");
  exit;
}

// Check if the login form has been submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get the username and password from the form data
  $username = $_POST['username'];
  $password = $_POST['password'];

  // Check if there is a current database connection
  if (!isset($conn) || !$conn) {
    // If there is no current connection, establish a new one
    $conn = connectToDatabase();
  }

  // Prepare the SQL statement to retrieve the user information
  $sql = "SELECT * FROM users WHERE username = '$username'";

  // Execute the SQL statement
  $result = mysqli_query($conn, $sql);

  // Check for errors in the query
  if (!$result) {
    die("Error: " . mysqli_error($conn));
  }

  // Check if the username exists in the database
  if (mysqli_num_rows($result) == 1) {
    // Get the hashed password from the database
    $row = mysqli_fetch_assoc($result);
    $hashed_password = $row['password'];

    // Verify the password
    if (password_verify($password, $hashed_password)) {
      $_SESSION['username'] = $username;
      header("Location: home.php");
      exit;
    }
  }

  // If the username and password are invalid, show an error message
  $error_message = "Invalid username or password.";
}
?>