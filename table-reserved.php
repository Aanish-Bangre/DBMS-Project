<?php
include("database.php");
include("navbar2.html");

session_start();

// Get session variables
$login_id = $_SESSION['login_id'];
$restaurant_id = $_SESSION['restaurant_id'];
$reservation_id = $_SESSION['reservation_id'];

$user_sql = "SELECT * FROM user WHERE id = '$login_id'";
$user_result = mysqli_query($conn, $user_sql);
$user = mysqli_fetch_assoc($user_result);

// Fetch restaurant details
$restaurant_sql = "SELECT * FROM restaurantcafe WHERE Restaurant_ID = '$restaurant_id'";
$restaurant_result = mysqli_query($conn, $restaurant_sql);
$restaurant = mysqli_fetch_assoc($restaurant_result);

// Fetch reservation details
$reservation_sql = "SELECT * FROM tablereservation WHERE Reservation_ID = '$reservation_id'";
$reservation_result = mysqli_query($conn, $reservation_sql);
$reservation = mysqli_fetch_assoc($reservation_result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Table Reserved</title>
    <link rel="stylesheet" href="css/table-reserved.css">
</head>

<body>
    <div class="reservation-container">
        <h1>Table Reserved Successfully</h1>

        <div class="user-info">
            <p><strong>User ID:</strong> <?php echo $user['id']; ?></p>
            <p><strong>Name :</strong> <?php echo $user['full_name']; ?></p>
            <p><strong>Contact Number:</strong> <?php echo $user['phone_number']; ?></p>
        </div>

        <div class="restaurant-info">
            <h2>Restaurant Details</h2>
            <p><strong>Restaurant Name:</strong> <?php echo $restaurant['Name']; ?></p>
            <p><strong>Location:</strong> <?php echo $restaurant['Location']; ?></p>
            <p><strong>Cuisine Type:</strong> <?php echo $restaurant['Cuisine']; ?></p>
        </div>

        <div class="reservation-info">
            <h2>Reservation Details</h2>
            <p><strong>Reservation ID:</strong> <?php echo $reservation['Reservation_ID']; ?></p>
            <p><strong>No. of Guests:</strong> <?php echo $reservation['No_of_guests']; ?></p>
            <p><strong>Date:</strong> <?php echo $reservation['Date']; ?></p>
            <p><strong>Time:</strong> <?php echo $reservation['Time']; ?></p>
        </div>

        <p class="success-message">Your table has been reserved successfully at <?php echo $restaurant['Name']; ?>. We look forward to hosting you!</p>
    </div>
</body>

</html>
