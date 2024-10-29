<?php

require_once('FederationConfig.php');

class AuthnRequest
{
    protected $Config;

    public function __construct($config)
    {
        $this->Config = $config;
    }

    public function RedirectUrl()
    {
        $id = "s_" . sha1(uniqid(mt_rand()));
        $issueInstant = $this->Timestamp();

        $request = 
<<<REQUEST
<samlp:AuthnRequest xmlns:samlp="urn:oasis:names:tc:SAML:2.0:protocol" xmlns:saml="urn:oasis:names:tc:SAML:2.0:assertion" ProtocolBinding="urn:oasis:names:tc:SAML:2.0:bindings:HTTP-POST" Version="2.0" ID="$id" IssueInstant="$issueInstant" AssertionConsumerServiceURL="{$this->Config->ReplyToUrl}"><saml:Issuer>{$this->Config->ServiceProviderIssuer}</saml:Issuer><samlp:NameIDPolicy Format="{$this->Config->NameIdFormat}"></samlp:NameIDPolicy><samlp:RequestedAuthnContext><saml:AuthnContextClassRef>urn:oasis:names:tc:SAML:2.0:ac:classes:Password</saml:AuthnContextClassRef></samlp:RequestedAuthnContext></samlp:AuthnRequest>
REQUEST;

        return $this->Config->IdpSingleSignOnUrl . "?SAMLRequest=" . urlencode(base64_encode(gzdeflate($request)));
    }

    protected function Timestamp()
    {
        $timezone = date_default_timezone_get();
        date_default_timezone_set('UTC');

        $timestamp = strftime("%Y-%m-%dT%H:%M:%SZ");
        date_default_timezone_set($timezone);
        
        return $timestamp;
    }
}

?>