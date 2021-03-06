<?php
session_start();
require_once __DIR__ . '/src/Facebook/autoload.php';
$fb = new Facebook\Facebook([
  'app_id' => '179487512408545',
  'app_secret' => '8a1045e3c2f1e7a3936749fd84236308',
  'default_graph_version' => 'v2.4',
  ]);
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // optional
	
if (isset($_SESSION['facebook_access_token'])) {
        $accessToken = $_SESSION['facebook_access_token'];
} else {
        $accessToken = $helper->getAccessToken();
}
if (isset($accessToken)) {
	if (isset($_SESSION['facebook_access_token'])) {
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	} else {
		// getting short-lived access token
		$_SESSION['facebook_access_token'] = (string) $accessToken;
	  	// OAuth 2.0 client handler
		$oAuth2Client = $fb->getOAuth2Client();
		// Exchanges a short-lived access token for a long-lived one
		$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
		$_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
		// setting default access token to be used in script
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	}

		$profile_request = $fb->get('/me?fields=name,first_name,last_name,email');
		$pages_request = $fb->get('/me/accounts?fields=name,access_token,perms');
                                
		$profile = $profile_request->getGraphNode()->asArray();
		$pages = $pages_request->getGraphEdge()->asArray();
                foreach ($pages as $page) {
                  $pageAccessToken = $page['access_token'];
                  // Store $pageAccessToken and/or
                  // send requests to Graph on behalf of the page
                }  
                $linkData = [
                  'message' => 'User provided message (último)'                     
                  ];                 
                $response2 = $fb->post("/1673807476233899/feed", $linkData, $pageAccessToken[0]);

	var_dump($profile);
        echo "<br>";
        echo "<br>";
        echo "access token: ".$pageAccessToken[0];
        echo "<br>";
        var_dump($pageAccessToken);
  	// Now you can redirect to another page and use the access token from $_SESSION['facebook_access_token']
} else {
	// replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here
	$loginUrl = $helper->getLoginUrl('http://localhost/Ecommerce/trunk/public_html/fblogin-v5/login.php', $permissions);
	echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
}

