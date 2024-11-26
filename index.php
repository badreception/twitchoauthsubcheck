<?php
// index.php
// Version: 1.1

/**
 * Homepage with a link to initiate Twitch login.
 * Updated to remove .php extension from links.
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login with Twitch</title>
    <style>
        /* Styling for the Twitch login button */
        .twitch-button {
            background-color: #6441A4;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-family: Arial, sans-serif;
        }
        .twitch-button:hover {
            background-color: #7d5bbe;
        }
    </style>
</head>
<body>
    <h1>Login with Twitch</h1>
    <!-- Updated link without .php extension -->
    <a href="login" class="twitch-button">Login with Twitch</a>
</body>
</html>
