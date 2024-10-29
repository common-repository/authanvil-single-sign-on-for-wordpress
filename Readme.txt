=== AuthAnvil Single Sign On for WordPress ===
Contributors: SteveS
Tags: Authentication, Single Sign On, SAML, AuthAnvil
Requires at least: 3.4
Tested up to: 3.4
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==

With a single click you can sign into WordPress with AuthAnvil Single Sign On. We provide a portal for users to access applications quickly and securely with the SAML protocol and our Two Factor Auth server. This plugin enables WordPress to accept SAML tokens and is preconfigured for AuthAnvil Single Sign On.

== Installation ==

1. Place the 'AuthAnvil' folder (this current directory) in your '/wp-content/plugins' directory

2. Activate the AuthAnvil Single Sign On plugin

3. Configure the authentication provider settings undert Settings > AuthAnvil SSO
	- Replace the hostname of the Sign On URL with the hostname of your AuthAnvil SSO server
	- Replace the hostname of the Sign Out URL with the hostname of your AuthAnvil SSO server

4. From within the AuthAnvil SSO Manager navigate to the Applications section and create a new Application
	- Set the public name for the application. This will be the publically visible name within the portal.
	- Set the reply to URL as your WordPress site. E.g. https://blog.mysite.com/
	- Set the Audience URI to be the same as your Reply To URL
	- Configure the icon you want to use, or leave it blank and it will be set with a default. Within the directory of this readme file is a png file you can use as well.
	- Save the application and navigate back into the application you just created
	- Click "Edit Attribute Maps" and create a new map. The attribute name should be "http://schemas.xmlsoap.org/ws/2005/05/identity/claims/name" without the quotes and the value should be "{Email}" without the quotes
	- Save the map and close the window
	- Within the application settings download the signing certificate and open the *.cer file
	- Within the Certificate window navigate to the Details tab and click Copy to File...
	- Save the certificate as Base-64 encoded X.509 (.CER)
	- Open the newly created *.cer file in a text editor. You should see the first line begin with 
		-----BEGIN CERTIFICATE-----

	- Copy the entire contents of the file including the Begin/End headers into the X.509 Certificate setting field in the WordPress settings page.

5. Configure access to your WordPress application in AuthAnvil SSO by adding it to a role.

6. Log in from AuthAnvil Single Single Sign On

For more information on configuring WordPress and AuthAnvil Single Sign On check out http://www.scorpionsoft.com/docs/sso/wordpress.

== Frequently Asked Questions ==

= Where can I find out more information about AuthAnvil? =

Learn about AuthAnvil at http://www.scorpionsoft.com/sso/tour/intro

= Are there any special requirements for my WordPress/PHP installation? =

PHP5 or later.


== Screenshots ==

1. WordPress plugin configuration page
2. AuthAnvil SSO Manager application configuration page
3. AuthAnvil SSO Manager application attribute map window