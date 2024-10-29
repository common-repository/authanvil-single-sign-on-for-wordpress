<?php

	function AuthAnvil_sso_config() {	
		$current_screen = add_submenu_page( 'options-general.php', 'AuthAnvil Single Sign On', 'AuthAnvil SSO', 'manage_options', 'AuthAnvil_sso_config', 'authanvil_render_config');
		
		add_settings_section('authanvil_sso', 'Configure AuthAnvil Single Sign On', 'AuthAnvil_ConfigText', 'AuthAnvil_sso_config');
		
		add_settings_field('authanvil_sso_url', 'Sign On URL', 'AuthAnvil_SignOnUrl', 'AuthAnvil_sso_config', 'authanvil_sso');
		register_setting('AuthAnvil_sso_config','authanvil_sso_url');
		
		add_settings_field('authanvil_signout_url', 'Sign Out URL', 'AuthAnvil_SignOutUrl', 'AuthAnvil_sso_config', 'authanvil_sso');
		register_setting('AuthAnvil_sso_config','authanvil_signout_url');
		
		// add_settings_field('authanvil_saml_replyto_url', 'Reply To URL', 'AuthAnvil_ReplyTo', 'AuthAnvil_sso_config', 'authanvil_sso');
		// register_setting('AuthAnvil_sso_config','authanvil_saml_replyto_url');
		
		// add_settings_field('authanvil_saml_sp_issuer', 'Service Provider Issuer', 'AuthAnvil_SpIssuer', 'AuthAnvil_sso_config', 'authanvil_sso');
		// register_setting('AuthAnvil_sso_config','authanvil_saml_sp_issuer');
		
		add_settings_field('authanvil_saml_signing_cert', 'X.509 Certificate', 'AuthAnvil_Cert_Setting', 'AuthAnvil_sso_config', 'authanvil_sso');
		register_setting('AuthAnvil_sso_config','authanvil_saml_signing_cert');
	}
	
	function AuthAnvil_SpIssuer() {
		$url = get_option('authanvil_saml_sp_issuer');
		
		if($url == '')
		{
			$url = 'urn:my:wordpress';
		}
	
		echo '<input name="authanvil_saml_sp_issuer" id="authanvil_saml_sp_issuer" class="regular-text code" style="width: 300px;" value=' . $url . '>';
	}

	function AuthAnvil_ReplyTo() {
		$url = get_option('authanvil_saml_replyto_url');
		
		if($url == '')
		{
			$url = 'https://www.mywordpresssite.com/';
		}
	
		echo '<input name="authanvil_saml_replyto_url" id="authanvil_saml_replyto_url" class="regular-text code" style="width: 600px;" value=' . $url . '>';
	}
	
	function AuthAnvil_SignOutUrl() {
		$url = get_option('authanvil_signout_url');
		
		if($url == '')
		{
			$url = 'https://corp.example.com/SSO/federation/passive/signout';
		}
	
		echo '<input name="authanvil_signout_url" id="authanvil_signout_url" class="regular-text code" style="width: 600px;" value=' . $url . '>';
	}
	
	function AuthAnvil_SignOnUrl() {
		$url = get_option('authanvil_sso_url');
		
		if($url == '')
		{
			$url = 'https://corp.example.com/SSO/federation/passive/Saml2SpInit';
		}
	
		echo '<input name="authanvil_sso_url" id="authanvil_sso_url" class="regular-text code" style="width: 600px;" value=' . $url . '>';
	}
	
	function AuthAnvil_Cert_Setting() {
		echo '<textarea name="authanvil_saml_signing_cert" id="authanvil_saml_signing_cert" style="width:550px; height:400px; font-family: Consolas, Courier, Arial">' . get_option('authanvil_saml_signing_cert') . '</textarea>';
	}
	
	function AuthAnvil_ConfigText() {
	?> 
		Configure your site for Single Sign On through the AuthAnvil Single Sign On for WordPress plugin.
	<?php
	}

	function authanvil_render_config() {
		$title = "AuthAnvil Single Sign On Settings";
		?>
			<div class="wrap">
			<div style="width: 50px; height: 50px; float: left; background: url(/wp-content/plugins/authanvil-single-sign-on-for-wordpress/shield.png) no-repeat"> &nbsp;</div>
				<h2><?php echo esc_html( $title ); ?></h2>
				<form action="options.php" method="post">

					<?php settings_fields('AuthAnvil_sso_config'); ?>
					<?php do_settings_sections('AuthAnvil_sso_config'); ?>

					<p class="submit">
						<input type="submit" name="Submit" class="button-primary" value="<?php esc_attr_e('Save Changes') ?>" />
					</p>

				</form>
			</div>
		<?php
	}

?>
