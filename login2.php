<?php
include("navbar.html");
include("database.php");

session_start();
include("database.php");

// Check if 'login_id' exists in the session; otherwise, redirect or show error
if (!isset($_SESSION['login_id'])) {
  echo "Error: User ID not found in session. Please register first.";
  exit();
}

$login_id = $_SESSION['login_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['save_details'])) {
  $full_name = filter_input(INPUT_POST, "full_name", FILTER_SANITIZE_SPECIAL_CHARS);
  $phone_number = filter_input(INPUT_POST, "phone_number", FILTER_SANITIZE_SPECIAL_CHARS);
  $dob = filter_input(INPUT_POST, "dob", FILTER_SANITIZE_SPECIAL_CHARS);

  // Insert details into the user table using the login ID as a foreign key
  $sql = "INSERT INTO user (id, full_name, phone_number, dob) VALUES ('$login_id', '$full_name', '$phone_number', '$dob')";

  if (mysqli_query($conn, $sql)) {
    $_SESSION['full_name'] = $full_name;
    header("Location: search.php"); // Redirect to a welcome or success page
    exit();
  } else {
    echo "Error: Could not save user details.";
  }

  mysqli_close($conn);
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Details</title>
  <link rel="stylesheet" href="css/login2.css">
</head>

<body>
  <div class="details-container">
    <h2>Provide Additional Details</h2>
    <p class="instructions">Please fill out the form below with your information.</p>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="details-form">
      <label for="full_name">Full Name</label>
      <input type="text" name="full_name" id="full_name" placeholder="Enter your full name" required>

      <label for="phone_number">Phone Number</label>
      <input type="text" name="phone_number" id="phone_number" placeholder="Enter your phone number" required>

      <label for="dob">Date of Birth</label>
      <input type="date" name="dob" id="dob" required>

      <input type="submit" name="save_details" value="Save Details" class="submit-btn">
    </form>
  </div>
</body>

</html>