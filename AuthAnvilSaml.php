<?php
/*
Plugin Name: AuthAnvil Single Sign On for WordPress
Plugin URI: http://www.scorpionsoft.com/sso
Description: Sign into Wordpress with AuthAnvil Single Sign On
Author: Scorpion Software Corp.
Version: 1.2
Author URI: http://www.scorpionsoft.com
*/

	// check for posted SAML Response
	if (isset($_POST["SAMLResponse"])) {
		add_action('init','HookSaml');
	}

	function HookSaml()
	{
		require_once(ABSPATH . '/wp-content/plugins/authanvil-single-sign-on-for-wordpress/SSO/Authn.php');
		Authenticate();
	}

	// add menu option for configuration
	add_action('admin_menu', 'ConfigureAuthAnvilSingleSignOnMenu');

	function ConfigureAuthAnvilSingleSignOnMenu() {
		require_once(ABSPATH . '/wp-content/plugins/authanvil-single-sign-on-for-wordpress/SSO/Config.php');
		AuthAnvil_sso_config();
	}

?>
