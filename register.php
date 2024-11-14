<?php
include("database.php");
include("index.php");

session_start(); // Start session to store user data across pages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    // Check if the username and password already exist in the login table
    $check_sql = "SELECT * FROM login WHERE username = '$username' AND password = '$password'";
    $check_result = mysqli_query($conn, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // Username and password already exist, show an error message
        $error_message = "Username and password already exist. Please try logging in.";
    } else {
        // Insert the new user into the login table
        $sql = "INSERT INTO login (username, password) VALUES ('$username', '$password')";

        if (mysqli_query($conn, $sql)) {
            // Get the ID of the new user in the login table
            $login_id = mysqli_insert_id($conn);

            // Store the login ID in session
            $_SESSION['login_id'] = $login_id;
          
            // Redirect to the user details page to collect further information
            header("Location: login2.php");
            exit();
        } else {
            $error_message = "Error: Could not register user.";
        }
    }

    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <link rel="stylesheet" href="css/login-style.css">
</head>

<body>

  <!-- Modal structure -->
  <div class="modal-overlay" id="modalOverlay">
    <div class="modal">
      <button class="close-btn" onclick="closeModal()">
        <a href="index.php" style="text-decoration: none; color: white;">×</a>
      </button>
      <h2 style="text-align: center;">Register</h2>
      <?php if (isset($error_message)) { echo "<p style='color:red;'>$error_message</p>"; } ?>
      <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="username">Username :</label>
        <input type="text" name="username" placeholder="Username" required>
        <label for="password">Password :</label>
        <input type="password" placeholder="Password" name="password" required>
        <input type="submit" name="submit" value="Register" style="cursor:pointer;color: white;border: none;border-radius: 20px;font-family: 'Poppins';background-color: #007bff;font-weight: bold;margin-top: 10px;padding: 8px 170px;font-size: 14px;padding: 10px;width: 99%;">
      </form>
    </div>
  </div>

  <script>
    // JavaScript functions to handle modal display
    function openModal() {
      document.getElementById("modalOverlay").classList.add("active");
    }
    function closeModal() {
      document.getElementById("modalOverlay").classList.remove("active");
    }
    window.onload = function() { openModal(); }
    window.onclick = function(event) {
      const modal = document.getElementById("modalOverlay");
      if (event.target == modal) { closeModal(); }
    }
  </script>
</body>
</html>
