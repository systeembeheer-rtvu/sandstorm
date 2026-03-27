<?php
/* oauth.php Azure AD oAuth web callback script
 *
 * Katy Nicholson, last updated 17/11/2021
 *
 * https://github.com/CoasterKaty
 * https://katytech.blog/
 * https://twitter.com/coaster_katy
 *
 */

include '/mnt/data/include/PHPAzureADoAuth/auth.php';
require_once '/mnt/data/include/PHPAzureADoAuth/oauth.php';

session_start();
$oAuth = new modOAuth();
if ($_GET['error']) {
	echo $oAuth->errorMessage($_GET['error_description']);
	exit;
}

//retrieve session data from database
$stmt = $dbauth->do_placeholder_query('SELECT * FROM tblAuthSessions WHERE txtSessionKey = ?', [$_SESSION['sessionkey']], __LINE__, __FILE__);
$sessionData = $dbauth->fetch_assoc($stmt);

if ($sessionData) {
    // Request token from Azure AD
	$oauthRequest = $oAuth->generateRequest('grant_type=authorization_code&client_id=' . _OAUTH_CLIENTID . '&redirect_uri=' . urlencode(_URL . '/oauth.php') . '&code=' . $_GET['code'] . '&code_verifier=' . $sessionData['txtCodeVerifier']);

	$response = $oAuth->postRequest('token', $oauthRequest);

	// Decode response from Azure AD. Extract JWT data from supplied access_token and id_token and update database.
	if (!$response) {
		echo $oAuth->errorMessage('Unknown error acquiring token');
		exit;
	}
	$reply = json_decode($response);
	if (@$reply->error) {
		echo $oAuth->errorMessage($reply->error_description);
		exit;
	}

	$idToken = base64_decode(explode('.', $reply->id_token)[1]);
	$dbauth->do_placeholder_query(
		'UPDATE tblAuthSessions SET txtToken = ?, txtRefreshToken = ?, txtIDToken = ?, txtRedir = ?, dtExpires = ? WHERE intAuthID = ?',
		[$reply->access_token, $reply->refresh_token, $idToken, '', date('Y-m-d H:i:s', strtotime('+' . $reply->expires_in . ' seconds')), $sessionData['intAuthID']],
		__LINE__, __FILE__
	);
	// Redirect user back to where they came from.
	header('Location: ' . $sessionData['txtRedir']);
} else {
	header('Location: /');
}
?>
