<?php
include("database.php");
include("index.php");

session_start(); // Start session to store user data across pages

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_SPECIAL_CHARS);

    // SQL query to check if the entered data matches a row in the 'login' table
    $sql = "SELECT id FROM login WHERE username = '$username' AND password = '$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        // Get the row as an associative array
        $row = mysqli_fetch_assoc($result);

        // Store the 'id' column value (login ID) in session for future reference
        $_SESSION['login_id'] = $row['id'];

        // Redirect to the search page after login
        header("Location: search.php");
        exit();
    } else {
        // Set an error message if login fails
        $error_message = "Invalid username or password.";
    }

}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Modal</title>
    <link rel="stylesheet" href="css/login-style.css">
</head>

<body>

    <!-- Modal structure -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal">
            <button class="close-btn" onclick="closeModal()">
                <a href="index.php" style="text-decoration: none; color: white;">×</a>
            </button>
            <h2 style="text-align: center;">Login</h2>
            <?php if (isset($error_message)) {
                echo "<p style='color:red;'>$error_message</p>";
            } ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="username">Username :</label>
                <input type="text" name="username" placeholder="Username" required>
                <label for="password">Password :</label>
                <input type="password" placeholder="Password" name="password" required>
                <input type="submit" name="submit" value="Login" style="color: white; border: none; border-radius: 20px; font-family: 'Poppins'; background-color: #007bff; font-weight: bold; margin-top: 10px; padding: 8px 180px; font-size: 14px;">
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
        window.onload = function() {
            openModal();
        }
        window.onclick = function(event) {
            const modal = document.getElementById("modalOverlay");
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>

</html>
