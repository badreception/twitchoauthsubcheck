<?php
// login.php
// Version: 1.1

/**
 * Redirects the user to Twitch's OAuth authorization page.
 */

session_start();

$client_id = 'clientidhere';
$redirect_uri = 'redirecturihere';
$scope = 'user:read:subscriptions';

// Twitch OAuth authorization endpoint
$auth_url = 'https://id.twitch.tv/oauth2/authorize' .
    '?response_type=code' .
    '&client_id=' . $client_id .
    '&redirect_uri=' . urlencode($redirect_uri) .
    '&scope=' . urlencode($scope);

// Redirect the user to Twitch's authorization page
header('Location: ' . $auth_url);
exit();
?>
