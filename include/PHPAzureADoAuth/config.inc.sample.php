<?php
// MySQL connection details
define('_MYSQL_HOST', 'db.example.local');
define('_MYSQL_USER', 'db_user');
define('_MYSQL_DB', 'db_name');
define('_MYSQL_PASS', 'db_password');

// oAuth details
// TENANTID: Your tenant's ID if you set up the app reg as single tenant, otherwise 'common'
define('_OAUTH_TENANTID', 'YOUR_TENANT_ID');
define('_OAUTH_CLIENTID', 'YOUR_CLIENT_ID');
define('_OAUTH_LOGOUT', 'https://login.microsoftonline.com/common/wsfederation?wa=wsignout1.0');
define('_OAUTH_SCOPE', 'openid%20offline_access%20profile%20user.read');

// Define either the client secret, or the client certificate details
// method = 'certificate' or 'secret'
define('_OAUTH_METHOD', 'secret');
define('_OAUTH_SECRET', 'YOUR_CLIENT_SECRET');
define('_OAUTH_AUTH_CERTFILE', '/path/to/certificate.crt');
define('_OAUTH_AUTH_KEYFILE', '/path/to/privatekey.pem');

// URL to this website, no trailing slash.
define('_URL', 'https://sandstorm.park.rtvutrecht.nl');
?>
