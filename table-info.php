<?php
ob_start(); // Start output buffering

include("database.php");
include("search.php");

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$login_id = $_SESSION['login_id'];
$restaurant_id = $_SESSION['restaurant_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get input values from form and store them in PHP variables
    $number_of_guests = filter_input(INPUT_POST, "number_of_guests", FILTER_SANITIZE_NUMBER_INT);
    $date = filter_input(INPUT_POST, "date", FILTER_SANITIZE_SPECIAL_CHARS);
    $time = filter_input(INPUT_POST, "time", FILTER_SANITIZE_SPECIAL_CHARS);

    // Insert reservation details into tablereservation table
    $sql = "INSERT INTO tablereservation (Restaurant_ID, id, No_of_guests, Date, Time)
            VALUES ('$restaurant_id', '$login_id', '$number_of_guests', '$date', '$time')";

    if (mysqli_query($conn, $sql)) {
        // Store the Reservation_ID in the session
        $_SESSION['reservation_id'] = mysqli_insert_id($conn);

        // Redirect to the table-reserved.php page
        header("Location: table-reserved.php");
        
        exit(); // Ensure no further code is executed
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}

ob_end_flush(); // Flush the output buffer and send output
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Reservation</title>
    <link rel="stylesheet" href="css/reservation.css">
</head>

<body>

    <!-- Modal structure -->
    <div class="modal-overlay" id="modalOverlay">
        <div class="modal">
            <button class="close-btn" onclick="closeModal()">×</button>
            <h2 style="text-align: center;">Book a Table</h2>

            <form class="reservation-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <label for="number_of_guests">No. of Guests:</label>
                <input style="padding:5px;" type="number" name="number_of_guests" placeholder="Enter no. of guests" required>

                <label for="date">Date:</label>
                <input style="padding:5px;" type="date" name="date" required>

                <label for="time">Time:</label>
                <input style="padding:5px;" type="time" name="time" required>

                <input type="submit" name="submit" value="Reserve Table" class="reserve-table-btn" style="cursor:pointer;color: white; border: none; border-radius: 20px; font-family: 'Poppins'; background-color: #9b2015; font-weight: bold; margin-top: 10px; padding: 8px 180px; font-size: 14px;">
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
