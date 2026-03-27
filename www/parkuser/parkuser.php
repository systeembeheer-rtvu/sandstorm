<?php
require_once("/mnt/data/include/config.inc.php");
require_once("/mnt/data/include/mysqli.inc.php");
$dbh = new sql;
$dbh -> connect();
	echo "<pre>";

	if ($_SERVER['REMOTE_ADDR']!="172.17.16.41") { // if stampida then no azure auth
		include '/mnt/data/include/PHPAzureADoAuth/auth.php';
		$Auth = new modAuth();
		include '/mnt/data/include/PHPAzureADoAuth/graph.php';
		$Graph = new modGraph();
	
		if (!$Auth->checkUserRole('Task.Admin')) {
			echo "Computer says no!";
			exit;
		}
	}

        include("graph_mailer.php");
        include("parkuser.inc.php");
        
        $graphMailer = new graphMailer($TenantID,$ClientID,$ClientSecret);

        $upn = $_GET['upn'];
        
        if (!preg_match('/\A[.\w-]*@rtvutrecht\.nl\z/i', $upn)) {
		echo "Geen geldige UPN!";
		exit;
	}
        
        $upn = urlencode($upn);

        // uitlezen user telefoonnummer
        // https://learn.microsoft.com/en-us/graph/api/resources/user?view=graph-rest-1.0
        $user = $graphMailer->sendGetRequest($graphMailer->baseURL."users/$upn");
        // var_dump($user);
        $userArray = json_decode($user);
        //echo "user\n";
        //var_dump($userArray);

        $code = @$userArray->error->code;
        if ($code == "Request_ResourceNotFound") {
            // fout
            echo "User niet gevonden!\n";
            exit;
        }
        $phone = $userArray->mobilePhone;

        if (!preg_match('/\+31 6\d{8}/si', $phone)) {
            echo "Geen geldig telefoonnummer $phone\n";
            exit;
        }

        $authArray = array(); // toevoegen nummer
        $authArray['phoneNumber'] = $phone;
        $authArray['phoneType'] = "mobile";
        $authJSON = json_encode($authArray);
        // https://learn.microsoft.com/en-us/graph/api/authentication-post-phonemethods?view=graph-rest-1.0&tabs=http
        $response = $graphMailer->sendPostRequest($graphMailer->baseURL."users/$upn/authentication/phoneMethods", $authJSON, array('Content-type: application/json'));

        var_dump($response);

        $authArray = array(); // aanpassen nummer voor het geval het al bestaat.
        $authArray['phoneNumber'] = $phone;
        $authJSON = json_encode($authArray);
        // https://learn.microsoft.com/en-us/graph/api/phoneauthenticationmethod-update?view=graph-rest-1.0&tabs=http
        $response = $graphMailer->sendPatchRequest($graphMailer->baseURL."users/$upn/authentication/phoneMethods/3179e48a-750b-4051-897c-87b9720928f7", $authJSON, array('Content-type: application/json'));

        var_dump($response);
        
        $userId = $userArray->id;
        $group = "cdb2eb5c-8e4c-43ea-9188-6923df86e4b5"; // teams group
        $addArray = array(
        	'@odata.id'=>"https://graph.microsoft.com/v1.0/users/$userId"
        );
        $addJSON = json_encode($addArray);
        
        $response = $graphMailer->sendPostRequest($graphMailer->baseURL."groups/$group/members/\$ref", $addJSON, array('Content-type: application/json'));
        echo "Add to group";
        var_dump($addArray);
        var_dump($response);
        
        
        $usageArray = array();
        $usageArray['UsageLocation'] = "NL";
        $usageJSON = json_encode($usageArray);
        // https://learn.microsoft.com/en-us/graph/api/user-update?view=graph-rest-1.0&tabs=http
        $response = $graphMailer->sendPatchRequest($graphMailer->baseURL."users/$upn", $usageJSON, array('Content-type: application/json'));
        //var_dump($response);

        $licensesJSON = '{"addLicenses":[{"disabledPlans":[],"skuId":"3b555118-da6a-4418-894f-7df1e2096870"}],"removeLicenses":[]}'; // business essentials
        // https://learn.microsoft.com/en-us/graph/api/user-assignlicense?view=graph-rest-1.0&tabs=http
        $response = $graphMailer->sendPostRequest($graphMailer->baseURL."users/$upn/assignLicense", $licensesJSON, array('Content-type: application/json'));
        //var_dump($response);

        $licensesJSON = '{"addLicenses":[{"disabledPlans":[],"skuId":"c2273bd0-dff7-4215-9ef5-2c7bcfb06425"}],"removeLicenses":[]}'; // office pro
        // https://learn.microsoft.com/en-us/graph/api/user-assignlicense?view=graph-rest-1.0&tabs=http
        $response = $graphMailer->sendPostRequest($graphMailer->baseURL."users/$upn/assignLicense", $licensesJSON, array('Content-type: application/json'));
        //var_dump($response);
        
        echo "</pre>";
?>