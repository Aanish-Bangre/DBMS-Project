<?php
include("navbar2.html");
include("database.php");

session_start(); // Ensure session is started at the top of the page

// Check if the user details are available in the session
if (isset($_SESSION['full_name'])) {
    $full_name = $_SESSION['full_name'];
} else {
    echo "User details not available. Please go back and enter your details.";
    exit();
}

// Initialize variables to store form data
$location = $cuisine = $budget = $rating = $ambience = "";

// Check if the "Reserve Table" form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Store the restaurant_id in session (if passed)
    if (isset($_POST['restaurant_id'])) {
        $_SESSION['restaurant_id'] = $_POST['restaurant_id'];  // Store Restaurant_ID in session
    }

    // Store the search criteria with isset() to avoid undefined array key warnings
    $location = isset($_POST["location"]) && $_POST["location"] !== "None" ? filter_input(INPUT_POST, "location", FILTER_SANITIZE_SPECIAL_CHARS) : "";
    $cuisine = isset($_POST["cuisine"]) && $_POST["cuisine"] !== "None" ? filter_input(INPUT_POST, "cuisine", FILTER_SANITIZE_SPECIAL_CHARS) : "";
    $budget = isset($_POST["budget"]) && $_POST["budget"] !== "None" ? filter_input(INPUT_POST, "budget", FILTER_SANITIZE_SPECIAL_CHARS) : "";
    $rating = isset($_POST["rating"]) && $_POST["rating"] !== "any" ? filter_input(INPUT_POST, "rating", FILTER_SANITIZE_SPECIAL_CHARS) : "";
    $ambience = isset($_POST["ambience"]) && $_POST["ambience"] !== "None" ? filter_input(INPUT_POST, "ambience", FILTER_SANITIZE_SPECIAL_CHARS) : "";

    // Build the SQL query with only the provided criteria
    $query = "SELECT * FROM restaurantcafe WHERE 1=1";
    if (!empty($location)) $query .= " AND Location = '$location'";
    if (!empty($cuisine)) $query .= " AND Cuisine = '$cuisine'";
    if (!empty($budget)) $query .= " AND Budget = '$budget'";
    if (!empty($ambience)) $query .= " AND Ambiance = '$ambience'";
    if (!empty($rating)) $query .= " AND Rating >= '$rating'";

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Check for query errors
    if (!$result) {
        echo "Error: " . mysqli_error($conn);
    }

    // Redirect to table-info.php with restaurant_id if set
    if (isset($_POST['restaurant_id'])) {
        header("Location: table-info.php?restaurant_id=" . $_POST['restaurant_id']);
        exit();
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search for Your Restaurant</title>
    <link rel="stylesheet" href="css/search.css">
</head>

<body>
    <div id="main-landing-page-content">
        <div id="landing-page-image">
            <img src="assets/img/landing-page-img.svg" alt="" width="500px">
        </div>
        <div id="landing-page-text-content">
            <p></p>
            <p>Welcome</p>
            <p>Book your next unforgettable dining experience with ease. Fresh flavors, vibrant atmosphere, and a table
                waiting just for you.</p>
        </div>
    </div>

    <hr style="margin: 0;">
    <div id="search-restaurant">
        <h1 style="font-weight: bolder; text-align: center; font-size: 50px;">
            Search Your <br> Restaurant
        </h1>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="search-form">
            <!-- Existing form fields for search criteria -->
            <label for="location">Location</label>
            <select id="location" name="location">
                <option value="None">None</option>
                <option value="Mira Road">Mira Road</option>
                <option value="Worli">Worli</option>
                <option value="Versova">Versova</option>
                <option value="Bandra">Bandra</option>
                <option value="Juhu">Juhu</option>
                <option value="Andheri">Andheri</option>
                <option value="Colaba">Colaba</option>
                <option value="Lower Parel">Lower Parel</option>
                <option value="Powai">Powai</option>
                <option value="Santacruz">Santacruz</option>
                <option value="Chembur">Chembur</option>
            </select>

            <label for="cuisine">Cuisine</label>
            <select name="cuisine" id="cuisine">
                <option value="None">None</option>
                <option value="Indian">Indian</option>
                <option value="Seafood">Seafood</option>
                <option value="Continental">Continental</option>
                <option value="Italian">Italian</option>
                <option value="Barbecue">Barbecue</option>
                <option value="Mexican">Mexican</option>
                <option value="Thai">Thai</option>
                <option value="Chinese">Chinese</option>
                <option value="Vegan">Vegan</option>
                <option value="Fusion">Fusion</option>
                <option value="Mediterranean">Mediterranean</option>
                <option value="Japanese">Japanese</option>
                <option value="Street Food">Street Food</option>
                <option value="American">American</option>
                <option value="Mughlai">Mughlai</option>
                <option value="Indonesian">Indonesian</option>
                <option value="Spanish">Spanish</option>
                <option value="Bakery">Bakery</option>
            </select>

            <label for="budget">Budget</label>
            <select id="budget" name="budget">
                <option value="None">None</option>
                <option value="Affordable">Affordable</option>
                <option value="Moderate">Moderate</option>
                <option value="Expensive">Expensive</option>
            </select>
            <label for="rating">Rating</label>
            <select id="rating" name="rating">
                <option value="any">Any</option>
                <option value="3">3+ stars</option>
                <option value="4">4+ stars</option>
                <option value="5">5 stars</option>
            </select>
            <label for="ambience">Ambience</label>
            <select name="ambience" id="ambience">
                <option value="None">None</option>
                <option value="Kezual">Kezual</option>
                <option value="Luxury">Luxury</option>
                <option value="Romantic">Romantic</option>
                <option value="Modern">Modern</option>
                <option value="Elegant">Elegant</option>
                <option value="Rustic">Rustic</option>
                <option value="Cozy">Cozy</option>
                <option value="Exotic">Exotic</option>
                <option value="Tranquil">Tranquil</option>
                <option value="Lively">Lively</option>
                <option value="Casual">Casual</option>
            </select>

            <input type="submit" class="submit-btn" value="Search">
        </form>
    </div>

    <hr style="margin: 0;">
    <div class="restaurant-list">
        <h2 style="font-size: 40px;">Recommended Restaurants -</h2>

        <?php if (isset($result) && mysqli_num_rows($result) > 0): ?>
            <div class="list-flex">
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <div class="restaurant-item">
                        <div class="restaurant-info-block">
                            <div class="mainlogo">
                                <img src="assets/img/mainlogo.svg" alt="">
                            </div>
                            <div class="restaurant-info">
                                <div class="restaurant-name">Name: <?php echo htmlspecialchars($row['Name']); ?></div>
                                <div class="restaurant-location">Location: <?php echo htmlspecialchars($row['Location']); ?></div>
                                <div class="restaurant-cuisine">Cuisine: <?php echo htmlspecialchars($row['Cuisine']); ?></div>
                                <div class="restaurant-budget">Budget: <?php echo htmlspecialchars($row['Budget']); ?></div>
                                <div class="restaurant-rating">Rating: <?php echo htmlspecialchars($row['Rating']); ?> stars</div>
                                <div class="restaurant-ambience">Ambience: <?php echo htmlspecialchars($row['Ambiance']); ?></div>

                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" style="margin-top: 10px;">
                                    <input type="hidden" name="restaurant_id" value="<?php echo htmlspecialchars($row['Restaurant_ID']); ?>">
                                    <input type="submit" value="Reserve Table" class="reserve-btn">
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No restaurants match your criteria. Please try different search options.</p>
        <?php endif; ?>
    </div>
</body>

</html>