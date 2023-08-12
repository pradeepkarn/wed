<?php

use Google\Service\Oauth2;

class Google_auth_ctlr
{
  function get_google_login_url()
  {
    // Create Google API client object
    $gClient = new Google_Client();
    // $gClient->setApplicationName('Wedding');
    $gClient->setClientId(GOOGLE_CLIENT_ID);
    $gClient->setClientSecret(GOOGLE_CLIENT_SECRET);
    $gClient->setRedirectUri(GOOGLE_REDIRECT_URL);
    $gClient->addScope('email');
    $gClient->addScope('profile');

    // Set scope
    // $gClient->setScopes([
    //   'email'
    // ]);

    // Generate Google Sign in button
    return $gClient->createAuthUrl();
  }

  function sign_up_or_login()
  {
    $gClient = new Google_Client();
    if (isset($_GET['code'])) {
      $token = $gClient->fetchAccessTokenWithAuthCode($_GET['code'], GOOGLE_CLIENT_ID);
      if (!isset($token['error'])) {
        $gClient->setAccessToken($token['access_token']);

        // Get user details from Google API
        $oauth2Service = new Oauth2($gClient);
        $userData = $oauth2Service->userinfo->get();
        // Extract user details
        $_SESSION['access_token'] = $token;
        return array(
          'googleUserId' => $userData->getId(),
          'googleEmail' => $userData->getEmail(),
          'googleName' => $userData->getName(),
          'googleProfilePicture' => $userData->getPicture()
        );
      } else {
        echo $token['error_description'];
      }
    }
  }
}
