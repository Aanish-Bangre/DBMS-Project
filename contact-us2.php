<?php
include("navbar2.html");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Cuisine Compass</title>
    <style>
    
        .container {
            position: relative;
            z-index: 100;
            max-width: 800px;
            margin: 30px auto;
            background: #ffffff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #0056b3;
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 1rem;
        }

        p {
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 1.1em;
        }

        .contact-info {
            margin-bottom: 2rem;
        }

        .contact-info h2 {
            font-size: 1.8em;
            color: #444;
            border-bottom: 2px solid #0056b3;
            padding-bottom: 0.3rem;
            margin-bottom: 1rem;
        }

        .contact-info ul {
            list-style: none;
            font-size: 1.1em;
        }

        .contact-info ul li {
            margin-bottom: 1rem;
        }

        .form-container {
            margin-top: 2rem;
        }

        .form-group {
            margin-bottom: 1.2rem;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 1em;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button {
            width: 100%;
            padding: 0.8rem;
            font-size: 1em;
            color: #ffffff;
            background-color: #0056b3;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #004494;
        }

        footer {
            text-align: center;
            margin-top: 2rem;
            font-size: 0.9em;
            color: #666;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Contact Us</h1>
        <p>We’d love to hear from you! Reach out with any questions, feedback, or inquiries about <strong>Cuisine Compass</strong>.</p>

        <div class="contact-info">
            <h2>Contact Information</h2>
            <ul>
                <li><strong>Email:</strong> support@cuisinecompass.com</li>
                <li><strong>Phone:</strong> +919833121566</li>
            </ul>
        </div>

        <div class="form-container">
            <h2>Send Us a Message</h2>
            <form action="submit_form.php" method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" required></textarea>
                </div>
                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 Cuisine Compass. All rights reserved.</p>
    </footer>

</body>

</html>