<?php
require_once 'inc/inc.php';
use Models\User;
if (isset($_SESSION['user'])) {
    die(header("Location: /dashboard.php"));
    exit();
}

$provider = new \Discord\OAuth\Discord([
    'clientId' => $config->discordClientId,
    'clientSecret' => $config->discordClientSecret,
    'redirectUri' => $config->discordRedirectUri,
]);

$options = [
    'scope' => ['identify'],
];

if (!isset($_GET['code'])) {
    header("Location: " . $provider->getAuthorizationUrl($options));
    die();
}

$token = $provider->getAccessToken('authorization_code', [
    'code' => $_GET['code'],
]);

$user = $provider->getResourceOwner($token);

$details = [
    'id' => $user->id,
    'username' => $user->username,
    'avatar' => $user->avatar
];

$user = User::find($user->id);

if(is_null($user)) {
    $user = User::create($details);
} else {
    $user->update($details);
}


$_SESSION['user'] = $user;
header("Location: /home.php");