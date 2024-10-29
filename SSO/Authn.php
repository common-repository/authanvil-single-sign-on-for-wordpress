<?php
define('SamlDir', ABSPATH . '/wp-content/plugins/authanvil-single-sign-on-for-wordpress/SSO/Saml/');

require_once SamlDir . 'FederationConfig.php';
require_once SamlDir . 'AuthnRequest.php';
require_once SamlDir . 'SamlResponse.php';
require_once SamlDir . 'TokenValidator.php';
require_once SamlDir . 'xmlseclibs.php';

function Authenticate()
{
	$config = new FederationConfig();
	$config->IdpSingleSignOnUrl = get_option('authanvil_sso_url');
	$config->IdPSignOutUrl = get_option('authanvil_signout_url');
	$config->IdPSigningKey = get_option('authanvil_saml_signing_cert');
	$config->ReplyToUrl =  get_option('authanvil_saml_replyto_url');
	$config->ServiceProviderIssuer = get_option('authanvil_saml_sp_issuer');

	$samlResponse = new SamlResponse($config, $_POST['SAMLResponse']);
	$validToken = $samlResponse->IsTokenValid();
	
	if($validToken)
	{
		require_once(ABSPATH . WPINC . '/registration.php');
		require_once(ABSPATH . WPINC . '/pluggable.php');
		
		$email = $samlResponse->NameId();
		
		if ($email) 
		{	
			if(email_exists($email))
			{
				global $current_user;
				get_currentuserinfo();
				
				wp_set_current_user(email_exists($email));
				wp_set_auth_cookie(email_exists($email));
				do_action('wp_login', email_exists($email));
				wp_redirect("wp-admin/");
				exit;
			}
			else
			{
			echo 'Email address not found';
			}
		} 
		 else 
		 {
			echo 'Could not parse Email Address from NameId';
			return false;
		 }
	}
	else
	{
		echo 'Didn\'t like the SAML Response';
		return false;
	}
}
?>