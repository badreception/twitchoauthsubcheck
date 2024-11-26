<?php
// callback.php
// Version: 1.3

/**
 * This script handles the OAuth callback from Twitch.
 * It exchanges the authorization code for an access token,
 * retrieves the user's Twitch ID, and checks if the user is
 * subscribed.
 *
 * It then redirects the user to a clean URL without query parameters.
 * 
 * Important:
 * - The 'client_secret' is retrieved from an environment variable for security.
 * - Ensure that 'TWITCH_CLIENT_SECRET' is set in your server's environment.
 */

session_start();

// Twitch application credentials
$client_id = 'clientid'; // Your client_id
$client_secret = getenv('TWITCH_CLIENT_SECRET'); // Retrieve from environment variable
$redirect_uri = 'redirecturi'; // Your redirect_uri

// Twitch User ID
$broadcaster_id = 'replacethis'; // Twitch User ID

// Check if 'code' is returned in the query parameters
if (isset($_GET['code'])) {
    $code = $_GET['code'];

    // Exchange the authorization code for an access token
    $token_url = 'https://id.twitch.tv/oauth2/token';

    $post_fields = [
        'client_id'     => $client_id,
        'client_secret' => $client_secret,
        'code'          => $code,
        'grant_type'    => 'authorization_code',
        'redirect_uri'  => $redirect_uri
    ];

    // Initialize cURL session for token exchange
    $ch = curl_init($token_url);
    curl_setopt($ch, CURLOPT_POST, true); // Set request method to POST
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_fields)); // Set POST fields
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string

    // Execute the POST request
    $token_response = curl_exec($ch);

    // Check for cURL errors
    if ($token_response === false) {
        // Handle cURL error
        echo 'Error: ' . curl_error($ch);
        curl_close($ch);
        exit();
    }

    curl_close($ch);

    // Decode the JSON response to get the access token
    $token_data = json_decode($token_response, true);

    if (isset($token_data['access_token'])) {
        $access_token = $token_data['access_token'];

        // Store the access token in the session
        $_SESSION['access_token'] = $access_token;

        // Redirect to the same page without query parameters
        header('Location: ' . $redirect_uri);
        exit();
    } else {
        // Handle error if access token is not obtained
        echo 'Error: Unable to obtain access token.';
        // Optionally, display the error description
        if (isset($token_data['message'])) {
            echo '<br>Error Message: ' . htmlspecialchars($token_data['message']);
        }
        exit();
    }
} elseif (isset($_SESSION['access_token'])) {
    // Access token is available in session
    $access_token = $_SESSION['access_token'];

    // Get the user's Twitch ID
    $user_info_url = 'https://api.twitch.tv/helix/users';

    // Set the required headers for the API request
    $headers = [
        'Authorization: Bearer ' . $access_token,
        'Client-ID: ' . $client_id
    ];

    // Initialize cURL session to get user information
    $ch = curl_init($user_info_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // Set headers
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string

    // Execute the GET request
    $user_info_response = curl_exec($ch);

    // Check for cURL errors
    if ($user_info_response === false) {
        // Handle cURL error
        echo 'Error: ' . curl_error($ch);
        curl_close($ch);
        exit();
    }

    curl_close($ch);

    // Decode the JSON response to get user data
    $user_info = json_decode($user_info_response, true);

    if (isset($user_info['data'][0]['id'])) {
        $user_id = $user_info['data'][0]['id'];

        // Check if the user is subscribed to channel
        $subscription_url = 'https://api.twitch.tv/helix/subscriptions/user' .
            '?broadcaster_id=' . $broadcaster_id .
            '&user_id=' . $user_id;

        // Initialize cURL session to check subscription status
        $ch = curl_init($subscription_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // Set headers
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string

        // Execute the GET request
        $subscription_response = curl_exec($ch);

        // Check for cURL errors
        if ($subscription_response === false) {
            // Handle cURL error
            echo 'Error: ' . curl_error($ch);
            curl_close($ch);
            exit();
        }

        curl_close($ch);

        // Decode the JSON response to get subscription data
        $subscription_info = json_decode($subscription_response, true);

        // Check if the 'data' field is present and not empty
        if (isset($subscription_info['data'][0])) {
            // User is subscribed
            echo '<h1>You are subscribed!</h1>';
        } else {
            // User is not subscribed
            echo '<h1>You are not subscribed.</h1>';
        }
    } else {
        // Handle error if user information is not retrieved
        echo 'Error: Unable to retrieve user information.';
        // Optionally, display the error description
        if (isset($user_info['message'])) {
            echo '<br>Error Message: ' . htmlspecialchars($user_info['message']);
        }
    }
} else {
    // No code or access token available, redirect to login
    echo 'Error: Authorization required.';
    echo '<br><a href="login">Click here to log in with Twitch.</a>';
}
?>
